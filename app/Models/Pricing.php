<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pricing extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tb_pricing';
    public $timestamps = false;
    protected $guarded = [];
}
