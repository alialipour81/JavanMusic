<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protection extends Model
{
    use HasFactory;
    protected $fillable=['user_id','image','title','link','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
