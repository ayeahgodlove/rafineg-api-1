<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCashTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender' => 'required|string',
            'receiver' => 'required|string',
            'reference' => 'required',
            'description' => 'required',
            'amount' => 'required|numeric',
            'method' => 'required|string',
            'phoneNumber' => 'required|string',
        ];
    }
}