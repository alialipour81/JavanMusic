<?php

namespace App\Http\Requests\Dashboard\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestArticle extends FormRequest
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
            'category_id'=>['required','integer'],
            'user_id'=>['required','integer'],
            'status'=>['required','integer'],
            'description'=>['required'],
        ];
    }
}
