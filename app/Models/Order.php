<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tb_order_backup';
    public $timestamps = false;
    protected $guarded = [];
}
