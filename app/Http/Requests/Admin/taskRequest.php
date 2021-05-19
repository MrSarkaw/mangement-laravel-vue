<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class taskRequest extends FormRequest
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
        return [
            "title"=>"required|max:70",
            "description"=>"required|max:500",
            "start_date"=>"required|date",
            "end_date"=>"required|date|after:start_date",
        ];
    }

    public function messages()
    {
        return [
            "title.required"=>"please fill title",
            "description.required"=>"please fill description",
            "start_date"=>"please select start date",
            "end_date"=>"please select end date",
        ];
    }
}
