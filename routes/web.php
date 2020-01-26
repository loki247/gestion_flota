<?php

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


/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('logout', 'Auth\LoginController@logout');

    Route::get('/', 'HomeController@index')->name('home');

    //Flota
    Route::prefix('flota')->group(function () {

        //Salones
        Route::prefix('salones')->group(function (){
            Route::get('', 'Flota\SalonController@viewSalones');
            Route::get('getsalones', 'Flota\SalonController@getSalones');
            Route::get('getsalonbyid', 'Flota\SalonController@getSalonById');
            Route::post('savesalon', 'Flota\SalonController@saveSalon');
            Route::post('editsalon', 'Flota\SalonController@editSalon');
            Route::post('deletesalon', 'Flota\SalonController@deleteSalon');
        });

        //Buses
        Route::prefix('buses')->group(function (){
            Route::get('', 'Flota\BusController@viewBuses');
            Route::get('getbuses', 'Flota\BusController@getBuses');
            Route::get('getbusbyid', 'Flota\BusController@getBusById');
            Route::post('savebus', 'Flota\BusController@saveBus');
            Route::post('editbus', 'Flota\BusController@editBus');
            Route::post('deletebus', 'Flota\BusController@deleteBus');
        });

        //Mantenciones
        Route::prefix('mantencion')->group(function () {
            Route::get('', 'Flota\MantencionController@viewMantenciones');
            Route::get('getmantenciones', 'Flota\MantencionController@getMantenciones');
            Route::get('getmantencionbyid', 'Flota\MantencionController@getMantencionById');
            Route::post('savemantencion', 'Flota\MantencionController@saveMantencion');
            Route::post('editmantencion', 'Flota\MantencionController@editMantencion');
            Route::post('deletemantencion', 'Flota\MantencionController@deleteMantencion');

            Route::prefix('ordenescompra')->group(function () {
                Route::get('', 'Flota\OrdenCompraController@viewOrdenesCompra');
                Route::get('getordenescompra', 'Flota\OrdenCompraController@getOrdenesCompra');
                Route::get('getordencomprabyid', 'Flota\OrdenCompraController@getOrdenCompraById');
                Route::post('saveordencompra', 'Flota\OrdenCompraController@saveOrdenCompra');
                Route::post('editordencompra', 'Flota\OrdenCompraController@editOrdenCompra');
                Route::post('deleteordencompra', 'Flota\OrdenCompraController@deleteOrdenCompra');
            });
        });
    });


});