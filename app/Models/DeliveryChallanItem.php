<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryChallanItem extends Model
{
    protected $fillable = ['delivery_challan_id', 'invoice_item_id', 'product_name', 'variation', 'quantity'];
    public function deliveryChallan()
    {
        return $this->belongsTo(DeliveryChallan::class);
    }

    public function invoiceItem()
    {
        return $this->belongsTo(InvoiceItem::class);
    }
}
