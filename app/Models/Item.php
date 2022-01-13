<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price_supplier', 'price_member', 'qty', 'supplier_id'];
    public function supplier ()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id'); 
    }
}
