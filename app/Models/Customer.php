<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    use HasFactory;

    protected $fillable = ['name', 'email', 'id_number', 'document_type_id'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
