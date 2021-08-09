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
            "name" => "required|string",
            "code" => "required|string",
            "description" => "required|string",
            "amount" => "required|number|min:0",
            "lowInvestmentLimit" => "required|number|min:0",
            "highInvestmentLimit" => "required|number|min:0",
        ];
    }
}