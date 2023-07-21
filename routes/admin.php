<?php

use App\Http\Controllers\Admin\Admin_panel_settingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Inv_itemcard_categoriesController;
use App\Http\Controllers\Admin\InvItemCardController;
use App\Http\Controllers\Admin\InvUomsController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\Sales_materials_typesController;
use App\Http\Controllers\Admin\StoresController;
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
Route::group(['prefix'=>'admin','middleware' =>'auth:admin'], function(){
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

        /*  start stores  */
        Route::get('/stores/index',[StoresController::class, 'index'])->name('admin.stores.index');
        Route::get('/stores/create',[StoresController::class, 'create'])->name('admin.stores.create');
        Route::post('/stores/store',[StoresController::class, 'store'])->name('admin.stores.store');
        Route::get('/stores/edit/{id}',[StoresController::class, 'edit'])->name('admin.stores.edit');
        Route::post('/stores/update/{id}',[StoresController::class, 'update'])->name('admin.stores.update');
        Route::get('/stores/delete/{id}',[StoresController::class, 'delete'])->name('admin.stores.delete');

        /*  end  stores */

        /*  start uoms  */
                Route::get('/uoms/index',[InvUomsController::class, 'index'])->name('admin.uoms.index');
                Route::get('/uoms/create',[InvUomsController::class, 'create'])->name('admin.uoms.create');
                Route::post('/uoms/store',[InvUomsController::class, 'store'])->name('admin.uoms.store');
                Route::get('/uoms/edit/{id}',[InvUomsController::class, 'edit'])->name('admin.uoms.edit');
                Route::post('/uoms/update/{id}',[InvUomsController::class, 'update'])->name('admin.uoms.update');
                Route::get('/uoms/delete/{id}',[InvUomsController::class, 'delete'])->name('admin.uoms.delete');
                Route::post('/uoms/ajax_search',[InvUomsController::class, 'ajax_search'])->name('admin.uoms.ajax_search');

        /*  end  uoms */


        /*  start inv_itemcard_categories  */
            Route::get('/inv_itemcard_categories/{id}',[Inv_itemcard_categoriesController::class, 'delete'])->name('inv_itemcard_categories.delete');

            Route::resource('/inv_itemcard_categories', Inv_itemcard_categoriesController::class);

        /*  end inv_itemcard_categories  */

                /*  start Item card  */
                Route::get('/itemCard/index',[InvItemCardController::class, 'index'])->name('admin.itemCard.index');
                Route::get('/itemCard/create',[InvItemCardController::class, 'create'])->name('admin.itemCard.create');
                Route::post('/itemCard/store',[InvItemCardController::class, 'store'])->name('admin.itemCard.store');
                Route::get('/itemCard/edit/{id}',[InvItemCardController::class, 'edit'])->name('admin.itemCard.edit');
                Route::post('/itemCard/update/{id}',[InvItemCardController::class, 'update'])->name('admin.itemCard.update');
                Route::get('/itemCard/delete/{id}',[InvItemCardController::class, 'delete'])->name('admin.itemCard.delete');
                Route::post('/itemCard/ajax_search',[InvItemCardController::class, 'ajax_search'])->name('admin.itemCard.ajax_search');
                /*  end  Item card */

});

Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware' =>'guest:admin'], function(){
    Route::get('login',[LoginController::class, 'showLoginView'])->name('admin.showLogin');
    Route::post('login',[LoginController::class, 'login'])->name('admin.login');
});
