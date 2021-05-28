<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class userRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $id=$request->user;

        if(in_array($this->method(),["PATCH","PUT"])){
            return [
                "name"=>"required|max:50",
                "email"=>"required|max:100|email|unique:users,email,".$id,
                "password"=>"nullable|min:6|confirmed",
                "user_id"=>"numeric",
                "isAdmin"=>"required|numeric"
            ];
        }else{
            return [
                "name"=>"required|max:50",
                "email"=>"required|unique:users,email|max:100|email",
                "password"=>"required|min:6|confirmed",
                "user_id"=>"numeric",
                "isAdmin"=>"required|numeric"
            ];
        }
       
    }

    public function messages()
    {
        return [
            "name.required"=>"please fill name",
            "email.required"=>"please fill email address",
            "password.required"=>"please fill password",
            "password.min"=>"password must be graterthan 6 charcter",
            "isAdmin.required"=>"please choose level of admin",
        ];
    }
}
