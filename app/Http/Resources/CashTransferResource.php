<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CashTransferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sender' => new UserResource(User::find($this->sender)),
            'receiver' => new UserResource(User::find($this->sender)),
            'reference' => $this->reference,
            'description' => $this->description,
            'amount' => $this->amount,
            'method' => $this->method,
            'phoneNumber' => $this->phoneNumber
        ];
    }
}