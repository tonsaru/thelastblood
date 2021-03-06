<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Config;
use DB;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;
use JWTAuth;
use Validator;

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
        $data->blood = strtoupper($request->blood);
        $data->blood_type = strtoupper($request->blood_type);
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
             $path = $request->file('photo');
            //  return $path;
                // getClientOriginalExtension() return name file
            //  $filename = time() . '.' . $path->getClientOriginalExtension();
            //  return $filename;
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
            Storage::disk('public_avatar')->put($filename, File::get($photo));
	        // Storage::disk('public_avatar')->put($filename, $path);
            $data = User::find($currentUser->id);
            $data->img = $filename;
            $data->save();

            // $extension = $path->getClientOriginalExtension();
            //
            // // returns Intervention\Image\Image
            // $resize = Image::make($path);
            // // calculate md5 hash of encoded image
            // $hash = md5($resize->__toString());
            //
            // // use hash as a name
            // $path = "uploads/avatars/{$hash}.jpg";
            //
            // // save it locally to ~/public/uploads/avatars/{$hash}.jpg
            // $resize->save(public_path($path));
            // $filename = $hash.'.'.$extension;

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

    public function donate(){
        $currentUser = JWTAuth::parseToken()->authenticate();
        $dona = DB::table('roomdonates')
                    ->select('roomdonates.roomreq_id','roomdonates.user_id','roomdonates.status','roomreqs.user_id','users.name','users.img')
                    ->join('roomreqs', 'roomreqs.id', '=', 'roomdonates.roomreq_id')
                    ->join('users', 'users.id', '=', 'roomreqs.user_id')
                    ->where([
                        ['roomdonates.user_id',$currentUser->id],
                        ['roomdonates.status' ,'accept']
                    ])->get();
        return $dona;
    }

    public function donate_detail(Request $request){
        $currentUser = JWTAuth::parseToken()->authenticate();
        $dona = DB::table('roomdonates')
                    ->select('roomdonates.roomreq_id','roomdonates.user_id','roomdonates.status','roomreqs.user_id','users.name','users.img','roomreqs.patient_id','roomreqs.patient_name','roomreqs.patient_blood','roomreqs.patient_blood_type','roomreqs.patient_province','roomreqs.patient_hos','roomreqs.patient_hos_la','roomreqs.patient_hos_long','roomreqs.patient_thankyou','roomdonates.created_at')
                    ->join('roomreqs', 'roomreqs.id', '=', 'roomdonates.roomreq_id')
                    ->join('users', 'users.id', '=', 'roomreqs.user_id')
                    ->where([
                        ['roomdonates.user_id',$currentUser->id],
                        ['roomdonates.status' ,'accept'],
                        ['roomdonates.roomreq_id',$request->roomreq_id]
                    ])->get();
        return $dona;
    }

    public function strupper(){
          DB::statement('UPDATE users SET blood = UPPER(blood)');
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
