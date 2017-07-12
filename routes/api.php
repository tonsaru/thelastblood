<?php

use Illuminate\Http\Request;
use Dingo\Api\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app(Router::class);

$api->version('v1', function (Router $api) {

    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('login', 'App\\Http\\Controllers\\LoginController@login');
        $api->post('check', 'App\\Http\\Controllers\\RegisterController@check');
        $api->post('pim', 'App\\Http\\Controllers\\RegisterController@pim');
        $api->post('register', 'App\\Http\\Controllers\\RegisterController@signUp');
    });

    $api->group(['middleware' => ['api.auth', 'jwt.auth']], function (Router $api) {

        $api->post('avatar','App\\Http\\Controllers\\UserController@update_avatar');
        $api->post('edit','App\\Http\\Controllers\\UserController@edit');
        $api->get('index', 'App\\Http\\Controllers\\UserController@index');
        $api->get('logout', 'App\\Http\\Controllers\\UserController@logout');
        $api->post('settime','App\\Http\\Controllers\\UserController@setTime');
        $api->get('swap', 'App\\Http\\Controllers\\UserController@swapstatus');

        $api->resource('req','App\\Http\\Controllers\\RoomreqController');
        $api->post('req/detail','App\\Http\\Controllers\\RoomreqController@show');
        $api->post('req/refresh','App\\Http\\Controllers\\RoomreqController@refresh');
        $api->post('req/success','App\\Http\\Controllers\\RoomreqController@status_suc');
        $api->post('req/thankyou','App\\Http\\Controllers\\RoomreqController@thankyou');

        $api->resource('donate','App\\Http\\Controllers\\RoomdonateController');

        $api->resource('friend','App\\Http\\Controllers\\FriendController');
    });

});
