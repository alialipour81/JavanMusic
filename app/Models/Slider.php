<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable=[
      'title','sub_title','image','image_background','description','title_button_black','link_button_black','title_button_green','link_button_green','status'
    ];
}
