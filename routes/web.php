<?php

use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\Users\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController as ControllersMainController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\MenuController as ControllersMenuController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/users/login',[LoginController::class, 'getIndex'])->name('login');
Route::post('admin/users/login/store',[LoginController::class, 'postStore'])->name('store');

Route::middleware(['auth'])->group(function(){
    #admin
    Route::prefix('admin')->group(function(){
        Route::get('/',[MainController::class, 'getIndex'])->name('admin');
        Route::get('main',[MainController::class, 'getIndex']);
        #menu
        Route::prefix('menus')->group(function(){
            Route::get('add',[MenuController::class, 'getCreate'])->name('create');
            Route::post('add',[MenuController::class, 'postCreate'])->name('create');//store
            Route::get('list',[MenuController::class, 'getMenuList'])->name('menu_list');
            Route::get('edit/{menu}',[MenuController::class, 'getMenuEdit'])->name('menu_edit');
            Route::post('edit/{menu}',[MenuController::class, 'postMenuEdit'])->name('menu_edit');
            Route::delete('destroy', [MenuController::class, 'getDelete'])->name('delete');
        });
        #Products
       
        Route::prefix('products')->group(function(){
            Route::get('add',[ProductController::class, 'getAddProduct'])->name('add_product');
            Route::post('add',[ProductController::class, 'postAddProduct'])->name('add_product');
            Route::get('list',[ProductController::class, 'getListProduct'])->name('list_product');
            Route::get('edit/{product}',[ProductController::class, 'getEditProduct'])->name('edit_product');
            Route::post('edit/{product}',[ProductController::class, 'postEditProduct'])->name('edit_product');//update trong khoa phạm
            Route::delete('destroy', [ProductController::class, 'getDelete']);
            // Route::delete('destroy', [ProductControllerr::class, 'getDelete'])->name('delete');
        });
        #slide
        Route::prefix('sliders')->group(function(){
            Route::get('add',[SliderController::class, 'getAddSlider'])->name('add_slider');
            Route::post('add', [SliderController::class, 'postAddSlider']);
            Route::get('list',[SliderController::class, 'getListSlider'])->name('list_slider');
            Route::get('edit/{slider}', [SliderController::class, 'getEditSlider'])->name('edit_slider');
            Route::post('edit/{slider}', [SliderController::class, 'postEditSlider']);
            Route::delete('destroy', [SliderController::class, 'getDelete']);

        });

        #UPLOAD
        Route::post('upload/services',[UploadController::class, 'store']);
    });
   
    // Route::get('admin',[MainController::class, 'getIndex'])->name('admin');

});

Route::get('/', [ControllersMainController::class, 'index'])->name('index');
Route::post('services/load-product',[ControllersMainController::class, 'loadProduct']);
Route::get('danh-muc/{id}-{slug}.html', [ControllersMenuController::class, 'index']);
Route::get('san-pham/{id}-{slug}.html', [ControllersProductController::class, 'index'])->name('detail-product');
Route::post('add-cart', [CartController::class, 'index']);
Route::get('/carts', [CartController::class, 'show']);
Route::post('update-cart', [CartController::class, 'update']);
Route::get('/carts/delete/{productId}', [CartController::class, 'destroy']);
Route::post('carts', [CartController::class, 'addCart']);