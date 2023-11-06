<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    HomeController,
    ProductController,
    CategoryController,
    SupplierController,
    ProfileController,
    AccountController,
    DeliveryController,
    InventoryController,
    SaleController,
    ReportChartController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', 'login');
Route::get('/home', [HomeController::class, 'redirecHome']);
Auth::routes(['register' => false]);

/*------------------------------------------
All Admin Routes List
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/home', [HomeController::class, 'adminHome'])->name('home');
    Route::get('/product', [ProductController::class, 'index'])->name('product');
/*------------------------------------------
Category Routes List - Done
--------------------------------------------*/
    Route::get('/category', [CategoryController::class, 'index'])->name('category');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/category/update', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
/*------------------------------------------
Product Routes List - Done
--------------------------------------------*/
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::put('/product/update', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/destroy', [ProductController::class, 'destroy'])->name('product.destroy');
/*------------------------------------------
Supplier Routes List - Done
--------------------------------------------*/
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
    Route::post('/supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::put('/supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/destroy', [SupplierController::class, 'destroy'])->name('supplier.destroy');
/*------------------------------------------
Delivery Routes List - Done
--------------------------------------------*/
    Route::get('/deliver', [DeliveryController::class, 'index'])->name('deliver');
    Route::get('/deliver/create', [DeliveryController::class, 'create'])->name('deliver.create');
    Route::post('/deliver/store', [DeliveryController::class, 'store'])->name('deliver.store');
    Route::get('/deliver/show/{id}', [DeliveryController::class, 'show'])->name('deliver.show');
    Route::get('/deliver/edit/{id}', [DeliveryController::class, 'edit'])->name('deliver.edit');
    Route::delete('/deliver/destroy', [DeliveryController::class, 'destroy'])->name('deliver.destroy');
    Route::post('/deliver/edit/item/{id}', [DeliveryController::class, 'addEditedItem'])->name('deliver.addEditedItem');
    Route::delete('/deliver/edit/remove/{id}', [DeliveryController::class, 'removeEditItem'])->name('deliver.removeEditItem');
    Route::put('/deliver/update/item/{id}', [DeliveryController::class, 'update'])->name('deliver.editItemUpdate');
/*------------------------------------------
Profile Routes List - Done
--------------------------------------------*/
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('update');
    Route::put('/profile/changepassword', [ProfileController::class, 'updatePassword'])->name('changepassword');
/*------------------------------------------
User Account Routes List - Done
--------------------------------------------*/
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::post('/account/store', [AccountController::class, 'store'])->name('account.store');
    Route::put('/account/update', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::put('/account/changepassword', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
    Route::delete('/account/destroy', [AccountController::class, 'destroy'])->name('account.destroy');
/*------------------------------------------
Inventory Routes List - Done
--------------------------------------------*/
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
/*------------------------------------------
Sales Report Routes List - Done
--------------------------------------------*/
    Route::get('/sales', [SaleController::class, 'index'])->name('sales');
    Route::get('/sales/show/{id}', [SaleController::class, 'show'])->name('sales.show');
    Route::delete('/sales/destroy', [SaleController::class, 'destroy'])->name('sales.destroy');
    Route::get('/sales/edit/{id}', [SaleController::class, 'edit'])->name('sales.edit');
    Route::post('/sales/edit/item/{id}', [SaleController::class, 'addEditedItem'])->name('sales.addEditedItem');
    Route::delete('/sales/edit/remove/{id}', [SaleController::class, 'removeEditItem'])->name('sales.removeEditItem');
    Route::put('/sales/update/item/{id}', [SaleController::class, 'update'])->name('sales.editItemUpdate');
/*------------------------------------------
Report Chart Routes List - Done
--------------------------------------------*/
    Route::get('/report/chart', [ReportChartController::class, 'index'])->name('report');
});

/*------------------------------------------
All Normal Users Routes List
--------------------------------------------*/
Route::middleware(['auth', 'user-access:user'])->prefix('user')->as('user.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
/*------------------------------------------
Sale Routes List - Done
--------------------------------------------*/
    Route::post('/sale/store', [SaleController::class, 'store'])->name('sale.store');
    Route::get('/sale/print', [SaleController::class, 'print'])->name('sale.print');
/*------------------------------------------
Profile Routes List - Done
--------------------------------------------*/
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('update');
    Route::put('/profile/changepassword', [ProfileController::class, 'updatePassword'])->name('changepassword');
});
  
