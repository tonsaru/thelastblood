<?php

namespace App\Http\Controllers;

use App\ListDonateroom;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\TestController;
use JWTAuth;

class ListroomController extends Controller
{
    //แสดง list ล่าสุดของแต่ละ roomreq_id ที่มี list เท่ากับ not complete
    public function roomreq_old(){
         $checkdata = DB::select('select * from list_donaterooms where (roomreq_id, donate_list) IN ( select roomreq_id, max(donate_list) from list_donaterooms GROUP BY roomreq_id )  and list_status = ? ', ['not complete']);
        //  return $checkdata;
         foreach ($checkdata as $key) {
             $arr[] = [
                        'roomreq_id' => $key->roomreq_id,
                        'donate_list' => $key->donate_list,
                        'remaining' => $key->remaining,
                        'status' => $key->list_status
                    ];
         }
        return $arr;

        // $resultArray = json_decode(json_encode($checkdata), true);
        // return $resultArray;
    }

    // เอาเฉพาะอันล่าสุดออกมา
    public function roomreq_new(){
         $checkdata = DB::select('select * from list_donaterooms where (roomreq_id, donate_list) IN ( select roomreq_id, max(donate_list) from list_donaterooms GROUP BY roomreq_id )  and list_status = ? ORDER BY id DESC LIMIT 1', ['not complete']);
        //  return $checkdata;
         foreach ($checkdata as $key) {
             $arr[] = [
                        'roomreq_id' => $key->roomreq_id,
                        'donate_list' => $key->donate_list,
                        'remaining' => $key->remaining,
                        'status' => $key->list_status
                    ];
         }
        return $arr;

        // $resultArray = json_decode(json_encode($checkdata), true);
        // return $resultArray;
    }

    //แสดงว่ามีใครที่ยังไม่ได้รับข้อความ ( ในระบบทั้งหมด )
    public function Nreceived(){
        $currentUser = JWTAuth::parseToken()->authenticate();

        //แสดงรายชื่อที่ได้รับ message แล้ว ดูของอันล่าสุดของแต่ละห้อง
        $checkdata = DB::select('select distinct(user_id) as id, roomreq_id, donate_list, users.status, users.status_mes
            From list_donates JOIN users ON list_donates.user_id = users.id
            where (list_donates.roomreq_id, list_donates.donate_list) IN ( select roomreq_id, max(donate_list) from list_donates  GROUP BY roomreq_id )
            AND users.status =:status AND users.status_mes =:status2 ' , ['status' => 'ready','status2' => 'received']);
        $resultArray = json_decode(json_encode($checkdata), true);
        // return $resultArray;

        //คนในระบบทั้งหมด ไม่ใช่ตัวเอง status = ready, status_mes = not recieved, ไม่ใช่คนที่เคย
        $sysCount = DB::table('users')
                        ->select('id', 'name', 'status','status_mes')
                        ->where('id', '!=', $currentUser->id)
                        ->where('status', 'ready')
                        ->where('status_mes', 'not received')
                        ->whereNotIn('id', $resultArray)
                        ->get();
        return $sysCount;
    }

    public function Nreceived_count(){
        return $this->Nreceived()->count();
    }
//สร้าง DonatelistRoom ของตัวล่าสุดครั้งแรก ( list เปล่า )
//ใช้ตอนที่สร้าง Roomreq เสร็จปัปเข้าฟังชั้นนี้เลย
// input countblood, roomreq_id
    public function getstarted(){
        $lastreq = DB::table('roomreqs')->orderBy('id', 'desc')->first();
        $lastno = DB::table('list_donaterooms')->orderBy('no', 'desc')->first();
        $cblood = $lastreq->countblood*10;

        if($lastno->no == ''){
            $lastno->no = 0;
        }
        // return $lastno->no;
        // return $allcount;
        // input roomreq_id, countblood
        $req1 = new ListDonateroom;
        $req1->no = 0;
        $req1->roomreq_id = $lastreq->id;
        // เริ่มที่ 0 เพราะว่าตอนทำจะได้เป็นครั้งแรก จะได้ดูง่ายๆ
        $req1->donate_list = 0;
        $req1->add = 0;
        $req1->remaining = $lastreq->countblood*10;
        $req1->save();
        //
        $allcount = $this->Nreceived_count();
        // $remain = $allcount //ตัวที่เหลืออยู่
        // return $allcount;

        /////////////////////////////////////////////////////////////////////////////////////////////////

        if($cblood >= $allcount){
            $add = $allcount;
            // return "asda";
            $this->manageblood_new($add);
        }else{

            $add = $cblood;
            // return "asada";
            $this->manageblood_new($add);
            // return "asada";
            $all_remain = $allcount - $add;
            // return "asada";
            $this->manageblood_old($all_remain);
        }
        return "finish";


        /////////////////////////////////////////////////////////////////////////////////////////////////
        // if( $allcount < $cblood ) {
        //     $this->manageblood_new($allcount);
        //     $remain = $remain - $rand->InArea_count();
        //     if( $cblood >= $rand->InArea_count() ){
        //         $cblood = $cblood - $rand->InArea_count();
        //         $rand->InArea_random( $lastreq->id, $cblood, $rand->InArea_count() );
        //         if( $cblood > 0 ){
        //             if( $cblood > $rand->OtherArea_count() ){
        //                 $cblood = $cblood - $rand->OtherArea_count();
        //                 $rand->OtherArea_random( $lastreq->id,$cblood,$rand->OtherArea_count() );
        //
        //                 return "Fin In,Other Area Not Complete, Remaining : ".$cblood;
        //             }else{
        //                 $rand->OtherArea_random( $lastreq->id, $cblood );
        //                 $status = 'complete';
        //                 return "Fin In,Other Area Complete";
        //             }
        //         }else{
        //             $status = 'complete';
        //             return "Fin InArea Complete";
        //         }
        //     }else{
        //         $rand->InArea_random( $cblood );
        //         $status = 'complete';
        //         return "Fin InArea Complete";
        //     }
        // }else{
        //     $this->manageblood_new($request);
        //     $remain = $remain - $rand->InArea_count();
        //     $cblood = $cblood - $rand->InArea_count();
        //     $rand->InArea_random();
        //     if( $cblood > 0 ){
        //         $rand->OtherArea_random();
        //         $remain = $remain - $rand->OtherArea_count();
        //         $this->manageblood_old($remain);
        //         $rand->OtherArea_random();
        //         return "fin In, Other Area Complete, ";
        //         }else{
        //             $status = "complete";
        //             $remain = $remain - $rand->OtherArea_count();
        //             $this->manageblood_old($remain);
        //             $rand->OtherArea_random();
        //
        //             return "fin In,Other Area Complete, Person Now, Old";
        //         }
        //     }else{
        //         $status = "complete";
        //         $this->manageblood_old($remain);
        //
        //         $rand->InArea_random($remain);//input จำนวนคนเข้าไป ทำการใส่ข้อมูลของแต่ละคนเข้าไปจนหมด แล้ว return ที่ยังไม่ได้ทำออกมาด้วย
        //         $remain = $remain - $rand->InArea_count();
        //         $rand->OtherArea_random($remain);
        //
        //         return "fin In Area Complete, Person Now, Olds";
        //     }
        // }
    }
//สร้าง DonatelistRoom ของตัวล่าสุดครั้งแรก
    public function manageblood_new($person){
        // return 'asda';
        $roomreq_new = $this->roomreq_new();
        // return 'asda';

        foreach ($roomreq_new as $key) {
            if($person >= $key['remaining'] && $person > 0){
                $add = $key['remaining'];
                $person -= $add;
                $arr[] = [
                            'roomreq_id' => $key['roomreq_id'],
                            'donate_list' => $key['donate_list'],
                            'remaining' => $key['remaining']-$add,
                            'add' => $add,
                            'list_status' => 'complete',
                            'all_remaining' => $person
                        ];

            }elseif($person > 0){
                $add = $person;
                $person -= $add;
                $arr[] = [
                            'roomreq_id' => $key['roomreq_id'],
                            'donate_list' => $key['donate_list'],
                            'remaining' => $key['remaining']-$add,
                            'add' => $add,
                            'list_status' => 'not complete',
                            'all_remaining' => $person
                        ];
            }
        }

        // return $arr;
        $lastno = DB::table('list_donaterooms')->where('roomreq_id',$arr[0]['roomreq_id'])->orderBy('no', 'desc')->first();
        $req = new ListDonateroom;
        $req->no = $lastno->no + 1;
        $req->roomreq_id = $arr[0]['roomreq_id'];
        $req->donate_list = $arr[0]['donate_list']+1;
        $req->add = $arr[0]['add'];
        $req->remaining = $arr[0]['remaining'];
        $req->list_status = $arr[0]['list_status'];
        $req->save();

    }
//สร้าง DonatelistRoom ของตัวเก่า
    //input blood ที่เหลือ ( all_remaining ของอันแรก )
    //input person คนที่จะให้ทำงาน
    public function manageblood_old($person){
        $roomreq_old = $this->roomreq_old();
        // return "asdad";
        foreach ($roomreq_old as $key) {
            if($person >= $key['remaining'] && $person > 0){
                $add = $key['remaining'];
                $person -= $add;
                $arr[] = [
                            'roomreq_id' => $key['roomreq_id'],
                            'donate_list' => $key['donate_list'],
                            'remaining' => $key['remaining']-$add,
                            'add' => $add,
                            'list_status' => 'complete',
                            'all_remaining' => $person
                        ];

            }elseif($person > 0){
                $add = $person;
                $person -= $add;
                $arr[] = [
                            'roomreq_id' => $key['roomreq_id'],
                            'donate_list' => $key['donate_list'],
                            'remaining' => $key['remaining']-$add,
                            'add' => $add,
                            'list_status' => 'not complete',
                            'all_remaining' => $person
                        ];

            }
        }
        foreach ($arr as $key) {
            //query max no
            $checkno = DB::table('list_donaterooms')->where('roomreq_id', $key['roomreq_id']) ->orderBy('no', 'desc')->first();
              $req2 = new ListDonateroom;
              $req2->no = $checkno->no+1;
              $req2->roomreq_id = $key['roomreq_id'];
              $req2->donate_list = $key['donate_list']+1;
              $req2->add = $key['add'];
              $req2->remaining = $key['remaining'];
              $req2->list_status = $key['list_status'];
              $req2->save();
          }
    }
    //available
    public function InArea($province){
        $currentUser = JWTAuth::parseToken()->authenticate();
        $checkdata = DB::select('select distinct(user_id) as id, roomreq_id, donate_list, users.status, users.status_mes
            From list_donates JOIN users ON list_donates.user_id = users.id
            where (list_donates.roomreq_id, list_donates.donate_list) IN ( select roomreq_id, max(donate_list) from list_donates  GROUP BY roomreq_id )
            AND users.status =:status AND users.status_mes =:status2 ' , ['status' => 'ready','status2' => 'received']);
            $resultArray = json_decode(json_encode($checkdata), true);
            $sysCount = DB::table('users')
                            ->select('id', 'name', 'status','status_mes','province')
                            ->where('id', '!=', $currentUser->id)
                            ->where('status', 'ready')
                            ->where('status_mes', 'not received')
                            ->where('province',$province)
                            ->whereNotIn('id', $resultArray)
                            ->get();
            return $sysCount;
    }
    public function InArea_count(Request $request){
        return $this->InArea($request)->count();
    }//input count person

    public function OtherArea($province){
        $currentUser = JWTAuth::parseToken()->authenticate();
        $checkdata = DB::select('select distinct(user_id) as id, roomreq_id, donate_list, users.status, users.status_mes
            From list_donates JOIN users ON list_donates.user_id = users.id
            where (list_donates.roomreq_id, list_donates.donate_list) IN ( select roomreq_id, max(donate_list) from list_donates  GROUP BY roomreq_id )
            AND users.status =:status AND users.status_mes =:status2 ' , ['status' => 'ready','status2' => 'received']);
            $resultArray = json_decode(json_encode($checkdata), true);
            $sysCount = DB::table('users')
                            ->select('id', 'name', 'status','status_mes','province')
                            ->where('id', '!=', $currentUser->id)
                            ->where('status', 'ready')
                            ->where('status_mes', 'not received')
                            ->where('province','!=',$province)
                            ->whereNotIn('id', $resultArray)
                            ->get();
            return $sysCount;
    }
    public function OtherArea_count(){
        return $this->OtherArea($request)->count();
    }

    public function InArea_random($roomreq_id, $cblood, $count){
        $que = DB::table('roomreqs')->orderBy('id', 'desc')->first();
        $data = $this->InArea($que->patient_province);
        $listnow = DB::table('list_donates')->select('donate_list')->where('roomreq_id',$roomreq_id)->max('donate_list');
        if($listnow == ''){
            $listnow = 0;
        }
        // return $data;

        if($data->count() == 0){
            return "no data"; //no updates
        }
        foreach ($data as $d) {
            $arr[] =  $d->id;
        }
        if( count($arr) < $cblood ){
            $datarand = $arr;
            // return [$datarand, "aaaaa"];
        }else{
            $rand = array_rand($arr,$count);
            sort($rand);
            foreach ($rand as $r) {
                $datarand[] = $arr[$r];
            }
            // return [$datarand, 'bbbb'];
        }
        foreach ($datarand as $ran) {
            $req = new ListDonate;
            $req->roomreq_id = $roomreq_id;
            $req->donate_list = $listnow+1;
            $req->user_id = $ran;
            $req->save();
        }
    }

    public function OtherArea_random($roomreq_id, $remain, $add){
        $que = DB::table('roomreqs')->orderBy('id', 'desc')->first();
        $data = $this->OtherArea($que->patient_province);
        $listnow = DB::table('list_donates')->select('donate_list')->where('roomreq_id',$roomreq_id)->max('donate_list');
        if($listnow == ''){
            $listnow = 0;
        }
        // return $data;

        if($data->count() == 0){
            return "no data"; //no updates
        }
        foreach ($data as $d) {
            $arr[] =  $d->id;
        }
        if( count($arr) < $remain ){
            $datarand = $arr;
            // return [$datarand, "aaaaa"];
        }else{
            $rand = array_rand($arr,$add);
            sort($rand);
            foreach ($rand as $r) {
                $datarand[] = $arr[$r];
            }
            // return [$datarand, 'bbbb'];
        }
        foreach ($datarand as $ran) {
            $req = new ListDonate;
            $req->roomreq_id = $roomreq_id;
            $req->donate_list = $listnow+1;
            $req->user_id = $ran;
            $req->save();
        }
    }



}
