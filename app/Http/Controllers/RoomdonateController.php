<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roomdonate;
use App\Roomreq;
use App\User;
use DB;
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
        $currentUser = JWTAuth::parseToken()->authenticate();
        $check = DB::table('roomdonates')->select('roomreq_id')->where('user_id',$currentUser->id);

        if($currentUser->status == "ready"){
            $req = DB::table('roomreqs')
                ->join('users', 'users.id', '=', 'roomreqs.user_id')
                ->where('user_id', '!=', $currentUser->id)
                ->where('patient_status', '!=', 'complete')
                ->where('patient_province', $currentUser->province)
                ->select('users.name','roomreqs.user_id','roomreqs.id','roomreqs.patient_name','roomreqs.patient_blood','roomreqs.patient_blood_type')
                ->whereNotIn('roomreqs.id', $check)
                ->get();
            $data = array('user' => $req, 'last_date_donate' => $currentUser->last_date_donate ,'img' => $currentUser->img,'status'=>$currentUser->status);
            return $data;
        }else{
            $req = null;
            $data = array('user' => $req, 'last_date_donate' => $currentUser->last_date_donate ,'img' => $currentUser->img,'status'=>$currentUser->status);
            return $data;
        }

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
    public function show(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        //check ว่าเข้าได้เฉพาะของที่ตัวเองมี
        $req = DB::table('roomreqs')
            ->select('patient_name','patient_id','patient_blood','patient_blood_type','patient_detail','patient_province','patient_hos','patient_hos_la','patient_hos_long')
            ->where([
                ['id',$request->roomreq_id]
            ])->get();

        if($req->count() == 0){
            return 'no data';
        }
        return $req;
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
