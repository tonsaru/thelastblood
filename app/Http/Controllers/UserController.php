<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use JWTAuth;



class UserController extends Controller
{
    use Helpers;

    public function index(){
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser;
    }

    public function logout(){
         $currentUser = JWTAuth::parseToken()->authenticate();
         $user = JWTAuth::getToken($currentUser);
         JWTAuth::invalidate($user);
         return "Delete Token Success";
     }
}
