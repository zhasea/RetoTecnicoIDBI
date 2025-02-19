<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['sku', 'name', 'unit_price', 'stock'];

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
