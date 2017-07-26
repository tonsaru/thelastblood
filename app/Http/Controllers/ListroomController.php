<?php

namespace App\Http\Controllers;

use App\ListDonateroom;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\TestController;
use JWTAuth;
use App\User;
use App\ListDonate;

class ListroomController extends Controller
{
    //แสดง list ล่าสุดของแต่ละ roomreq_id ที่มี list เท่ากับ not complete
    public function roomreq_old(){
         $checkdata = DB::select('select * from list_donaterooms where (roomreq_id, donate_list) IN ( select roomreq_id, max(donate_list) from list_donaterooms GROUP BY roomreq_id )  and list_status = ? ', ['not complete']);
        //  return $checkdata;
         foreach ($checkdata as $key) {
             $arr4[] = [
                        'roomreq_id' => $key->roomreq_id,
                        'donate_list' => $key->donate_list,
                        'remaining' => $key->remaining,
                        'status' => $key->list_status
                    ];
         }
        return $arr4;

        // $resultArray = json_decode(json_encode($checkdata), true);
        // return $resultArray;
    }

    // เอาเฉพาะอันล่าสุดออกมา
    public function roomreq_new(){
         $checkdata = DB::select('select * from list_donaterooms where (roomreq_id, donate_list) IN ( select roomreq_id, max(donate_list) from list_donaterooms GROUP BY roomreq_id )  and list_status = ? ORDER BY id DESC LIMIT 1', ['not complete']);
        //  return $checkdata;
         foreach ($checkdata as $key) {
             $arr5[] = [
                        'roomreq_id' => $key->roomreq_id,
                        'donate_list' => $key->donate_list,
                        'remaining' => $key->remaining,
                        'status' => $key->list_status
                    ];
         }
        return $arr5;

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
        // return $lastno->no;
        // return $allcount;
        // input roomreq_id, countblood
        $req1 = new ListDonateroom;
        if($lastno == null){
            $no = 0;
            $req1->no = $no+1;
        }else{
            $req1->no = $lastno->no+1;
        }
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

    public function getrandom(){
        $lastno = DB::table('list_donaterooms')->orderBy('no', 'desc')->first();
        $lastlist = DB::select('select * from list_donaterooms where (roomreq_id, donate_list) IN ( select roomreq_id, max(donate_list) from list_donaterooms GROUP BY roomreq_id )  and no = ? ', [$lastno->no]);
        $address = DB::select('select province from users where id = (SELECT user_id FROM`roomreqs` ORDER BY id DESC limit 1)');
        $myadd = $address[0]->province;
        // return $myadd;
        //ต้องทำทั้งหมดกี่คน
        $sum = DB::select('select sum(`add`) as sum from list_donaterooms where (roomreq_id, donate_list) IN ( select roomreq_id, max(donate_list) from list_donaterooms GROUP BY roomreq_id )  and no = ?', [$lastno->no]);
        $sum_add = $sum[0]->sum;

        foreach ($lastlist as $key) {
            $list[] = [
                       'no' => $key->no,
                       'roomreq_id' => $key->roomreq_id,
                       'donate_list' => $key->donate_list,
                       'add' => $key->add,
                       'remaining' => $key->remaining,
                       'status' => $key->list_status,
                   ];
        }

        $cInArea = $this->InArea_count($myadd);
        $cOtherArea = $this->OtherArea_count($myadd);
        if( $sum_add  >= $cInArea ){
            $InArea_add = $cInArea;
            $OtherArea_add = $sum_add - $InArea_add;
        }else{
            $InArea_add = $sum_add;
            $OtherArea_add = 0;
        }
        // return "InArea_add : ".$InArea_add." OtherArea_add : ".$OtherArea_add;
        //เหลือกี่คนที่ต้องทำ
        $InArea_remain = $InArea_add;
        $OtherArea_remain = $OtherArea_add;
        $remain = $InArea_remain+$OtherArea_remain;
        foreach ($list as $key ) {
            // $req = DB::table('roomreqs')->select('countblood')->where('id', $key['roomreq_id'])->first();
            if( $InArea_remain > 0 ){
                if($key['add'] > $InArea_remain){
                    $add_do = $InArea_remain;
                    $this->InArea_random($key['roomreq_id'] , $add_do);
                    $InArea_remain = $InArea_remain - $add_do;

                    $add_do2 = $key['add'] - $add_do;
                    $this->OtherArea_random($key['roomreq_id'] ,$add_do2);
                    $InArea_remain = $InArea_remain - $add_do2;
                    $remain = $remain - ($add_do + $add_do2);

                }else{
                    $add_do = $key['add'];
                    $this->InArea_random($key['roomreq_id'] , $add_do);
                    $InArea_remain = $InArea_remain - $add_do;
                    $remain = $remain - $add_do;
                }
            }else{
                $add_do = $key['add'];
                $this->OtherArea_random($key['roomreq_id'] , $add_do);
            }

        }
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
                $arr6[] = [
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
                $arr6[] = [
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
        $lastno = DB::table('list_donaterooms')->orderBy('no', 'desc')->first();
        $req = new ListDonateroom;
        $req->no = $lastno->no;
        $req->roomreq_id = $arr6[0]['roomreq_id'];
        $req->donate_list = $arr6[0]['donate_list']+1;
        $req->add = $arr6[0]['add'];
        $req->remaining = $arr6[0]['remaining'];
        $req->list_status = $arr6[0]['list_status'];
        $req->save();

    }
//สร้าง DonatelistRoom ของตัวเก่า
    //input blood ที่เหลือ ( all_remaining ของอันแรก )
    //input person คนที่จะให้ทำงาน
    public function manageblood_old($person){
        $roomreq_old = $this->roomreq_old();
        $lastno = DB::table('list_donaterooms')->orderBy('no', 'desc')->first();
        // return "asdad";
        foreach ($roomreq_old as $key) {
            if($person >= $key['remaining'] && $person > 0){
                $add = $key['remaining'];
                $person -= $add;
                $arr7[] = [
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
                $arr7[] = [
                            'roomreq_id' => $key['roomreq_id'],
                            'donate_list' => $key['donate_list'],
                            'remaining' => $key['remaining']-$add,
                            'add' => $add,
                            'list_status' => 'not complete',
                            'all_remaining' => $person
                        ];

            }
        }
        foreach ($arr7 as $key) {
            //query max no
            // $checkno = DB::table('list_donaterooms')->where('roomreq_id', $key['roomreq_id']) ->orderBy('no', 'desc')->first();
              $req2 = new ListDonateroom;
              $req2->no = $lastno->no;
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
    public function InArea_count($province){
        return $this->InArea($province)->count();
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
    public function OtherArea_count($province){
        return $this->OtherArea($province)->count();
    }

// input $roomreq_id, $cblood, $count
    public function InArea_random($roomreq_id, $count){
        $que = DB::table('roomreqs')->orderBy('id', 'desc')->first();
        $data = $this->InArea($que->patient_province);
        $listnow = DB::table('list_donates')->select('donate_list')->where('roomreq_id',$roomreq_id)->max('donate_list');
        $lastremain = DB::select('select remaining from `list_donaterooms` where roomreq_id =:req_id && donate_list = ( select max(donate_list) from list_donaterooms where roomreq_id =:req_id2 )-1', ['req_id' => $roomreq_id,'req_id2' => $roomreq_id]);
        // return $lastremain[0]->remaining;
        if($listnow == null){
            $listnow = 0;
        }
        // return $data;

        if($data->count() == 0){
            return "no data"; //no updates
        }
        foreach ($data as $d) {
            $arr2[] =  $d->id;
        }
        if( count($arr2) < $lastremain[0]->remaining ){
            $datarand = $arr2;
            // return [$datarand, "aaaaa"];
        }else{
            $rand = array_rand($arr2, $count);
            sort($rand);
            foreach ($rand as $r) {
                $datarand[] = $arr2[$r];
            }
            // return [$datarand, 'bbbb'];
        }
        // return $datarand;
        foreach ($datarand as $ran) {
            $req = new ListDonate;
            $req->roomreq_id = $roomreq_id;
            $req->donate_list = $listnow+1;
            $req->user_id = $ran;
            $req->save();

            $update = User::find($ran);
            $update->status_mes = 'received';
            $update->save();
        }
    }

    public function OtherArea_random($roomreq_id, $remain, $add){
        $que = DB::table('roomreqs')->orderBy('id', 'desc')->first();
        $data = $this->OtherArea($que->patient_province);
        $listnow = DB::table('list_donates')->select('donate_list')->where('roomreq_id',$roomreq_id)->max('donate_list');
        $lastremain = DB::select('SELECT remaining FROM `list_donaterooms` where roomreq_id =:req_id && donate_list = ( select max(donate_list) from list_donaterooms where roomreq_id =:req_id2 )-1', ['req_id' => $roomreq_id,'req_id2' => $roomreq_id]);
        if($listnow == null){
            $listnow = 0;
        }
        // return $data;

        if($data->count() == 0){
            return "no data"; //no updates
        }
        foreach ($data as $d) {
            $arr3[] =  $d->id;
        }
        if( count($arr3) < $lastremain[0]->remaining ){
            $datarand = $arr3;
            // return [$datarand, "aaaaa"];
        }else{
            $rand = array_rand($arr3, $add);
            sort($rand);
            foreach ($rand as $r) {
                $datarand[] = $arr3[$r];
            }
            // return [$datarand, 'bbbb'];
        }
        foreach ($datarand as $ran) {
            $req = new ListDonate;
            $req->roomreq_id = $roomreq_id;
            $req->donate_list = $listnow+1;
            $req->user_id = $ran;
            $req->save();

            $update = User::find($ran);
            $update->status_mes = 'received';
            $update->save();
        }
    }



}
