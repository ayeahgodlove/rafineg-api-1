<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePackageRequest extends FormRequest
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
            "name" => "required|unique:posts|max:255",
            "code" => "string",
            "image" => "string",
            "description" => "required|string",
            "amount" => "float",
            "low_investment_limit" => "required|float",
            "high_investment_limit" => "required|float",
        ];
    }
}
