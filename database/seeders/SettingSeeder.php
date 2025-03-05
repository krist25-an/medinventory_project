<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Setting::updateOrCreate(
      ['key' => 'notification_time'],
      ['name' => 'Waktu Notifikasi', 'value' => '07:00']
    );

    $template_header = "📢 Informasi Stok Obat 📢\n\n";

    $template_item = "Nama Obat     : {{nama}}\n"
      . "Sisa Stok     : {{stok}} {{satuan}}\n"
      . "Kadaluarsa    : {{expired}}\n"
      . "====================================\n\n";

    $template_footer = "Segera lakukan pengecekan dan pemesanan ulang jika stok menipis. 🚑💊";

    Setting::updateOrCreate(
      ['key' => 'template_header'],
      ['name' => 'Pesan Header', 'value' => $template_header]
    );

    Setting::updateOrCreate(
      ['key' => 'template_item'],
      ['name' => 'Pesan Item', 'value' => $template_item]
    );

    Setting::updateOrCreate(
      ['key' => 'template_footer'],
      ['name' => 'Pesan Footer', 'value' => $template_footer]
    );

    $template_stok_menipis =  "📢 *PERINGATAN STOK OBAT MENIPIS* 📢\n\n"
      . "Nama Obat     : *{{nama}}*\n"
      . "Sisa Stok     : *{{stok}}* {{satuan}}\n"
      . "Batas Minimum : *{{batas_minimum}}* {{satuan}}\n"
      . "Kadaluarsa    : *{{expired}}*\n\n"
      . "⚠️ *Stok obat ini sudah di bawah batas minimum!*\n"
      . "Segera lakukan pemesanan ulang untuk menghindari kehabisan stok. 🚑💊";

    Setting::updateOrCreate(
      ['key' => 'template_low_stock'],
      ['name' => 'Pesan Stok Menipis', 'value' => $template_stok_menipis]
    );
  }
}
