<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table= "payments";
    protected $primarykey ="id";
    protected $fillable = [
        'payment_id',
        'receipt_no',
        'product_id',
        'product_name',
        'quantity',
        'amount',
        'currency',
        'user_name',
        'user_email',
        'phone',
        'payment_status',
        'payment_method',
    ];
}
