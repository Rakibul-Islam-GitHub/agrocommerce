<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
     protected $table = "news";
   protected $primaryKey = "newsid";
   public $timestamps = false;
}
