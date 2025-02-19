<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code', 'customer_id', 'seller_id', 'total_amount', 'sale_date'
    ];

    /**
     * Relación con el cliente.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Relación con el usuario vendedor.
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Relación con los detalles de venta.
     */
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
