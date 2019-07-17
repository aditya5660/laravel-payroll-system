<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Karyawan;
use App\Jabatan;
use DataTables;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if ($request->ajax()) {
            $data = DB::table('karyawan')
                ->join('jabatan','karyawan.id_jabatan','=','jabatan.id_jabatan')
                ->select('karyawan.*','jabatan.nama_jabatan')
                ->get();

            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_karyawan.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editKaryawan">Edit</a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_karyawan.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteKaryawan">Delete</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $jabatan = DB::table('jabatan')->get();
        return view('admin.karyawanAjax',compact('jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::table('karyawan')->updateOrInsert(['id_karyawan' => $request->id_karyawan],
                [
                    'nama_karyawan' => $request->nama_karyawan,
                    'npwp_karyawan' => $request->npwp_karyawan,
                    'id_jabatan' => $request->id_jabatan,
                    'email' => $request->email,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'agama' => $request->agama,
                    'alamat' => $request->alamat,
                    'telp' => $request->telp,
                ]);

        return response()->json(['success'=>'Product saved successfully.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Karyawan  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id_karyawan)
    {
        $karyawan = DB::table('karyawan')->where('id_karyawan',$id_karyawan)->first();
        // Karyawan::find('id_karyawan')->get();
        return response()->json($karyawan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Karyawan  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_karyawan)
    {
        DB::table('karyawan')->where('id_karyawan',$id_karyawan)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
