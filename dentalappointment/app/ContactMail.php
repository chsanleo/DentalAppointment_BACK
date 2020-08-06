<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMail extends Model
{
    use SoftDeletes;

    protected $fillable = ['contactMail', 'user_id', 'subject', 'message'];

}
