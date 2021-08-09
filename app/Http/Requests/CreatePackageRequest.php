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
        return Auth()->id() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string",
            "code" => "required|string",
            "description" => "required|string",
            "amount" => "decimal|string",
            "low_investment_limit" => "number|string",
            "high_investment_limit" => "number|string",
        ];
    }
}