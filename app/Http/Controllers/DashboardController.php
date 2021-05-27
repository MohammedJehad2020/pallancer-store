<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function culc($n1,$op,$n2){
        
       if($op == 'add'){
           return $n1 + $n2;

       }else if($op == 'sub'){
           return $n1 - $n2;

       }else if($op == 'multi'){
           return $n1 * $n2;

       }else if($op == 'div'){
        return $n1 / $n2;

       }
       

    }

}
