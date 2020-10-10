<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendaProd extends Model
{
    //
    protected $table = 'product_sale';
    public $timestamps = false;
    protected $fillable = [
        'id_sale','id_product',
    ];
}
