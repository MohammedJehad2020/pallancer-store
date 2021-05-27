<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'stores';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    const CREATE_AT = 'created_at';

    const UPDATED_AT = 'updated_at';



}