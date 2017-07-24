<?php

namespace App\Http\Controllers;

use App\ListDonateroom;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\TestController;

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
        // $test = new TestController;
        // return $test->f2();

        $data =  $this->checkstatus();
        $count = count($data);

        //แสดงว่ามีใครที่ถูกส่งไปแล้วบ้าง (ทำผิด )
        // $checkdata = DB::select('select distinct(list_donates.user_id) as id, list_donates.roomreq_id, list_donates.donate_list,list_donaterooms.list_status
        //     From list_donates JOIN list_donaterooms
        //     ON list_donates.roomreq_id = list_donaterooms.roomreq_id AND list_donates.donate_list = list_donaterooms.donate_list
        //     where (list_donates.roomreq_id, list_donates.donate_list)
        //     IN ( select roomreq_id, max(donate_list) from list_donates  GROUP BY roomreq_id   )');


        //แสดงรายชื่อที่ได้รับ message แล้ว
        $checkdata = DB::select('select distinct(user_id) as id, roomreq_id, donate_list, users.status, users.status_mes
            From list_donates JOIN users
            ON list_donates.user_id = users.id
            where (list_donates.roomreq_id, list_donates.donate_list) IN ( select roomreq_id, max(donate_list) from list_donates  GROUP BY roomreq_id )
            AND users.status =:status AND users.status_mes =:status2 ' , ['status' => 'ready','status2' => 'received']);
        return $checkdata;
    }
}
