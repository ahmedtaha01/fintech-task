<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
    }
}
