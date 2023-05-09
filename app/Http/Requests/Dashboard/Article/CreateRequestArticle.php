<?php

namespace App\Http\Requests\Dashboard\Article;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestArticle extends FormRequest
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
            'title'=>['required','unique:articles,title'],
            'category_id'=>['required','integer'],
            'image'=>['required','image','mimes:png,jpeg,jpg','max:2000'],
            'description'=>['required']
        ];
    }
}
