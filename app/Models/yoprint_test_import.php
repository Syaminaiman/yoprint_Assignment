<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class yoprint_test_import extends Model
{
    protected $table = 'yoprint_test_import';
    // Specify the custom primary key column
    protected $primaryKey = 'UNIQUE_KEY';
    public $timestamps = false;

}
