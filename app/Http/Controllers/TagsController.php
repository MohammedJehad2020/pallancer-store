<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function products($id){
         $tag = Tag::with([
               'products' => function($query){
                //    $query->where('status', '<>', 'draft');
                   $query->orderBy('name');
               }
         ])
         ->findOeFail($id);

        //  return $tag->load('products.category', 'products.store');// ممكن اعمل nested egar loading على مستوى العلاقة
        return $tag->products;// رجع العلاقة بشكل مباشر
    }
}
