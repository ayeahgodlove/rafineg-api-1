<?php

namespace App\Http\Resources;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            "balance" => $this->balance,
            "user" => new UserResource(User::find($this->user_id)),
            "lastTransaction" => new TransactionResource(Transaction::find($this->transaction_id))
        ];
    }
}
