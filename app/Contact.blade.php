<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $table = "contact";
    protected $primaryKey = "cid";
    public $timestamps = false; 
}
