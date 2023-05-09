<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Comment\ReplyRequestComment;
use App\Http\Requests\Dashboard\Comment\UpdateRequestComment;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Music;
use App\Models\User;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::orderBy('id','desc')->Paginate(30);
        return view('dashboard.comments.index')
            ->with('comments',$comments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ذخیره نظر در متد (commentStore) در کلاس index انجام شده است
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return view('dashboard.comments.reply')
            ->with('comment',$comment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        if ($comment->type == "music"):
            $items = Music::where('status',1)->get();
        else:
            $items = Article::where('status',1)->get();
        endif;
        $statuses =['0'=>'عدم نمایش','1'=>'نمایش'];
        $users = User::orderBy('id','desc')->get();
        return view('dashboard.comments.edit')
            ->with('comment',$comment)
            ->with('items',$items)
            ->with('statuses',$statuses)
            ->with('users',$users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestComment $request, Comment $comment)
    {
        $comment->update([
           'status'=>$request->status,
            'text'=>$request->text
        ]);
        if(!empty($request->type_id)):
            $comment->editParentReply($request->type_id);
            $comment->type_id = $request->type_id;
        endif;
        if(!empty($request->star)):
            $this->validate($request,[
               'star'=>['integer']
            ]);
            $comment->star = $request->star;
        endif;
        if ($comment->name != null): $lastnameUser=$comment->name; else: $lastnameUser=$comment->user->name; endif;
       if(!empty($request->username)):
           $user = $request->username;
           $comment->name = $request->username;
       endif;
        if(!empty($request->user_id)):
            $this->validate($request,[
               'user_id'=>['integer']
            ]);
        $user = $comment->user->name;
        $comment->user_id = $request->user_id;
        endif;
        $comment->save();
        session()->flash('success',' نظر  ردیف  '.$comment->id.' باموفقیت ویرایش شد ');
        return redirect(route('comments.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if ($comment->allReply()->count()):
            foreach ($comment->allReply as $reply):
                $reply->delete();
            endforeach;
            $comment->delete();
        else:
            $comment->delete();
        endif;
        session()->flash('success',"نظر و پاسخ های آن(درصورت وجود) با موفقیت حذف شدند" );
        return redirect(route('comments.index'));
    }

    public function reply(ReplyRequestComment $request,Comment $comment)
    {
         Comment::create([
             'user_id' => auth()->user()->id,
             'type'=>$comment->type,
             'type_id' => $comment->type_id,
             'text' => $request->text,
              'child'=>$comment->id,
             'status'=>1
         ]);
         $comment->status =1;
         $comment->save();
         if(empty($comment->name)):
             $user = $comment->user->name;
         else:
             $user = $comment->name;
         endif;
         session()->flash('success',' پاسخ به '.$user.' با موفقیت ارسال شد ');
         return redirect(route('comments.index'));
    }
}
