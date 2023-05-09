<?php

namespace App\Http\Requests\Dashboard\Music;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestMusic extends FormRequest
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
            'name'=>['required','unique:music,name'],
            'album_id'=>['required','numeric'],
            'artist_id'=>['required','integer'],
            'image'=>['required','image','mimes:png,jpeg,jpg','max:2000'],
            'text'=>['required']
        ];
    }
}
