<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function products(){
        return $this->belongsToMany(
            Product::class,
            'product_tag',// الجدول الوسيط
            'tag_id',// foriegn key for current class in bivot table
            'product_id',// foreign key for second class
            'id',
            'id',
        );
    }
}
