<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  protected $fillable = [
    'medicine_id',
    'tipe',
    'jumlah',
    'keterangan',
  ];

  public function medicine()
  {
    return $this->belongsTo(Medicine::class);
  }
}
