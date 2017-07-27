<?php

namespace App\Http\Controllers;

use App\Roomdonate;
use App\Roomreq;
use App\User;
use DB;
use Illuminate\Http\Request;
use JWTAuth;

class RoomdonateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //show all request not my request at status not complete
     //จะแสดงแค่ห้องเด่วก็ให้มาใส่ เงื่อนไขตรงนี้เอา
    public function index()
    {
        // $currentUser = JWTAuth::parseToken()->authenticate();
        // // $check = DB::table('roomdonates')->select('roomreq_id')->where('user_id',$currentUser->id);
        // $user = DB::table('users')->where('id',$currentUser->id)->first();
        //
        // if($currentUser->status == "ready"){
        //     $req = DB::select('select users.name,roomreqs.user_id,roomreqs.id,roomreqs.patient_name,roomreqs.patient_blood,roomreqs.patient_blood_type,patient_province,users.img from roomreqs join users on users.id = roomreqs.user_id join list_donates on list_donates.roomreq_id = roomreqs.id where roomreqs.patient_status != ? AND roomreqs.user_id != ? AND list_donates.user_id = ?',[ 'complete',$currentUser->id,$currentUser->id]);
        //     if($req == null){
        //         $req = 'no data';
        //     }
        //     $data = array('user' => $req, 'last_date_donate' => $user->last_date_donate ,'status'=>$user->status);
        //     return $data;
        // }else{
        //     $req = null;
        //     $data = array('user' => $req, 'last_date_donate' => $user->last_date_donate ,'status'=>$user->status);
        //     return $data;
        // }
    }

    public function show(){
        $currentUser = JWTAuth::parseToken()->authenticate();
        $user = DB::table('users')->where('id',$currentUser->id)->first();

        if($currentUser->status == "ready"){
            $req = DB::select('select users.name,roomreqs.user_id,roomreqs.id,roomreqs.patient_name,roomreqs.patient_id,roomreqs.patient_blood,roomreqs.patient_blood_type,roomreqs.patient_province,roomreqs.patient_hos,roomreqs.created_at,roomreqs.countblood,users.img from roomreqs join users on users.id = roomreqs.user_id join list_donates on list_donates.roomreq_id = roomreqs.id where roomreqs.patient_status != ? AND roomreqs.user_id != ? AND list_donates.user_id = ? AND users.status_mes = ?',[ 'complete',$currentUser->id,$currentUser->id,'received']);
            if($req == null){
                $req = 'no data';
            }
            $data = array('user' => $req, 'last_date_donate' => $user->last_date_donate ,'status'=>$user->status);
            return $data;
        }else{
            $req = 'no data';
            $data = array('user' => $req, 'last_date_donate' => $user->last_date_donate ,'status'=>$user->status);
            return $data;
        }
        return $user;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $update = Roomreq::find($request->roomreq_id);

        if($currentUser->status == "ready"){
          if($request->status == 'accept'){
              // check add myself
              if($currentUser->id == $update->user_id)
              {
                  return "Hello myself";
              }

              $update->countblood = $update->countblood-1;
              // return $update;
              $update->save();

              $dona = new Roomdonate;
              $dona->roomreq_id = $request->roomreq_id;
              $dona->user_id = $currentUser->id;
              $dona->status = $request->status;
              $dona->save();

              $currentUser->status='unready';
              $currentUser->last_date_donate = $currentUser->updated_at;
              $currentUser->save();

              return "You donate blood to ".$update->patient_name.' Your Status is '.$currentUser->status." Roomreq blood remaining : ".$update->countblood;
          }else{
              $update = User::find($currentUser->id);
              $update->status_mes = 'not received';
              $update->save();
              return "you decline";
          }
        }
        return "you not ready plz check status or waiting time";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //  input roomreq_id
    public function showdetail(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        //check ว่าเข้าได้เฉพาะของที่ตัวเองมี
        // $req = DB::table('users')
        //     ->join('roomreqs', 'roomreqs.user_id', '=', 'users.id')
        //     ->join('roomdonates', 'roomdonates.roomreq_id', '=', 'roomreqs.id')
        //     ->select('users.name','users.img','roomreqs.patient_name','roomreqs.patient_id','roomreqs.patient_blood','roomreqs.patient_blood_type','roomreqs.patient_detail','roomreqs.patient_province','roomreqs.patient_hos','roomreqs.patient_hos_la','roomreqs.patient_hos_long','roomreqs.patient_thankyou','roomdonates.created_at')
        //     ->where([
        //         ['roomreqs.id',$request->roomreq_id],
        //         ['roomdonates.user_id', $currentUser->id]
        //     ])->get();
        //
        // if($req->count() == 0){
        //     return 'no data';
        // }
        // return $req;

        // $check = DB::table('roomdonates')->select('roomreq_id')->where('user_id',$currentUser->id);
        if($currentUser->status == "ready"){
            // $req = DB::table('roomreqs')
            //     ->join('users', 'users.id', '=', 'roomreqs.user_id')
            //     ->where('user_id', '!=', $currentUser->id)
            //     ->where('patient_status', '!=', 'complete')
            //     ->where('patient_province', $currentUser->province)
            //     ->where('roomreqs.id',$request->roomreq_id)
            //     ->select('roomreqs.id','roomreqs.patient_name','roomreqs.patient_blood','roomreqs.patient_blood_type','roomreqs.patient_province','roomreqs.patient_name','roomreqs.patient_id','roomreqs.patient_detail','roomreqs.patient_hos','roomreqs.patient_hos_la','roomreqs.patient_hos_long')
            //     ->whereNotIn('roomreqs.id', $check)
            //     ->get();

            $req = DB::select('select users.name,roomreqs.user_id,roomreqs.id,roomreqs.patient_name,roomreqs.patient_blood,roomreqs.patient_blood_type,patient_province,users.img from roomreqs join users on users.id = roomreqs.user_id join list_donates on list_donates.roomreq_id = roomreqs.id where roomreqs.patient_status != ? AND roomreqs.user_id != ? AND list_donates.user_id = ? AND users.status_mes = ?',[ 'complete',$currentUser->id,$currentUser->id,'received']);

            return $req;
        }else{
            return "no data";
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
