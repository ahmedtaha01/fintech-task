<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_account_name',
        'bank_account_number',
        'bank_iban_number',
        'balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
