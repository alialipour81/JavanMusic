<?php

namespace App\Http\Requests\Dashboard\Album;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestAlbum extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>['required','unique:albums,name'],
            'artist_id'=>['required','integer'],
            'categories'=>['required'],
            'image'=>['required','image','mimes:png,jpeg,jpg','max:2000'],
            'image_background'=>['required','image','mimes:png,jpeg,jpg','max:3000'],
        ];
    }
}
