<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

     protected $primaryKey = 'id';
    protected $table = 'register';
    public $timestamps = false;


}
