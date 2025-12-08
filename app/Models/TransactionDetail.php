<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_details';
    protected $fillable = [
        'transaction_id',
        'transaction_category_id',
        'name',
        'value_idr',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function category()
    {
        return $this->belongsTo(MsCategory::class, 'transaction_category_id');
    }
}
