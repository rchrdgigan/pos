<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{TransactionSale,TransactionSaleItem,Product,ProductQuantity};
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filled('daterange')) {
            list($startDate, $endDate) = explode(' - ', $request->input('daterange'));

            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            $sales = TransactionSale::whereBetween('created_at', [$startDate, $endDate])->get();
        }else{
            $sales = [];
        }
    
        return view('pages.sale.index', [
            'sales' => $sales,
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
        $sale = new TransactionSale();
        $sale->user_id = auth()->user()->id;
        $sale->total_price = $request->input('totalAmount');
        $sale->cash = $request->input('cash');
        $sale->change = $request->input('changedAmount');
        $sale->save();

        $productData = $request->input('productData');
        foreach ($productData as $itemData) {
            $saleItem = new TransactionSaleItem();
            $saleItem->transaction_sale_id = $sale->id;
            $saleItem->product_id = $itemData['product'];
            $saleItem->sal_discount = $itemData['discount'];
            // $saleItem->sal_qty = $itemData['qty'];
            $saleItem->sal_price = $itemData['price'];
            $saleItem->sal_subtotal = $itemData['subAmount'];
            $saleItem->sal_totalprice = $itemData['totalAmount'];
            $saleItem->save();

            $saleQtyItem = new ProductQuantity();
            $saleQtyItem->product_id = $itemData['product'];
            $saleQtyItem->sale_item_id = $saleItem->id;
            $saleQtyItem->quantity = $itemData['qty'];
            $saleQtyItem->save();
        }
        return response()->json(['transid' =>  $sale->id], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return view('pages.sale.view-sale-item',[
            'sale' => TransactionSale::whereId($id)->first(),
            'sale_items' => TransactionSaleItem::with('quantity')->where('transaction_sale_id',$id)->get(),
        ]);
    }


    public function print(Request $request)
    {
        return view('pages.pos.print-reciept',[
            'sale' => TransactionSale::whereId($request->input('transid'))->first(),
            'sale_items' => TransactionSaleItem::where('transaction_sale_id',$request->input('transid'))->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.sale.edit-sale-item',[
            'sale' => TransactionSale::whereId($id)->first(),
            'sale_items' => TransactionSaleItem::where('transaction_sale_id',$id)->get(),
            'products' => DB::table('products')
            ->leftJoin('delivery_items','products.id','=','delivery_items.product_id')
            ->leftJoin('transaction_sale_items','products.id','=','transaction_sale_items.product_id')
            ->select(
                'products.id',
                'products.product_name',
                'products.desc',
                'products.product_cost',
                DB::raw('SUM(del_qty) - SUM(sal_qty) as qty'),
            )
            ->groupBy('products.id','products.product_name','products.desc','products.product_cost')
            ->get(),
        ]);
    }

    // public function addEditedItem(Request $request, $id){

    //     $temp_totalAmount = $request->price * $request->qty;
    //     $temp_discount = $request->discount / 100;
    //     $total_discount = $temp_discount * $temp_totalAmount;
    //     $totalAmount = $temp_totalAmount - $total_discount;


    //     $saleItem = new TransactionSaleItem();
    //     $saleItem->transaction_sale_id = $id;
    //     $saleItem->product_id = $request->product;
    //     $saleItem->sal_qty = $request->qty;
    //     $saleItem->sal_price = $request->price;
    //     $saleItem->sal_subtotal = $temp_totalAmount;
    //     $saleItem->sal_totalprice = $totalAmount;
    //     $saleItem->save();

    //     $sale = TransactionSale::findOrFail($id);
    //     $itemtotalprice = $totalAmount;
    //     $sal_itemtotalprice = $sale->total_price + $itemtotalprice;
    //     $sale->total_price = $sal_itemtotalprice;
    //     $sale->update();

    //     return redirect()->back()->with('success','Successfully added!');
    // }

    public function removeEditItem($id){
        $saleItem = TransactionSaleItem::findOrFail($id);
        $sale = TransactionSale::findOrFail($saleItem->transaction_sale_id);
        $sal_itemtotalprice = $sale->total_price - $saleItem->sal_totalprice;
        $sale->total_price = $sal_itemtotalprice;
        $sale->update();
        $saleItem->delete();
        return redirect()->back()->with('success','Successfully removed!');
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
    public function destroy(Request $request)
    {
        $sale = TransactionSale::findOrFail($request->id);
        $sale->delete();
        return redirect()->back()->with('success','Successfully deleted!');
    }
}
