<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roomdonate;
use App\User;
use DB;
use JWTAuth;
use App\Roomreq;

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
        // if($currentUser->status == "ready"){
            $req = DB::table('roomreqs')
                ->select('user_id','id','patient_name','patient_blood','patient_blood_type','patient_province','patient_hos','patient_status')
                ->where('user_id', '!=', $currentUser->id)
                ->where('patient_status', '!=', 'complete')
                ->where('patient_province', $currentUser->province)
                ->get();
            $data = array('user' => $req, 'last_date_donate' => $currentUser->last_date_donate);
            return $data;
        // }
        // return "you not ready plz check status or waiting time";
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
    public function show($id)
    {
        //
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
