<?php

use App\Http\Controllers\analytics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login;
use App\Http\Controllers\product_crud;
use App\Http\Controllers\stats;
use App\Http\Controllers\filter;
use App\Http\Controllers\inventory1;
use App\Http\Controllers\archive;
use App\Http\Controllers\notifications_user;
use App\Http\Controllers\notify;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::middleware('auth:sanctum')->group(function(){

    Route::get('/user', function (Request $request){
        return $request->user();
    });
    

    Route::post('/logout_user', [login::class, 'logout']);
    
});





/* LOGIN */
Route::post('/auth_login', [login::class, 'login']);
Route::post('/auth_register', [login::class, 'register']);


Route::post('/updateProfile/{id}', [login::class, 'updateProfile']);
Route::get('/editAccount/{id}', [login::class, 'editAccount']);




Route::get('/accounts/lists', [login::class, 'staffLists']);

Route::post('/accountListEdit/{id}', [login::class, 'editList']);






/* PRODUCT CRUD */
Route::post('/add_product', [product_crud::class, 'add_product']);


Route::post('/update_product/{id}', [product_crud::class, 'action_update_product']);


Route::get('/products', [product_crud::class, 'index']);
Route::get('/product/edit/{id}', [product_crud::class, 'index_update_product']);
Route::put('/delete/{id}', [product_crud::class, 'delete_product']);


Route::get('/sample/{id}', [product_crud::class, 'show1']);


Route::post('/checkout', [product_crud::class, 'checkout']);




/* INVENTORY */
Route::get('/inventory', [inventory1::class, 'inventory_index']);
Route::get('/inventoryLists', [inventory1::class, 'inventoryLists']);



Route::get('/index/category', [inventory1::class, 'index_category']);
Route::get('/stock/history', [inventory1::class, 'stockHistory']);
Route::get('/select/category', [inventory1::class, 'select_category']);
Route::get('/select/product/info/{data}', [inventory1::class, 'select_product_info']);


Route::get('/getStockID/{id}', [inventory1::class, 'getStockID']);


Route::post('/updateStockID/{id}', [inventory1::class, 'updateStockID']);


Route::get('/sold-out-inventory', [inventory1::class, 'getSoldOutInventory']);



Route::get('/category/edit/{id}', [inventory1::class, 'get_update_cat']);



Route::post('/category', [inventory1::class, 'create_category']);
Route::post('/inventory/add', [inventory1::class, 'inventory_add']);



Route::post('/category/update/{id}', [inventory1::class, 'update_category']);



Route::put('/category/archive/{id}', [inventory1::class, 'delete_category']);
Route::put('/delete/category/{id}', [inventory1::class, 'delete_category']);



/* STATISTICS AND NOTIFICATIONS*/
Route::get('/stats', [stats::class, 'total_prod']);
Route::get('/expiration', [stats::class, 'expProduct']);

Route::get('/netSales', [stats::class, 'netSales']);
Route::get('/supplierLists', [stats::class, 'supplierLists']);


Route::get('/expiration/count', [stats::class, 'expired_count']);


Route::get('/stocks', [stats::class, 'stocks']);
Route::get('/stock_total', [stats::class, 'stock_total']);


Route::get('/orders', [stats::class, 'orders']);
Route::get('/critical/stocks', [stats::class, 'criticalStocks']);
Route::get('/critical/count', [stats::class, 'criticalStocksCount']);




Route::get('/sales', [stats::class, 'total_sales']);
Route::get('/sold', [stats::class, 'sold_items']);


Route::get('/daily', [stats::class, 'dailyItems']);
Route::get('/weekly', [stats::class, 'weeklyItems']);
Route::get('/monthly', [stats::class, 'monthlyItems']);
Route::get('/yearly', [stats::class, 'yearlyItems']);



Route::get('/expiring/products', [stats::class, 'expiringItems']);


/* SHOW INVOICE */
Route::get('/showInvoice/{id}', [stats::class, 'showInvoice']);







/* SEARCH AND FILTER */
Route::get('/search/{data}', [filter::class, 'search']);


Route::get('/filter/daily/{date}', [filter::class, 'filterDaily']);
Route::get('/filter/month/{date}', [filter::class, 'filterMonth']);
Route::get('/inventory/search/{data}', [filter::class, 'searchInventory']);

Route::get('/inventoryLists/search/{data}', [filter::class, 'searchInventoryLists']);


Route::get('/inventoryLists/category/{data}', [filter::class, 'filterInventoryCat']);
Route::get('/critical/search/{data}', [filter::class, 'searchCritical']);





Route::get('/soldItems/{data}', [filter::class, 'searchSoldItems']);


Route::get('/sold-out-inventory/{data}', [filter::class, 'searchSoldOutItems']);



Route::get('/expiration/search/{data}', [filter::class, 'searchExpired']);
Route::get('/orders/search/{data}', [filter::class, 'searchOrder']);
Route::get('/supplier/search/{data}', [filter::class, 'searchSupplier']);


Route::get('/expiring/search/{data}', [filter::class, 'searchExpiring']);
Route::get('/stockHistory/search/{data}', [filter::class, 'searchStockHistory']);



Route::get('/daily/search/{data}', [filter::class, 'searchDaily']);
Route::get('/monthly/search/{data}', [filter::class, 'searchMontly']);
Route::get('/yearly/search/{data}', [filter::class, 'searchYearly']);







/* ARCHIVE */
Route::get('/archive/product', [archive::class, 'indexProduct']);
Route::get('/archive/category', [archive::class, 'indexCategory']);

Route::put('/restore/{id}', [archive::class, 'restoreProduct']);
Route::put('/restore/cat/{id}', [archive::class, 'restoreCategory']);

Route::delete('/delete/permanent/{id}', [archive::class, 'permanentDeleteProd']);


Route::get('archive/product/search/{data}', [archive::class, 'searchProdArchived']);







/* NOTIFICATIONS */
Route::post('/notify', [notifications_user::class, 'notify']);
Route::get('/notify/lists', [notifications_user::class, 'indexNotif']);



Route::get('/notification/stocks', [notify::class, 'checkStocks']);
Route::put('/readNotifications', [notify::class, 'readNotifications']);


Route::get('/notify/email', [notify::class, 'emailNotif']);


/* ANALYTICS */
Route::get('/sample', [analytics::class, 'sample']);
Route::get('/analytics/monthly', [stats::class, 'monthlyItemsAnalytics']);


/* EXPORT EXCEL */
Route::get('/export-excel', [product_crud::class, 'exportProductExcel']);


Route::get('/export-excel/inventory', [inventory1::class, 'exportExcelInventory']);

