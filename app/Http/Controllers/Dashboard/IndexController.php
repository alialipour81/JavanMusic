<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        if (auth()->user()->role != "admin"):
           return redirect(route('articles.index'));
        endif;
        $visits = Visit::all();
        $comments = Comment::where('child',0)->get();
        $users = User::searched()->orderBy('id','desc')->Paginate(15);
        $usersCount = User::all()->count();
        $viewsToday=$this->views_today();
        return view('dashboard.index')
            ->with('visits',$visits)
            ->with('comments',$comments)
            ->with('users',$users)
            ->with('usersCount',$usersCount)
            ->with('viewsToday',$viewsToday);
    }

    public function views_today()
    {
        $views = Visit::all();
        $today=[];
        foreach ($views as $view):
           if ($view->created_at->format('Y-m-d') == today()->format('Y-m-d')):
           array_push($today,$view);
           endif;
        endforeach;
        return $today;
    }
}
