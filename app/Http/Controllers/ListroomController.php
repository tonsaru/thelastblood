<?php

namespace App\Http\Controllers;

use App\ListDonateroom;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\TestController;
use JWTAuth;

class ListroomController extends Controller
{
    //แสดง list ล่าสุดของแต่ละ roomreq_id ที่มี list ท่ากับ mot complete
    public function checkstatus(){
         $checkdata = DB::select('select no, roomreq_id, donate_list, list_status from list_donaterooms where (roomreq_id, donate_list) IN ( select roomreq_id, max(donate_list) from list_donaterooms GROUP BY roomreq_id )  and list_status = ? ', ['not complete']);
        // return $checkdata;
        $resultArray = json_decode(json_encode($checkdata), true);
        return $resultArray;
    }

    public function checkstate(){
        $currentUser = JWTAuth::parseToken()->authenticate();
        // $test = new TestController;
        // return $test->f2();

        $data =  $this->checkstatus();
        $count = count($data);

        //แสดงรายชื่อที่ได้รับ message แล้ว ดูของอันล่าสุดของแต่ละห้อง
        $checkdata = DB::select('select distinct(user_id) as id, roomreq_id, donate_list, users.status, users.status_mes
            From list_donates JOIN users
            ON list_donates.user_id = users.id
            where (list_donates.roomreq_id, list_donates.donate_list) IN ( select roomreq_id, max(donate_list) from list_donates  GROUP BY roomreq_id )
            AND users.status =:status AND users.status_mes =:status2 ' , ['status' => 'ready','status2' => 'received']);
        $resultArray = json_decode(json_encode($checkdata), true);
        // return $resultArray;

        $sysCount = DB::table('users')
                        ->select('id', 'name', 'status','status_mes')
                        ->where('id', '!=', $currentUser->id)
                        ->where('status', 'ready')
                        ->where('status_mes', 'not received')
                        ->whereNotIn('id', $resultArray)
                        ->get();

        return $sysCount;
    }
}
