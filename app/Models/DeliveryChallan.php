<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryChallan extends Model
{
    protected $fillable = ['po_number,invoice_id'];
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function items()
    {
        return $this->hasMany(DeliveryChallanItem::class);
    }
}
