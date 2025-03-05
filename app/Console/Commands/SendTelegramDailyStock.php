<?php

namespace App\Console\Commands;

use App\Models\Medicine;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendTelegramDailyStock extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:send-telegram-daily-stock';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Mengirim notifikasi stok obat ke telegram';

  protected function parseTemplate($template, $variables = [])
  {
    foreach ($variables as $key => $value) {;
      $template = str_replace("{{{$key}}}", $value, $template);
    }
    $this->info($template);
    return $template;
  }

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $botToken = env('TELEGRAM_BOT_TOKEN');
    $chatId = env('TELEGRAM_CHAT_ID');

    // Ambil daftar obat dari database
    $medicines = Medicine::all();
    $template_header = Setting::where('key', 'template_header')->first()?->value;
    $template_item = Setting::where('key', 'template_item')->first()?->value;
    $template_footer = Setting::where('key', 'template_footer')->first()?->value;

    if ($medicines->isEmpty()) {
      $message = "Tidak ada obat yang terdaftar hari ini.";
    } else {
      $message = $template_header . "\n";
      foreach ($medicines as $medicine) {
        $data = [
          "nama" => $medicine->nama,
          "deskripsi" => $medicine->stok,
          "stok" => $medicine->stok,
          "stok_min" => $medicine->stok_min,
          "harga" => $medicine->harga,
          "satuan" => $medicine->satuan,
          "expired" => $medicine->expired->format('d F Y'),
        ];
        $message .= $this->parseTemplate($template_item, $data) . "\n\n";
      }
      $message .= "\n" . $template_footer;
    }

    // Kirim pesan ke Telegram
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

    Http::post($url, [
      'chat_id' => $chatId,
      'text' => $message,
      'parse_mode' => 'Markdown'
    ]);

    $this->info('Notifikasi Telegram berhasil dikirim!');
  }
}