<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'email', 'phone_number'];

    public function Items ()
    {
        return $this->hasMany('App\Models\Item', 'supplier_id'); 
    }
}
