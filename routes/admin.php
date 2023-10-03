<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Admin\AdditionalItemController;


/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'admin/', 'middleware' => ['auth', 'is_admin']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard');
    //profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('profile/{id}', [AdminController::class, 'adminProfileUpdate']);
    Route::post('changepassword', [AdminController::class, 'changeAdminPassword']);
    Route::put('image/{id}', [AdminController::class, 'adminImageUpload']);
    //profile end

    
    Route::get('/new-admin', [AdminController::class, 'getAdmin'])->name('alladmin');
    Route::post('/new-admin', [AdminController::class, 'adminStore']);
    Route::get('/new-admin/{id}/edit', [AdminController::class, 'adminEdit']);
    Route::post('/new-admin-update', [AdminController::class, 'adminUpdate']);
    Route::get('/new-admin/{id}', [AdminController::class, 'adminDelete']);

    
    Route::get('/brand', [BrandController::class, 'index'])->name('admin.brand');
    Route::post('/brand', [BrandController::class, 'store']);
    Route::get('/brand/{id}/edit', [BrandController::class, 'edit']);
    Route::post('/brand-update', [BrandController::class, 'update']);
    Route::get('/brand/{id}', [BrandController::class, 'delete']);

    
    Route::get('/category', [CategoryController::class, 'index'])->name('admin.category');
    Route::post('/category', [CategoryController::class, 'store']);
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit']);
    Route::post('/category-update', [CategoryController::class, 'update']);
    Route::get('/category/{id}', [CategoryController::class, 'delete']);
    
    Route::get('/time-slot', [TimeSlotController::class, 'index'])->name('admin.timeslot');
    Route::post('/time-slot', [TimeSlotController::class, 'store']);
    Route::get('/time-slot/{id}/edit', [TimeSlotController::class, 'edit']);
    Route::post('/time-slot-update', [TimeSlotController::class, 'update']);
    Route::get('/time-slot/{id}', [TimeSlotController::class, 'delete']);
    
    Route::get('/additional-item-title', [AdditionalItemController::class, 'getTitle'])->name('admin.additionalItemTitle');
    Route::post('/additional-item-title', [AdditionalItemController::class, 'titleStore']);
    Route::get('/additional-item-title/{id}/edit', [AdditionalItemController::class, 'titleEdit']);
    Route::post('/additional-item-title-update', [AdditionalItemController::class, 'titleUpdate']);
    Route::get('/additional-item-title/{id}', [AdditionalItemController::class, 'titleDelete']);


});
  