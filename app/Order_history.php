<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_history extends Model
{
    protected $table = "order_history";
    protected $primaryKey = "ohid";
    public $timestamps = false;

   //const CREATED_AT = 'creation_date';
   //const UPDATED_AT = 'last_update';
}
