<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{TransactionSale,TransactionSaleItem};
use App\Models\{Delivery,DeliveryItem,Supplier,Product};
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    public function index()
    {
        return view('home',[
            'products' => DB::table('products')
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
                    DB::raw('CASE WHEN IFNULL(SUM(IF(product_quantities.delivery_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) - IFNULL(SUM(IF(product_quantities.sale_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) < 0 THEN 0 ELSE IFNULL(SUM(IF(product_quantities.delivery_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) - IFNULL(SUM(IF(product_quantities.sale_item_id IS NOT NULL, product_quantities.quantity, 0)), 0) END as qty')
                )
                ->groupBy('products.id', 'products.product_name', 'products.desc', 'products.product_cost', 'products.product_srp')
                ->get(),
        ]);
    } 
  
    public function adminHome()
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(0);
        $formattedDate = $startDate->format('Y-m-d');
        
        return view('adminHome',[
            'c_product' => Product::count(),
            'c_today_income' => DB::table('transaction_sales')
                ->whereDate('created_at', $formattedDate)
                ->selectRaw('SUM(total_price) as total_sales')
                ->value('total_sales') ?? 0,
            'c_transactions' => TransactionSale::count(),
            'today_transaction' => TransactionSale::whereDate('created_at', $formattedDate)->get(),
        ]);
    }

    public function redirecHome(){
        switch (auth()->user()->type) {
            case "admin":
            return redirect()->route('admin.home');
            break;
            case "user":
            return redirect()->route('user.home');
            break;
        }
    }
}
