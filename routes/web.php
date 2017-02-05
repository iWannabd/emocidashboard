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

Route::get('/', function () {
    return view('index');
});

Route::group(['prefix'=>'api'],function (){

    Route::post('auth','AuthController@authenticate');

    Route::group(['prefix'=>'orangHilang'],function (){
        Route::post('new','OlangController@store');
        Route::get('index','OlangController@index');
        Route::get('{id}','OlangController@show');
        Route::put('{id}/update','OlangController@update');
        Route::delete('{id}/delete','OlangController@destroy');
        Route::put('{id}/validate','OlangController@validasi');
    });

    Route::group(['prefix'=>'DPO'],function (){
        Route::post('new','DPOController@store');
        Route::get('index','DPOController@index');
        Route::put('{id}/update','DPOController@update');
        Route::delete('{id}/delete','DPOController@destroy');
        Route::put('{id}/validate','DPOController@validasi');

    });

    Route::group(['prefix'=>'Lantas'],function (){
        Route::post('new','InflantasController@store');
        Route::get('index','InflantasController@index');
        Route::put('{id}/update','InflantasController@update');
        Route::delete('{id}/delete','InflantasController@destroy');
    });

});
