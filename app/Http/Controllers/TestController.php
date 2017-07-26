<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Validator;
use DB;

class TestController extends Controller
{
    public function f1($n){

        $arr = array('aaa','bbb','ccc','ddd');
        return $arr[$n];

    }

    public function f2(){
        $str = "bbb";
        $num = (string)$this->f1(rand(0,3));
        return $str.$num;
    }


  // /////////////////////////////////////////////////////////////
    public function ajax1(){
      return "bra ";
    }

    public function ajax2() {
        return "asda";
    }

    public function ajax3(){
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser;
    }

    public function ajax4(){
        $data = DB::table('users')->get();
        return Response()->json($data);
    }

    //////////////////////////////////////////////////////////////////////

    public function test1(){
        
    }

}
