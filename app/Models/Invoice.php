<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\InvoiceItem;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    use HasFactory;

    protected $fillable = [
        'client_name', 'client_mobile', 'client_address'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}