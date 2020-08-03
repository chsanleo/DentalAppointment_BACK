<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = ['numExp', 'user_id', 'dateAppointment'];

    public function client()
    {
        return $this->belongTo('\App\User','user_id','id','users');
    }
}
