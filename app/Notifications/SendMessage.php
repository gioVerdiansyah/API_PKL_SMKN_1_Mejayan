<?php
namespace App\Notifications;

use Illuminate\Support\Facades\Http;

class SendMessage{
    static function send(string $no_hp, string $text){
        Http::withHeaders([
            'x-api-key' => config('app.api_key_bot_wa')
        ])->post(config('app.app_url_bot_wa') . '/send-message', [
                    'session' => 'PKL_SMKN1Mejayan',
                    'to' => (substr($no_hp, 0, 1) === '0') ? '62' . substr($no_hp, 1) : $no_hp,
                    'text' => $text
                ]);
    }
}
