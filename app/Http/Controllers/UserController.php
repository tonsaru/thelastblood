<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    use Helpers;

    public function index(){
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser;
    }

    public function showDonate(){
        $currentUser = JWTAuth::parseToken()->authenticate();
        $dona = DB::table('roomdonates')->select('id','roomreq_id','user_id','status')->where('user_id',$currentUser->id)->get();
        return $dona;
    }

    //swap ready,unready
    public function swapstatus(){
      $currentUser = JWTAuth::parseToken()->authenticate();
      if($currentUser->status =='unready'){
          $currentUser->status = "ready";
          $currentUser->save();
      }else{
          $currentUser->status='unready';
          $currentUser->save();
      }
      return $currentUser->name.". Statuts is ".$currentUser->status;
    }

    public function logout(){
         $currentUser = JWTAuth::parseToken()->authenticate();
         $user = JWTAuth::getToken($currentUser);
         JWTAuth::invalidate($user);
         return "Delete Token Success";
     }
}
