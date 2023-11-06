<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Delivery,DeliveryItem,Supplier,Product,ProductQuantity};

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $successMessage = $request->query('success');

        return view('pages.delivery.index', [
            'successMessage' => $successMessage,
            'deliveries' => Delivery::get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.delivery.create-delivery-item',[
            'suppliers' => Supplier::get(),
            'products' => Product::get(),
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
        $delivery = new Delivery();
        $delivery->supplier_id = $request->input('supplier_id');
        $delivery->save();

        $productData = $request->input('productData');
        $totalPrice = 0.00;

        foreach ($productData as $itemData) {
            $deliveryItem = new DeliveryItem();
            $deliveryItem->delivery_id = $delivery->id;
            $deliveryItem->product_id = $itemData['product'];
            $deliveryItem->del_price = $itemData['price'];
            $deliveryItem->del_totalprice = $itemData['totalAmount'];
            $deliveryItem->save();
            
            $deliveryQtyItem = new ProductQuantity();
            $deliveryQtyItem->product_id = $itemData['product'];
            $deliveryQtyItem->delivery_item_id = $deliveryItem->id;
            $deliveryQtyItem->quantity = $itemData['qty'];
            $deliveryQtyItem->save();

            $totalPrice += $itemData['totalAmount'];
        }

        $delivery->total_price = $totalPrice;
        $delivery->save();

        return response()->json(['message' => 'Delivery created successfully'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('pages.delivery.view-delivery-item',[
            'delivery' => Delivery::whereId($id)->first(),
            'delivery_items' => DeliveryItem::with('quantity')->where('delivery_id',$id)->get(),
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
        return view('pages.delivery.edit-delivery-item',[
            'delivery' => Delivery::whereId($id)->first(),
            'delivery_items' => DeliveryItem::where('delivery_id',$id)->get(),
            'products' => Product::get(),
        ]);
    }

    public function addEditedItem(Request $request, $id){

        $deliveryItem = new DeliveryItem();
        $deliveryItem->delivery_id = $id;
        $deliveryItem->product_id = $request->product;
        $deliveryItem->del_price = $request->price;
        $deliveryItem->del_totalprice = $request->price * $request->qty;
        $deliveryItem->save();

        $deliveryQtyItem = new ProductQuantity();
        $deliveryQtyItem->product_id = $request->product;
        $deliveryQtyItem->delivery_item_id = $deliveryItem->id;
        $deliveryQtyItem->quantity = $request->qty;
        $deliveryQtyItem->save();

        $delivery = Delivery::findOrFail($id);
        $itemtotalprice = $request->price * $request->qty;
        $del_itemtotalprice = $delivery->total_price + $itemtotalprice;
        $delivery->total_price = $del_itemtotalprice;
        $delivery->update();

        return redirect()->back()->with('success','Successfully added!');
    }

    public function removeEditItem($id){
        $deliveryItem = DeliveryItem::findOrFail($id);
        $delivery = Delivery::findOrFail($deliveryItem->delivery_id);
        $del_itemtotalprice = $delivery->total_price - $deliveryItem->del_totalprice;
        $delivery->total_price = $del_itemtotalprice;
        $delivery->update();
        $deliveryItem->delete();
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
        $deliveryItem = DeliveryItem::findOrFail($id);
        $old_itemtprice = $deliveryItem->del_totalprice;

        $delivery = Delivery::findOrFail($deliveryItem->delivery_id);
        $del_tprice = $delivery->total_price - $old_itemtprice;

        $deliveryItem->product_id = $request->product;
        $deliveryItem->del_price = $request->price;
        $deliveryItem->del_totalprice = $request->price * $request->qty;
        $deliveryItem->update();

        $deliveryQtyItem = ProductQuantity::where('delivery_item_id', $id)->first();
        $deliveryQtyItem->product_id = $request->product;
        $deliveryQtyItem->quantity = $request->qty;
        $deliveryQtyItem->update();

        $del_itemtotalprice = $del_tprice + $deliveryItem->del_totalprice;
        $delivery->total_price = $del_itemtotalprice;
        $delivery->update();

        return redirect()->back()->with('success','Successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delivery = Delivery::findOrFail($request->id);
        $delivery->delete();
        return redirect()->back()->with('success','Successfully deleted!');
    }
}
