<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use DataTables;
class ProductAjaxController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        // view('admin.productAjax')->with('products', $products);
        // return view('admin.productAjax', $products);
        return view('admin.productAjax',compact('products'));
    }
    public function store(Request $request)
    {
        Product::updateOrCreate(['id' => $request->product_id],
                [
                    'name' => $request->name,
                    'detail' => $request->detail
                ]);
        return response()->json(['success'=>'Product saved successfully.']);
    }
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }
    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
