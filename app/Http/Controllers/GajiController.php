<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('karyawan')
                ->join('jabatan','karyawan.id_jabatan','=','jabatan.id_jabatan')
                ->select('karyawan.*','jabatan.nama_jabatan')
                ->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_karyawan.'" data-original-title="Edit" class="edit btn btn-primary btn-sm slipGaji">Cetak Slip Gaji</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        // view('admin.productAjax')->with('products', $products);
        // return view('admin.productAjax', $products);
        return view('admin.gaji',compact('products'));
    }
    public function slip(Request $request)
    {
        //Ambil Request
        $bulan = $request->bulan_start;
        $tahun= $request->tahun_start;
        $id_karyawan = $request->id_karyawan;

        $karyawan = DB::table('karyawan')
                    ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
                    ->select('*')
                    ->where('id_karyawan',$id_karyawan)
                    ->first();
        // Query Absensi
        $absensi = DB::table('absensi')
                ->whereYear('tgl_absensi', $tahun)
                ->whereMonth('tgl_absensi', $bulan)
                ->where('id_karyawan', $id_karyawan);

        $count_data_absensi = $absensi->count();
        $count_hadir_absensi = $absensi->where('kehadiran','=','Hadir')->count();

        $get_hadir = $absensi->where('kehadiran','Hadir')->count();
        $get_cuti =  DB::table('absensi')
                    ->whereYear('tgl_absensi', $tahun)
                    ->whereMonth('tgl_absensi', $bulan)
                    ->where('id_karyawan', $id_karyawan)
                    ->where('kehadiran','=','Cuti')->count();
        $get_sakit =  DB::table('absensi')
                    ->whereYear('tgl_absensi', $tahun)
                    ->whereMonth('tgl_absensi', $bulan)
                    ->where('id_karyawan', $id_karyawan)
                    ->where('kehadiran','=','Sakit')->count();
        $get_alpha =  DB::table('absensi')
                    ->whereYear('tgl_absensi', $tahun)
                    ->whereMonth('tgl_absensi', $bulan)
                    ->where('id_karyawan', $id_karyawan)
                    ->where('kehadiran','=','Alpha')->count();
        $get_ijin =  DB::table('absensi')
                    ->whereYear('tgl_absensi', $tahun)
                    ->whereMonth('tgl_absensi', $bulan)
                    ->where('id_karyawan', $id_karyawan)
                    ->where('kehadiran','=','Izin')->count();
        // get
        $tunj_jabatan = DB::table('tunjangan_jabatan')
                        ->join('jenis_tunjangan','tunjangan_jabatan.id_jenis_tunjangan','=','jenis_tunjangan.id_jenis_tunjangan')
                        ->join('karyawan','tunjangan_jabatan.id_karyawan','=','karyawan.id_karyawan')
                        ->where('karyawan.id_karyawan',$id_karyawan)
                        ->get();
        $jml_tunjangan = DB::table('tunjangan_jabatan')
                        ->select(DB::raw('sum(besar_tunjangan) as sum_jml_tunjangan'))
                        ->where('id_karyawan',$id_karyawan)
                        ->first();
        $jumlah_tunjangan = $jml_tunjangan->sum_jml_tunjangan;
        $jenis_tunjangan = DB::table('jenis_tunjangan')->get();
        $jml_jenis_tunjangan = $jenis_tunjangan->count();


        $jml_jam_kerja = DB::table('absensi')
                        ->select(DB::raw('sum(jumlah_waktu_kerja) as sum_jam_kerja'))
                        ->whereYear('tgl_absensi', $tahun)
                        ->whereMonth('tgl_absensi', $bulan)
                        ->where('id_karyawan', $id_karyawan)
                        ->where('kehadiran','Hadir')
                        ->first();

            $jml_jam = $jml_jam_kerja->sum_jam_kerja;
            // dd($jml_jam_kerja->sum_jam_kerja);

        if ($jml_jam > 160){
            $jumlah_jam_lembur = $jml_jam - 160; //MENGHITUNG JUMLAH JAM LEMBUR
            $jumlah_jam_potongan = 0; // MENGHITUNG JUMLAH JAM POTONGAN
            $gaji_lembur = ($gaji_jam = $karyawan->gaji_pokok/160) * ($jumlah_jam_lembur); // MENGHITUNG GAJI LEMBUR
            $besar_potongan = 0; // MENGHITUNG BESAR POTONGAN
        }else{
            $jumlah_jam_lembur = $jml_jam - (8 * $count_hadir_absensi); //MENGHITUNG JUMLAH JAM LEMBUR
            $jumlah_jam_potongan = 160 - ($count_hadir_absensi*8);// MENGHITUNG JUMLAH JAM POTONGAN
            $gaji_lembur = ($karyawan->gaji_pokok/160) * ($jumlah_jam_lembur);// MENGHITUNG GAJI LEMBUR
            $besar_potongan = ($karyawan->gaji_pokok/160) * ($jumlah_jam_potongan);// MENGHITUNG BESAR POTONGAN
        }


        $pdf = PDF::loadView('gaji.slip', compact('jumlah_jam_lembur','jumlah_jam_potongan','gaji_lembur','get_cuti','get_sakit','get_alpha','get_ijin','besar_potongan','count_hadir_absensi','jml_jam','tunj_jabatan','jumlah_tunjangan','karyawan','bulan','tahun'))->setPaper('a4', 'potrait');

        if($count_data_absensi < 1){
            notify()->warning('Data Tidak Ditemukan!');
            return back()->with('error','Data Tidak Ditemukan!');
        }else{
            return $pdf->stream();
        }
    }
    public function edit($id)
    {
        $karyawan = DB::table('karyawan')->where('id_karyawan',$id)->first();
        return response()->json($karyawan);
    }

}
