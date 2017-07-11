<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use JWTAuth;
use App\Friend;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data = DB::select('SELECT friends.user_id,friends.friend_id,users.name,users.phone,users.status,users.blood,users.blood_type,users.img
                            FROM `friends`,`users`
                            WHERE (users.id = friends.friend_id) && (user_id = :id)',
                            ['id' => $currentUser->id]);
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
    //  Input array friend
    public function store(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        // $data = array('656656','121212','22222222','33333333','44444444','55555555','4541212');

        //User using application
        foreach ($request->friend as $key) {
            $req = DB::table('users')
                        ->select('id')
                        ->where('phone', '=', $key)
                        ->first();
            if($req != null){
                $arr[] = $req;
            }
        }

        //บอกว่าเพื่อนมีใครบ้าง
        //Make $newarr store new friend (user_id not friend)
        foreach ($arr as $key => $value) {
            $check = DB::table('friends')
                        ->where('user_id','=',$currentUser->id)
                        ->where('friend_id','=',$value->id)
                        ->first();
                        // return $check;
            if($check == null){
                $newarr[] = $value->id;
            }else{
                $newarr = null;
            }
        }
        // return $newarr;
        if($newarr == null){
            return "No update Friend";
        }
        // return $newarr;

        //Add friend
        foreach ($newarr as $key => $value) {
            $req = new Friend;
            $req->user_id = $currentUser->id;
            $req->friend_id = $value;
            $req->save();
        }
        return "Request Success  : ".$req;
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
