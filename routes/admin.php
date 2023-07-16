<?php

use App\Http\Controllers\Admin\Admin_panel_settingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\Sales_materials_typesController;
use App\Http\Controllers\Admin\TreasuresController;
use App\Models\Admin_panel_settings;
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

define('PAGINATION_COUNT',20);
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware' =>'auth:admin'], function(){
    Route::get('/',[DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout',[LoginController::class, 'logout'])->name('admin.logout');

    Route::get('/adminpanelsetting/index',[Admin_panel_settingsController::class, 'index'])->name('admin.adminPanelsetting.index');
    Route::get('/adminpanelsetting/edit',[Admin_panel_settingsController::class, 'edit'])->name('admin.adminPanelsetting.edit');
    Route::post('/adminpanelsetting/update',[Admin_panel_settingsController::class, 'update'])->name('admin.adminPanelsetting.update');

    /*  start treasures  */
    Route::get('/treasures/index',[TreasuresController::class, 'index'])->name('admin.treasures.index');
    Route::get('/treasures/create',[TreasuresController::class, 'create'])->name('admin.treasures.create');
    Route::post('/treasures/store',[TreasuresController::class, 'store'])->name('admin.treasures.store');
    Route::get('/treasures/edit/{id}',[TreasuresController::class, 'edit'])->name('admin.treasures.edit');
    Route::post('/treasures/update/{id}',[TreasuresController::class, 'update'])->name('admin.treasures.update');
    Route::post('/treasures/ajax_search',[TreasuresController::class, 'ajax_search'])->name('admin.treasures.ajax_search');
    Route::get('/treasures/details/{id}',[TreasuresController::class, 'details'])->name('admin.treasures.details');
    Route::get('/treasures/add_treasures_delivery/{id}',[TreasuresController::class, 'add_treasures_delivery'])->name('admin.treasures.add_treasures_delivery');
    Route::post('/treasures/store_treasures_delivery/{id}',[TreasuresController::class, 'store_treasures_delivery'])->name('admin.treasures.store_treasures_delivery');
    Route::get('/treasures/delete_treasures_delivery/{id}',[TreasuresController::class, 'delete_treasures_delivery'])->name('admin.treasures.delete_treasures_delivery');
    /*  end  treasures */

    /*  start sales_materials_types  */
    Route::get('/sales_materials_types/index',[Sales_materials_typesController::class, 'index'])->name('admin.sales_materials_types.index');
    Route::get('/sales_materials_types/create',[sales_materials_typesController::class, 'create'])->name('admin.sales_materials_types.create');
    Route::post('/sales_materials_types/store',[sales_materials_typesController::class, 'store'])->name('admin.sales_materials_types.store');
    Route::get('/sales_materials_types/edit/{id}',[sales_materials_typesController::class, 'edit'])->name('admin.sales_materials_types.edit');
    Route::post('/sales_materials_types/update/{id}',[sales_materials_typesController::class, 'update'])->name('admin.sales_materials_types.update');
    Route::get('/sales_materials_types/delete/{id}',[sales_materials_typesController::class, 'delete'])->name('admin.sales_materials_types.delete');






    /*  end  sales_materials_types */

});

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware' =>'guest:admin'], function(){
    Route::get('login',[LoginController::class, 'showLoginView'])->name('admin.showLogin');
    Route::post('login',[LoginController::class, 'login'])->name('admin.login');
});
