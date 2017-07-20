<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ListDonate;
use App\Roomdonate;
use App\Roomreq;
use App\User;
use DB;
use Dingo\Api\Routing\Helpers;
use JWTAuth;
use Validator;

class ListdonateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data = DB::table('listdonates')->get();
        return $data;
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

    // input province, roomreq_id
    //ครั้งแรก
    public function datashow(Request $request){
        $currentUser = JWTAuth::parseToken()->authenticate();
        // quey countblood ของห้อง roomreq_id นั้น
        $cblood = DB::table('roomreqs')->select('id','user_id','countblood')->where('id',$request->roomreq_id)->first();
        // return $cblood->countblood;
        $listnow = DB::table('list_donates')->select('donate_list')->where('roomreq_id',$request->roomreq_id)->max('donate_list');
        if($listnow == ''){
            $listnow = 0;
        }
        // return $listnow;
        // qeury user ที่กำลังใช้งานอยู่ในจังหวัดนี้ที่ status = ready แล้วไม่ใช่ตัวเอง
        $data = DB::table('users')
                    ->select('id','name','status')
                    ->where('province',$request->province)
                    ->where('id','!=',$currentUser->id)
                    ->where('status','ready')
                    ->get();
        if($data->count() == 0){
            return "no data"; //no updates
        }
        // return $data;
        // store query user in array
        foreach ($data as $d) {
            $arr[] =  $d->id;
        }
        // return count($arr);
        // return $arr;
        // return $cblood->countblood;
        //ถ้าจำนวนเลือดที่ต้องการมากกว่าคนที่อยู่วนระบบ ก็ไม่ต้องสุ่ม ถ้ามากกว่าก็ต้องสุ่ม
        if(count($arr) < $cblood->countblood){
            $datarand = $arr;
            // return [$datarand, "aaaaa"];
        }else{
            $rand = array_rand($arr,$cblood->countblood);
            sort($rand);
            foreach ($rand as $r) {
                $datarand[] = $arr[$r];
            }
            // return [$datarand, 'bbbb'];
        }
        // return $datarand;
        // create database
        foreach ($datarand as $ran) {
            $req = new ListDonate;
            $req->roomreq_id = $request->roomreq_id;
            $req->donate_list = $listnow+1;
            $req->user_id = $ran;
            $req->save();
        }
    }

    // check status in Roomdonates
    // input roomreq_id, province
    public function datamod(Request $request){
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data = DB::table('users')
                    ->join('roomdonates', 'roomdonates.user_id','=','users.id')
                    ->select('users.id','users.name','users.status')
                    ->where('users.province',$request->province)
                    // ->where('users.id','!=',$currentUser->id)
                    ->get();
        return $data;
        $cblood = DB::table('roomreqs')->select('id','user_id','countblood')->where('id',$request->roomreq_id)->first();

        foreach ($data as $d) {
                $arr[] =  $d->id;
        }
        if($cblood->countblood > count($arr)){
            $datarand[] = $arr;
        }else{
            $rand = array_rand($arr,$cblood->countblood);
            sort($rand);
            $datarand[] = $rand;
        }
    }


}
