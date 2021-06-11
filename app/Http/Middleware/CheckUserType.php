<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // $user = Auth::user();
        $user = $request->user();

        if($user->type != 'admin'){
            abort(403, 'You are not Admin');
        }
        // response
        return $next($request);// اذا كان الميدل وير صحيح كمل باقي الطلب 

        // $response = $next($request);
        // $html = $response->content();
        // $htmal = str_ireplace('t-shirt', '<span style="color:red">T-shirt</span>', $html);

        // return response($html);

    }
}
