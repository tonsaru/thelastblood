<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    use Helpers;

    public function index(){
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser;
    }

    public function edit(Request $request){
        $currentUser = JWT::parseToken()->authenticate();
        $data = User::find($currentUser->id);
        $data->email = $request->email;
        $data->blood = $request->blood;
        $data->blood_type = $request->blood_type;
        $data->birthyear = $request->birthyear;
        $data->firstname = $request->firstname;
        $data->lastname = $request->lastname;
        $data->province = $request->province;
        $data->countblood = $request->countblood;
        $data->img = $request->img;
        $data->save();
        return "Updata profile success";
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
