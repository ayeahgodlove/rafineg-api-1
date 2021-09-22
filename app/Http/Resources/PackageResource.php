<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            "name" => $this->name,
            "code" => $this->code,
            "description" => $this->description,
            "image" => asset($this->image),
            "amount" => $this->amount,
            "lowInvestmentLimit" => $this->low_investment_limit,
            "highInvestmentLimit" => $this->high_investment_limit,
            "createdOn" => $this->created_on,
            "updatedOn" => $this->updated_on,
        ];
    }
}