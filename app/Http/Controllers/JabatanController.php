<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jabatan;
use DataTables;
use Illuminate\Support\Facades\DB;

class JabatanController extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {



        if ($request->ajax()) {

            $data = Jabatan::latest()->get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($row) {



                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id_jabatan . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editJabatan">Edit</a>';



                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id_jabatan . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteJabatan">Delete</a>';



                    return $btn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }



        return view('admin.jabatan', compact('jabatan'));
    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        DB::table('jabatan')
        ->updateOrInsert(
            ['id_jabatan' => $request->id_jabatan],

            ['nama_jabatan' => $request->nama_jabatan, 'gaji_pokok' => $request->gaji_pokok]
        );



        return response()->json(['success' => 'Product saved successfully.']);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Jabatan  $product

     * @return \Illuminate\Http\Response

     */

    public function edit($id_jabatan)

    {
        $jabatan = DB::table('jabatan')
            ->where('id_jabatan', $id_jabatan)
            ->first();

        // $jabatan = Jabatan::where('id_jabatan', $id_jabatan)->first();
        return response()->json($jabatan);
    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Jabatan  $product

     * @return \Illuminate\Http\Response

     */

    public function destroy($id_jabatan)

    {

        $jabatan = DB::table('jabatan')
            ->where('id_jabatan', $id_jabatan)
            ->delete();


        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
