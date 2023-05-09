<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id','type_id','type','name','email','text','child','status','star'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // reply for music
    public function replies()
    {
        return $this->hasMany(Comment::class,'child')->where('status',1)->where('type','music');
    }
    // reply for blog
    public function replies2()
    {
        return $this->hasMany(Comment::class,'child')->where('status',1)->where('type','blog');
    }

    public function article()
    {
        return $this->belongsTo(Article::class,'type_id','id');
    }
    public function music()
    {
        return $this->belongsTo(Music::class,'type_id','id');
    }

    public function allReply()
    {
      return  $this->hasMany(Comment::class,'child');
    }

    public function editParentReply($type_id)
    {
        if($this->allReply()->count()):
        foreach ($this->allReply as $comment):
           $comment->type_id = $type_id;
           $comment->save();
        endforeach;
        endif;
    }



}
