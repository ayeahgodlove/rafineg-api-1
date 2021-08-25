<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CashboxResource extends JsonResource
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
            "balance" => $this->balance,
            "user" => new UserResource($this->casbox_user()),
            "lastTransaction" => new TransactionResource(
                $this->casbox_user()
                    ->transactions()
                    ->first()
            )
        ];
    }

    public function casbox_user()
    {
        return User::find($this->user);
    }
}