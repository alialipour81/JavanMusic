<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role != 'admin'):
            session()->flash('error','وارد شدن به این بخش(داشبورد مدیریت) فقط برای ادمین ها امکان پذیر است');
           return redirect(route('articles.index'));
        endif;
        return $next($request);
    }
}
