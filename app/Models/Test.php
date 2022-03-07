<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Test extends Model
{
    protected $connection = 'mysql';
    protected $table = 'test_import';
    public $timestamps = false;
    protected $guarded = [];
}
