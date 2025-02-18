<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "firstName" => $this->firstname,
            "lastName" => $this->lastname,
            "email" => $this->email,
            "phoneNumber" => $this->phone_number,
            "isRegistered" => $this->is_registered,
            "isVerified" => $this->isVerified
        ];
    }
}
