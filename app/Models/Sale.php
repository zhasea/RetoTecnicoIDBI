<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    use HasFactory;
    
    protected $fillable = [
        'code', 'document_type_id', 'seller_id', 'total_amount', 'sale_date'
    ];

    public function documentType()
    {
        return $this -> belongsTo(DocumentType::class);
    }

     public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
