<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');
        return [
            'name' => [
                'required',
                'alpha',
                'max:255',
                'min:3',
                //"unique:categories,name,$id",
                //(new Unique('categories', 'name'))->ignore($id),
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'description' => [
                'nullable',
                'min:5',
                /* function($attribut, $value, $fail){
                     if(stripos($value, 'laravl') !== false){
                         $fail('You an not use the word "laravl"!');
                     }
                }*/
                // new WordsFillter(['php', 'laravel']),
                'filter:laravel,php'
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id'
            ],
            'image' => [
                'nullable',
                'image',
                'max:1048576',
                'dimentions:min_width=200,min_height=200'
            ],
            'status' => 'required|in:active,inactive'
        ];
    }
}
