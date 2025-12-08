<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'description',
        'code',
        'rate_euro',
        'date_paid',
    ];
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
