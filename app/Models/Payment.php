<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'payment_date',
        'voucher_image', // Del cliente
        'internal_voucher', // De la empresa
        'internal_voucher_uploaded_by',
        'internal_voucher_uploaded_at',
        'status'
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'internal_voucher_uploaded_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Obtener el usuario que subió el comprobante interno
     */
    public function internalVoucherUploader()
    {
        return $this->belongsTo(User::class, 'internal_voucher_uploaded_by');
    }
}
