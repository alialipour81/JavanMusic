<?php

namespace App\Http\Requests\Dashboard\Music;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestMusic extends FormRequest
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
            'name'=>['required'],
            'album_id'=>['required','numeric'],
            'artist_id'=>['required','integer'],
            'user_id'=>['required','integer'],
            'text'=>['required'],
            'status'=>['required','numeric']
        ];
    }
}
