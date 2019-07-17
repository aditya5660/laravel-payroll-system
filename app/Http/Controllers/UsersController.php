<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =   ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteJabatan">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.add-users', compact('jabatan'));
    }
    public function store(Request $request)
    {
        DB::table('users')
            ->updateOrInsert(
                ['id' => $request->id],
                ['name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                ]
            );
        return redirect('/users');;
    }
    public function edit($id_jabatan)
    {
        $jabatan = DB::table('jabatan')
            ->where('id_jabatan', $id_jabatan)
            ->first();

        // $jabatan = Jabatan::where('id_jabatan', $id_jabatan)->first();
        return response()->json($jabatan);
    }
    public function destroy($id)
    {

        $jabatan = DB::table('users')
            ->where('id', $id)
            ->delete();


        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
