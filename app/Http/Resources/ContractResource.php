<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            "startDate" => $this->start_date,
            "endDate" => $this->endDate,
            "createdOn" => $this->created_at,
            "updatedOn" => $this->updated_at
        ];
    }
}