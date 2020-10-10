<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Vendas extends Model
{
    //
    protected $table = 'sale';

    protected $fillable = [
        'total','date', 'address',
    ];

    public $timestamps = false;
}
