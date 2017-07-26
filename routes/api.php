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

        $api->get('ajax1', 'App\\Http\\Controllers\\TestController@ajax1');
        $api->get('ajax2', 'App\\Http\\Controllers\\TestController@ajax2');
        $api->get('ajax3', 'App\\Http\\Controllers\\TestController@ajax3');
        $api->get('ajax4', 'App\\Http\\Controllers\\TestController@ajax4');
        $api->get('f2', 'App\\Http\\Controllers\\TestController@f2');

        $api->get('user', 'App\\Http\\Controllers\\UserController@index');
        $api->get('logout', 'App\\Http\\Controllers\\UserController@logout');
        $api->get('user/donate', 'App\\Http\\Controllers\\UserController@donate');
        $api->get('user/swap', 'App\\Http\\Controllers\\UserController@swapstatus');
        $api->post('user/avatar','App\\Http\\Controllers\\UserController@update_avatar');
        $api->post('user/donate/detail', 'App\\Http\\Controllers\\UserController@donate_detail');
        $api->post('user/edit','App\\Http\\Controllers\\UserController@edit');
        $api->post('user/settime','App\\Http\\Controllers\\UserController@setTime');

        $api->resource('req','App\\Http\\Controllers\\RoomreqController');
        $api->post('req/detail','App\\Http\\Controllers\\RoomreqController@show');
        $api->post('req/refresh','App\\Http\\Controllers\\RoomreqController@refresh');
        $api->post('req/success','App\\Http\\Controllers\\RoomreqController@status_suc');
        $api->post('req/thankyou','App\\Http\\Controllers\\RoomreqController@thankyou');

        $api->resource('donate','App\\Http\\Controllers\\RoomdonateController');
        $api->post('donate/detail','App\\Http\\Controllers\\RoomdonateController@show');
        $api->post('donate/index','App\\Http\\Controllers\\RoomdonateController@index');

        $api->resource('friend','App\\Http\\Controllers\\FriendController');
        $api->post('friend/detail','App\\Http\\Controllers\\FriendController@indexGroup');

        $api->resource('ldonate','App\\Http\\Controllers\\ListdonateController');
        $api->post('ldonate/data','App\\Http\\Controllers\\ListdonateController@datashow');
        $api->post('ldonate/data2','App\\Http\\Controllers\\ListdonateController@datamod');

        $api->get('Rdonate/roomreq/old','App\\Http\\Controllers\\ListroomController@roomreq_old');
        $api->get('Rdonate/roomreq/new','App\\Http\\Controllers\\ListroomController@roomreq_new');
        $api->get('Rdonate/nreceived','App\\Http\\Controllers\\ListroomController@Nreceived');
        $api->get('Rdonate/nreceived/count','App\\Http\\Controllers\\ListroomController@Nreceived_count');
        $api->post('Rdonate/manage/old','App\\Http\\Controllers\\ListroomController@manageblood_old');
        $api->post('Rdonate/manage/new','App\\Http\\Controllers\\ListroomController@manageblood_new');
        $api->get('Rdonate/getstarted','App\\Http\\Controllers\\ListroomController@getstarted');
        $api->get('Rdonate/getrandom','App\\Http\\Controllers\\ListroomController@getrandom');
        $api->post('Rdonate/InArea','App\\Http\\Controllers\\ListroomController@InArea_count');
        $api->post('Rdonate/InArea/count','App\\Http\\Controllers\\ListroomController@InArea_count');
        $api->post('Rdonate/InArea/random','App\\Http\\Controllers\\ListroomController@InArea_random');

        $api->post('Rdonate/OtherArea','App\\Http\\Controllers\\ListroomController@OtherArea');
        $api->post('Rdonate/OtherArea/count','App\\Http\\Controllers\\ListroomController@OtherArea_count');
        $api->get('Rdonate/OtherArea/random','App\\Http\\Controllers\\ListroomController@OtherArea_random');


    });
});
