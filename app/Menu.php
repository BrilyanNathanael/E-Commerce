<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nama_dapur', 'nama_menu', 'deskripsi_menu', 'harga_menu',
    ];
}
