<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TunjanganJabatan;
use DataTables;
use Illuminate\Support\Facades\DB;

class TunjanganJabatanController extends Controller
{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request)
    {
        $karyawan = DB::table('karyawan')->join('jabatan', 'karyawan.id_jabatan', '=', 'jabatan.id_jabatan')->get();
        $jenis_tunjangan = DB::table('jenis_tunjangan')->get();
        if ($request->ajax()) {
            // $data = DB::table('tunjangan_jabatan')->get();
            $data = DB::table('tunjangan_jabatan')

                ->join('karyawan', 'tunjangan_jabatan.id_karyawan', '=', 'karyawan.id_karyawan')
                ->join('jenis_tunjangan', 'tunjangan_jabatan.id_jenis_tunjangan', '=', 'jenis_tunjangan.id_jenis_tunjangan')
                ->select('*')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id_tunjangan_jabatan . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editTunjanganJabatan">Edit</a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id_tunjangan_jabatan . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteTunjanganJabatan">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // $data = array('tunjangan_jabatan','karyawan','jenis_tunjangan');
        return view('admin.tunjangan_jabatan', compact('data', 'karyawan', 'jenis_tunjangan'));
    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)
    {
        DB::table('tunjangan_jabatan')
            ->updateOrInsert(
                ['id_tunjangan_jabatan' => $request->id_tunjangan_jabatan],
                [
                    'besar_tunjangan' => $request->besar_tunjangan,
                    'id_jenis_tunjangan' => $request->id_jenis_tunjangan,
                    'id_karyawan' => $request->id_karyawan
                ]
            );
        return response()->json(['success' => 'Product saved successfully.']);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\TunjanganJabatan  $product

     * @return \Illuminate\Http\Response

     */

    public function edit($id_tunjangan_jabatan)

    {

        $tunjaganjabatan = DB::table('tunjangan_jabatan')->where('id_tunjangan_jabatan', $id_tunjangan_jabatan)->first();
        return response()->json($tunjaganjabatan);
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\TunjanganJabatan  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy($id_tunjangan_jabatan)
    {
        $tunjaganjabatan = DB::table('tunjangan_jabatan')->where('id_tunjangan_jabatan', $id_tunjangan_jabatan)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
