<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gunung extends Model
{
    protected $fillable = ['nama_gunung', 'ketinggian', 'lokasi'];
}
