<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Absensi;
use DataTables;
use Yajra\DataTables\Services\DataTable;
use PDF;
use Carbon;


class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $karyawan = DB::table('karyawan')->get();
        if ($request->ajax()) {
            $data = DB::table('karyawan')->get();

            return Datatables::of($data)

                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                            $btn = '<a href="'.url('absensi').'/'.$row->id_karyawan.'" data-toggle="tooltip"  class="edit btn btn-primary btn-sm ">List Absensi</a>';
                            $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_karyawan.'" data-original-title="Delete" class="btn btn-danger btn-sm rekapAbsensi">Rekap Absensi</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        // view('admin.productAjax')->with('products', $products);
        // return view('admin.productAjax', $products);
        return view('admin.absensi',compact('products','karyawan'));
    }


    public function create()
    {
        $karyawan = DB::table('karyawan')->get();
        return view('admin.tambahpresensi',compact('karyawan'));
    }
    public function rekap(Request $request )
    {
        $bulan = $request->bulan_start;
        $tahun= $request->tahun_start;
        $id_karyawan = $request->id_karyawan;
        $karyawan = DB::table('karyawan')
        ->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')
        ->select('*')
        ->where('id_karyawan',$id_karyawan)->first();

        $data = DB::table('absensi')
                ->whereYear('tgl_absensi',$tahun)
                ->whereMonth('tgl_absensi',$bulan)
                ->where('id_karyawan',$id_karyawan)
                ->get();
        $count_data = $data->count();

        $pdf = PDF::loadView('absensi.rekap-pribadi', compact('data','karyawan','bulan','tahun'))->setPaper('a4', 'potrait');

        if($count_data < 1){
            return back()->with('error','Data Tidak Ditemukan!');
        }else{
            return $pdf->stream();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // DB::table('absensi')->insert([
		// 	'id_karyawan' => $request->id_karyawan,
		// 	'kehadiran' => $request->kehadiran,
        // ]);
        $masuk  = date_create($request->masuk);
        $keluar = date_create($request->keluar);
        $diff  = date_diff( $masuk, $keluar );

        DB::table('absensi')
            ->updateOrInsert(
                ['id_absensi' => $request->id_absensi],
                ['id_karyawan' => $request->id_karyawan,
                'kehadiran' => $request->kehadiran,
                'waktu_masuk' => $request->masuk,
                'waktu_keluar' => $request->keluar,
                'jumlah_waktu_kerja' => $diff->h,
                'tgl_absensi' => $request->mydate
                ]
    );
        return response()->json( );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , $id)
    {
            $data = DB::table('absensi')
            ->join('karyawan', 'absensi.id_karyawan', '=', 'karyawan.id_karyawan')
            ->select('*')
            ->where('karyawan.id_karyawan', '=', $id)
            ->get();
        // $data = DB::table('absensi')->where('id_karyawan',$id)->get();
        $karyawan = DB::table('karyawan')->where('id_karyawan',$id)->get();

        return view('admin.detailabsensi', compact('karyawan','data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $karyawan = DB::table('karyawan')->where('id_karyawan',$id)->first();
        return response()->json($karyawan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $karyawan = DB::table('absensi')->where('id_absensi',$id)->delete();
        return redirect()->back();
    }
}
