<?php

namespace App\Http\Controllers;

use App\Friend;
use App\User;
use DB;
use Illuminate\Http\Request;
use JWTAuth;

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
        $data = DB::table('friends')
                    ->join('users', 'friends.friend_id', '=', 'users.id')
                    ->select('friends.user_id','friends.friend_id','users.name','users.phone','users.status','users.blood','users.blood_type','users.img')
                    ->where('user_id',$currentUser->id )
                    ->get();
        return $data;
    }

    public function indexGroup(Request $request)
    {
        $currentUser = JWTAuth::parseToken()->authenticate();
        $data = DB::table('friends')
                    ->join('users', 'friends.friend_id', '=', 'users.id')
                    ->select('friends.user_id','friends.friend_id','users.name','users.phone','users.status','users.blood','users.blood_type','users.img')
                    ->where('user_id',$currentUser->id);
        if($request->blood == 'ALL'){
            $check = array('A','B','O','AB');
            $data = $data->whereIn('users.blood',$check)->get();
        } else{
            $data = $data->where('users.blood',$request->blood)->get();
        }

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
                        ->where('id','!=',$currentUser->id)
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
        foreach ($newarr as $key => $value) {
            $req = new Friend;
            $req->user_id = $value;
            $req->friend_id = $currentUser->id;
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
