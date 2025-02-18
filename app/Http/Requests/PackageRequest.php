<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
            "name" => "string|required",
            "code" => "string|required|unique:packages,code",
            "image" => "string",
            "description" => "string|required",
            "fee" => "numeric|required",
            "low_investment_limit" => "numeric|required",
            "high_investment_limit" => "numeric",
        ];
    }
}