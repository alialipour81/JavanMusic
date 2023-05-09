<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    protected $fillable=['name','user_id','status','image','image_background','artist_id','slug'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categries_album()
    {
        return $this->categories()->pluck('category_id')->toArray();
    }

    public function musics()
    {
        return $this->hasMany(Music::class)->where('status',1);
    }

    public function scopeSearched($query)
    {
        $search = request()->query('albums');
        if(!$search){
            return $query;
        }else{
            return $query->where('name','LIKE',"%{$search}%");
        }
    }
}
