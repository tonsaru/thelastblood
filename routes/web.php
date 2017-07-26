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
    return view('welcome');
});

Route::get('admin/roomreq','RoomreqController@admin_index');
Route::get('admin/roomreq2','RoomreqController@admin_index2');
Route::post('admin/roomreq2/edit', 'RoomreqController@update')->name('editreq');;

Route::resource('adminreq', 'ItemAjaxController');

Route::get('ajaxview',function(){
    return view('testajax');
});

Route::get('ajaxview2',function(){
    return view('test');
});

Route::get('ajax1','TestController@ajax1');
Route::get('ajax2','TestController@ajax2');
Route::get('ajax3','TestController@ajax3');
Route::get('ajax4','TestController@ajax4');
