<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch($this->method())
        {
            case "POST":
                $rules = [
                    "email" => "required|email|unique:users,email",
                    "fullname" => "required|string",
                    "password" => "required|min:8"
                ];

                break;
            case "PUT":
                $userId = $this->user ? $this->user : auth()->id();
                $rules =[
                    "email" => "email|unique:users,email,".$userId, 
                    "fullname" => "string",
                    "password" => "min:8"
                ];

                break;
        }


        // check is current user admin 
        if ($this->user()->is_admin) {
            $rules['is_admin'] = ["integer"];
        }

        return $rules;
    }
}
