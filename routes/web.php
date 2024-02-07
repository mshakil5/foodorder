<?php
  
use Illuminate\Support\Facades\Route;
  
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaypalController;
  
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

// cache clear
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
 });
//  cache clear
  
// Route::get('/', function () {
//     return view('welcome');
// });
  
Auth::routes();
Route::get('/', [FrontendController::class, 'index'])->name('homepage');
Route::get('/home', [FrontendController::class, 'index']);
Route::post('get-additional-product', [FrontendController::class, 'getAdditionalProduct']);
Route::get('/clear-session', [FrontendController::class, 'clearAllSessionData'])->name('clearSessionData');

Route::post('/check-post-code', [FrontendController::class, 'checkPostCode']);
Route::post('/check-coupon-code', [FrontendController::class, 'checkCouponCode']);

//search
Route::post('/getcatproduct', [FrontendController::class, 'searchproduct']);
Route::post('/search-product', [FrontendController::class, 'searchProductbyName']);

// order
Route::post('/order-store', [OrderController::class, 'orderStore']);
Route::post('/add-to-session-card-item', [OrderController::class, 'storeDataInSession']);
Route::post('/clear-session-data', [OrderController::class, 'clearSpecificSessionData']);


Route::get('/order-confirmation/{id}', [OrderController::class, 'orderConfirmation'])->name('confirmorder');

Route::post('payment', [PaypalController::class, 'payment'])->name('paypalpayment');
Route::get('success', [PaypalController::class, 'success'])->name('paypal.payment.success');
Route::get('cancel', [PaypalController::class, 'cancel'])->name('paypal.payment.cancel');



  
/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'user/', 'middleware' => ['auth', 'is_user']], function(){
  
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});
  

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'manager/', 'middleware' => ['auth', 'is_manager']], function(){
  
    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
});
 