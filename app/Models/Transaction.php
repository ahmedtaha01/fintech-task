<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'account_sender_id',
        'account_receiver_id',
        'amount',
        'currency',
        'payload',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payload' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function senderAccount()
    {
        return $this->belongsTo(Account::class, 'account_sender_id');
    }

    public function receiverAccount()
    {
        return $this->belongsTo(Account::class, 'account_receiver_id');
    }
}
