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


    /*  end  treasures */

});

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware' =>'guest:admin'], function(){
    Route::get('login',[LoginController::class, 'showLoginView'])->name('admin.showLogin');
    Route::post('login',[LoginController::class, 'login'])->name('admin.login');
});
