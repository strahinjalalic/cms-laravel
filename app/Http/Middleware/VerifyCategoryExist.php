<?php

namespace App\Http\Middleware;

use App\Category;
use Closure;

class VerifyCategoryExist
{
    public function handle($request, Closure $next)
    {
        if(Category::all()->count() === 0) {
            session()->flash('error', 'You can not create post without categories.');
            return redirect()->back();
        }

        return $next($request);
    }
}
