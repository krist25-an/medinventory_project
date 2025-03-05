<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
  protected $fillable = [
    'nama',
    'deskripsi',
    'stok',
    'stok_min',
    'harga',
    'satuan',
    'expired',
  ];

  protected  $casts = [
    'expired' => 'date'
  ];


  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }
}
