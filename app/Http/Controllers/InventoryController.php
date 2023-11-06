<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{TransactionSale,TransactionSaleItem};
use App\Models\{Delivery,DeliveryItem,Supplier,Product};
use DB;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('pages.inventory.index', [
            'inventories' => DB::table('products')
                ->leftJoin('product_quantities', 'products.id', '=', 'product_quantities.product_id')
                ->select(
                    'products.id',
                    'products.product_name',
                    'products.desc',
                    'products.product_cost',
                    'products.product_srp',
                    DB::raw('IFNULL(SUM(IF(product_quantities.delivery_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) as stock_qty'),
                    DB::raw('IFNULL(SUM(IF(product_quantities.delivery_item_id IS NOT NULL, product_quantities.quantity * products.product_srp, 0)), 0) as stock_price'),
                    DB::raw('IFNULL(SUM(IF(product_quantities.delivery_item_id IS NOT NULL, product_quantities.quantity * products.product_cost, 0)), 0) as stock_totalprice'),
                    DB::raw('IFNULL(SUM(IF(product_quantities.sale_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) as sal_qty'),
                    DB::raw('IFNULL(SUM(IF(product_quantities.sale_item_id IS NOT NULL, product_quantities.quantity * products.product_cost, 0)), 0) as sal_totalprice'),
                    DB::raw('CASE WHEN IFNULL(SUM(IF(product_quantities.delivery_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) - IFNULL(SUM(IF(product_quantities.sale_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) < 0 THEN 0 ELSE IFNULL(SUM(IF(product_quantities.delivery_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) - IFNULL(SUM(IF(product_quantities.sale_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) END as total_stock')
                )
                ->groupBy('products.id', 'products.product_name', 'products.desc', 'products.product_cost', 'products.product_srp')
                ->get(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
