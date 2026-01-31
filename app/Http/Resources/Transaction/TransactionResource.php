<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'user_id' => $this->user_id,
            'account_sender_id' => $this->account_sender_id,
            'account_receiver_id' => $this->account_receiver_id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'payload' => $this->payload,
            'created_at' => $this->created_at_formatted,
        ];
    }
}

