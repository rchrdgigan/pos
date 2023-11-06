<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.supplier.index',[
            'suppliers' => Supplier::get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier' => 'required|unique:suppliers',
            'supplier_person' => 'required',
            'address' => 'required',
            'cpnumber' => 'required',
        ]);
        Supplier::create([
            'supplier'=>$request->supplier,
            'supplier_person'=>$request->supplier_person,
            'address'=>$request->address,
            'cpnumber'=>$request->cpnumber,
        ]);
        return back()->with('success','Supplier created!');
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
            'supplier' => 'required',
            'supplier_person' => 'required',
            'address' => 'required',
            'cpnumber' => 'required',
        ]);
        Supplier::whereId($request->id)->update([
            'supplier'=>$request->supplier,
            'supplier_person'=>$request->supplier_person,
            'address'=>$request->address,
            'cpnumber'=>$request->cpnumber,
        ]);
        return back()->with('success','Supplier updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Supplier::whereId($request->id)->delete();
        return back()->with('success','Supplier deleted!');
    }
}
