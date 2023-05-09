<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable=[
      'category_id','user_id','title','slug','image','description','other_users_sub','other_users_acc','status'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function tags_select($tag)
    {
        return in_array($tag,$this->tags()->pluck('tag_id')->toArray());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
   static public function users_moshtarak($array)
    {
        $users1=[];
        $users2= explode('-',$array);
        foreach ($users2 as $user){
            $user2= User::where('id',$user)->first();
            array_push($users1,$user2);
        }
        return $users1;

    }
    static function articles_moshtarak()
    {
        $moshtraks = [];
        $articles= $articles = Article::orderBy('id','desc')->Paginate(15);
        foreach ($articles as $article):
            if($article->other_users_sub != 0){
                foreach (Article::users_moshtarak($article->other_users_sub) as $user):
                    if(auth()->user()->id == $user->id && $article->user_id != auth()->user()->id){
                        array_push($moshtraks,$article);
                    }
                endforeach;
            }

        endforeach;
        return $moshtraks;
    }

    public function info_user($id)
    {
        return User::where('id',$id)->first();
    }

    public function get_visit($article_id)
    {
        return Visit::where('type','blog')->where('type_id',$article_id)->get();
    }
    public function scopeSearched($query)
    {
        $search = request()->query('article');
        if(!$search){
            return $query;
        }else{
            return $query->where('title','LIKE',"%{$search}%");
        }
    }
    public function comments($article)
    {
        return Comment::where('child',0)->where('type','blog')->where('type_id',$article->id)->where('status',1)->orderBy('id','desc')->get();
    }

    static public function average_stars($comments,$type=null,$type_id=null)
    {
        $stars =[];
        foreach ($comments->toArray() as $comment):
            array_push($stars,$comment['star']);
        endforeach;
        if(!empty($stars))
            return array_sum($stars) / count($stars);
        else
            return null;
    }
}
