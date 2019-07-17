<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisTunjangan;
use DataTables;
use Illuminate\Support\Facades\DB;

class JenisTunjanganController extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

   

        if ($request->ajax()) {

            $data = JenisTunjangan::latest()->get();

            return Datatables::of($data)

                    ->addIndexColumn()

                    ->addColumn('action', function($row){

   

                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_jenis_tunjangan.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editTunjangan">Edit</a>';

   

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id_jenis_tunjangan.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteTunjangan">Delete</a>';

    

                            return $btn;

                    })

                    ->rawColumns(['action'])

                    ->make(true);

        }

      
        $data = array('JenisTunjangan');
        return view('admin.tunjanganAjax',$data);

    }

     

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {
        DB::table('jenis_tunjangan')
        ->updateOrInsert(
            ['id_jenis_tunjangan' => $request->id_jenis_tunjangan],
            ['nama_jenis_tunjangan' => $request->nama_jenis_tunjangan]
        );
        
        // JenisTunjangan::updateOrCreate(['id_jenis_tunjangan' => $request->product_id],

        //         ['nama_jenis_tunjangan' => $request->nama_jenis_tunjangan]);        

   

        return response()->json(['success'=>'Product saved successfully.']);

    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Product  $product

     * @return \Illuminate\Http\Response

     */

    public function edit($id_jenis_tunjangan)

    {

       $product= DB::table('jenis_tunjangan')
       ->where('id_jenis_tunjangan', $id_jenis_tunjangan)
       ->first();

        return response()->json($product);

    }

  

    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Product  $product

     * @returnz \Illuminate\Http\Response

     */

    public function destroy($id_jenis_tunjangan)

    {

        $product= DB::table('jenis_tunjangan')
        ->where('id_jenis_tunjangan', $id_jenis_tunjangan)
        ->delete();

     

        return response()->json(['success'=>'Product deleted successfully.']);

    }
}
