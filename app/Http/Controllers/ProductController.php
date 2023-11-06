<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Product,Category};

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.product.index',[
            'category' => Category::get(),
            'product' => Product::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products',
            'category' => 'required',
            'product_cost' => 'required',
            'product_srp' => 'required',
            'description' => 'nullable',
        ]);
        Product::create([
            'product_name'=>$request->product_name,
            'category_id'=>$request->category,
            'product_cost'=>$request->product_cost,
            'product_srp'=>$request->product_srp,
            'desc'=>$request->description,
        ]);
        return back()->with('success','Product created!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'category' => 'required',
            'product_cost' => 'required',
            'product_srp' => 'required',
            'description' => 'nullable',
        ]);
        Product::whereId($request->id)->update([
            'product_name'=>$request->product_name,
            'category_id'=>$request->category,
            'product_cost'=>$request->product_cost,
            'product_srp'=>$request->product_srp,
            'desc'=>$request->description,
        ]);
        return back()->with('success','Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Product::whereId($request->id)->delete();
        return back()->with('success','Product deleted!');
    }
}
