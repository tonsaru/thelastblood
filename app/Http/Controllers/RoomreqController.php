<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use JWTAuth;
use Config;
use Dingo\Api\Routing\Helpers;
use App\Roomreq;
use DB;
use App\Http\Controllers\Controller;

class RoomreqController extends Controller
{
    use Helpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     //แสดง req ทั้งหมดของ user ที่ login
    public function index()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $req = DB::table('roomreqs')->select('user_id','id','created_at','patient_name','patient_hos','patient_blood','patient_blood_type','patient_status')->where('user_id',$currentUser->id)->get();

        return response()->json($req);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
                Config::get('boilerplate.roomreq_create.validation_rules'),
                Config::get('boilerplate.roomreq_create.message')
        );

        if ($validator->fails()) {
            return $validator->messages();
        }

        // $check = Roomreq::where([
        //         ['patient_id',$request->patient_id],
        //         ['patient_hos',$request->patient_hos],
        //         ['patient_province',$request->patient_province]
        //     ])->first();
        //
        // if($check == ''){
            $currentUser = JWTAuth::parseToken()->authenticate();

            $req = new Roomreq;
            $req->user_id = $currentUser->id;
            $req->patient_id = $request->patient_id;
            $req->patient_name = $request->patient_name;
            $req->patient_blood = $request->patient_blood;
            $req->patient_blood_type = $request->patient_blood_type;
            $req->patient_detail = $request->patient_detail;
            $req->patient_province = $request->patient_province;
            $req->countblood = $request->countblood;
            $req->patient_hos = $request->patient_hos;
            if($request->patient_hos_la == "" || $request->patient_hos_long == ""){
                $request->patient_hos_la = 0;
                $request->patient_hos_long = 0;
            }
            $req->patient_hos_la = $request->patient_hos_la;
            $req->patient_hos_long = $request->patient_hos_long;

            $req->save();
            return "Request Success  : ".$req;
        // }elseif($check->patient_status == "not complete"){
        //     return "patient same";
        // }
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     //input roomreq_id my req
    public function show(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        //check ว่าเข้าได้เฉพาะของที่ตัวเองมี
        $req = DB::table('roomreqs')->where([
                ['id',$request->roomreq_id],
                ['user_id',$currentUser->id]
            ])->get();

        if($req->count() == 0){
            return 'no data';
        }
        return $req;
    }

    //input roomreq_id
    public function refresh(Request $request){

        $currentUser = JWTAuth::parseToken()->authenticate();

        //เช็คว่า roomreq_id ที่เข้าเป็นของเรารึเปล่า
        $update = Roomreq::find($request->roomreq_id);
        // return $update;
        if($update->user_id != $currentUser->id){
            return "not enter";
        }

        $update->count_refresh =$update->count_refresh+1;
        $update->save();

        return "Refresh Succesful  <br />UserID: ".$update->user_id."<br />RoomID : ".$update->id."<br />CountRefresh = ".$update->count_refresh;
    }

    // input roomreqID
    public function thankyou(Request $request){

        $currentUser = JWTAuth::parseToken()->authenticate();

        //เช็คว่า roomreq_id ที่เข้าเป็นของเรารึเปล่า
        $update = Roomreq::find($request->roomreq_id);
        // return $update;
        if($update->user_id == $currentUser->id){
            if($update->patient_status == 'complete'){
                $update->patient_thankyou = $request->thankyou;
                $update->save();
                return "Thank you for thanks";
            }else{
                return "Status is not complete";
            }
        }else{
            return "not enter";
        }
    }

    public function status_suc(Request $request){
        $currentUser = JWTAuth::parseToken()->authenticate();
            $update = Roomreq::find($request->roomreq_id);
            if($update->user_id == $currentUser->id){
                if($update->patient_status == 'complete'){
                    return "Status complete already";
                }else{
                    $update->patient_status = 'complete';
                    $update->save();
                    return "Status RoomreqID : ".$update->id." is ".$update->patient_status;
                }
            }else{
                return "Roomreq is not you ID";
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
