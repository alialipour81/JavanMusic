<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;
    protected $fillable=[
      'album_id','artist_id','user_id',
      'name','image','text','quality_128','quality_320','status',
        'format_128','format_320','slug','downloadCount'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags_music()
    {
        return $this->tags()->pluck('tag_id')->toArray();
    }
    public function scopeSearched($query)
    {
        $search = request()->query('musics');
        if(!$search){
            return $query;
        }else{
            return $query->where('name','LIKE',"%{$search}%");
        }
    }

    public function visits()
    {
        return $this->hasMany(Visit::class,'type_id')->where('type','music');
    }
}
