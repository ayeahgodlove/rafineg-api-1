<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            "user" => new UserResource(User::find($this->user_id)),
            "bio" => $this->bio,
            "address" => $this->address,
            "gender" => $this->gender,
            "dateOfBirth" => $this->date_of_birth,
            "imageUrl" => $this->image,
            "createdOn" => $this->created_at,
            "updatedOn" => $this->updated_at,
        ];
    }
}