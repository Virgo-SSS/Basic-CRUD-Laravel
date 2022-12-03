<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'isPaid',
        'payment_receipt',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function transcation()
    {
        return $this->hasMany(Transcation::class, 'order_id');
    }
}
