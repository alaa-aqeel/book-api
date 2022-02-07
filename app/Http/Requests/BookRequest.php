<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()){
            case 'POST':
                return [
                    "name" => "required|string|unique:books,name",
                    "link" => "required|url",
                    "image" => "required|image",
                    "description" => "nullable",
                    "language" => "required|string",
                    "author" => "required|string",
                    "pages" => "required|integer",
                    "section" => "required|exists:sections,id",
                ];
            case "PUT":
                return [
                    "name" => "string|unique:books,name,".$this->book,
                    "link" => "url",
                    "image" => "image",
                    "description" => "nullable",
                    "language" => "string",
                    "author" => "string",
                    "pages" => "integer",
                    "section" => "exists:sections,id",
                ];
        }
    }
}
