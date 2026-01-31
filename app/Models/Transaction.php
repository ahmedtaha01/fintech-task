<?php

namespace App\Models;

use Carbon\Carbon;
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
        'sender_account_id' => 'integer',
        'receiver_account_id' => 'integer',
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

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
    }
}
