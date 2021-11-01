<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SavingResource extends JsonResource
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
            "user" => $this->user,
            "package" => $this->package,
            "telephone" => $this->telephone,
            "amount" => $this->amount,
            "createdOn" => $this->created_on,
            "updatedOn" => $this->updated_on,
        ];
    }
}