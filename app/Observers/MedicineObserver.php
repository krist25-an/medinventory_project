<?php

namespace App\Observers;

use App\Models\Medicine;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class MedicineObserver
{

  protected function sendTelegramNotification($message)
  {
    $telegramBotToken = env('TELEGRAM_BOT_TOKEN');
    $chatId = env('TELEGRAM_CHAT_ID');

    Http::post("https://api.telegram.org/bot{$telegramBotToken}/sendMessage", [
      'chat_id' => $chatId,
      'text' => $message,
      'parse_mode' => 'Markdown'
    ]);
  }
  /**
   * Handle the Medicine "created" event.
   */
  public function created(Medicine $medicine): void
  {
    //
  }

  /**
   * Handle the Medicine "updated" event.
   */

  protected function parseTemplate($template, $variables = [])
  {
    foreach ($variables as $key => $value) {;
      $template = str_replace("{{{$key}}}", $value, $template);
    }
    return $template;
  }

  public function updated(Medicine $medicine): void
  {
    if ($medicine->stok < $medicine->stok_min) {
      $template = Setting::where('key', 'template_low_stock')->first()?->value;
      $data = [
        "nama" => $medicine->nama,
        "deskripsi" => $medicine->stok,
        "stok" => $medicine->stok,
        "stok_min" => $medicine->stok_min,
        "harga" => $medicine->harga,
        "satuan" => $medicine->satuan,
        "expired" => $medicine->expired->format('d F Y'),
      ];
      $message = $this->parseTemplate($template, $data);
      $this->sendTelegramNotification($message);
    }
  }

  /**
   * Handle the Medicine "deleted" event.
   */
  public function deleted(Medicine $medicine): void
  {
    //
  }

  /**
   * Handle the Medicine "restored" event.
   */
  public function restored(Medicine $medicine): void
  {
    //
  }

  /**
   * Handle the Medicine "force deleted" event.
   */
  public function forceDeleted(Medicine $medicine): void
  {
    //
  }
}
