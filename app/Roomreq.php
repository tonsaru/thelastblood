<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Roomreq extends Model
{
    use Notifiable;

    protected $fillable = [
        'patient_status','patient_id','patient_name','patient_blood','patient_blood_type','patient_detail','patient_province','patient_hos','patient_hos_la','patient_hos_long','patient_thankyou','countblood'
    ];
}
