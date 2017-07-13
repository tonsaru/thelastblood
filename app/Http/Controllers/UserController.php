<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use DB;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Image;
use JWTAuth;
use Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class UserController extends Controller
{
    use Helpers;

    public function index(){
        $currentUser = JWTAuth::parseToken()->authenticate();
        return $currentUser;
    }

    public function edit(Request $request){
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data = User::find($currentUser->id);
        $data->blood = strtolower($request->blood);
        $data->blood_type = strtolower($request->blood_type);
        $data->email = $request->email;
        $data->birthyear = $request->birthyear;
        $data->province = $request->province;
        $data->save();
        return "Updata profile success";
    }

    // input image file name photo
    public function update_avatar(Request $request) {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $validator = Validator::make($request->all(),
                      Config::get('boilerplate.edit_avatar.validation_rules'),
                      Config::get('boilerplate.edit_avatar.message'));

         if ($validator->fails()) {
              return $validator->messages();
         }
        //  else{
            //  $path = $request->file('photo');
            //  return $path;
             // getClientOriginalExtension() return name file
            //  $filename = time() . '.' . $path->getClientOriginalExtension();
            //  return public_path('/uploads/avatars/');
            //  $img = Image::make($path);
            //  return $img;
             //quality image 60%
            //  $img->save( public_path('/uploads/avatars/' . $filename ), 60);
            //  $user = Auth::user();
                //  $user->img = $filename;
                //  $user->save();

            $photo = $request->file('photo');
    		$extension = $photo->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
    		Storage::disk('avatars')->put($filename.'.'.$extension,  File::get($photo));

            $data = User::find($currentUser->id);
            $data->img = $filename;
            $data->save();


             return "Upload profile success, Image name : ".$filename;
        //  }
    }

    public function setTime(Request $request){
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data = User::find($currentUser->id);
        $data->last_date_donate = $request->last_date_donate;
        $data->save();
        return "Set last_date_donate time : ".$data->last_date_donate;
    }

    // input last_date_donate type timestamp
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
