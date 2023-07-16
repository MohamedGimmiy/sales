<?php

use App\Http\Controllers\Admin\Admin_panel_settingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
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

define('PAGINATION_COUNT',1);
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

});

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware' =>'guest:admin'], function(){
    Route::get('login',[LoginController::class, 'showLoginView'])->name('admin.showLogin');
    Route::post('login',[LoginController::class, 'login'])->name('admin.login');
});
