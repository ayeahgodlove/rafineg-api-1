<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationFeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "phoneNumber" => $this->phone_number,
            "amount" => $this->amount,
            "transactionMethod" => $this->transaction_method,
            "createdOn" => $this->created_on,
            "updatedOn" => $this->updated_on,
        ];
    }
}