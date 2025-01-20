<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function getToken()
    {
        $token = Cache::get('eskiz_api_token');
        if (! $token) {
            $response = Http::post('notify.eskiz.uz/api/auth/login', [
                'email'    => "qambarovadilshoda867@gmail.com",
                'password' => "NcCq48hJ8LizAwwItmlCmW28VQEwwJ6CDzIN049R",
            ]);
            $token = $response['data']['token'];
            Cache::put('eskiz_api_token', $token, now()->addDays(30));
        }
        return $token;
    }
    public function sendSms(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken(),
        ])->post('notify.eskiz.uz/api/message/sms/send', [
            'mobile_phone' => "User tel raqam",
            'message'      => "Sizining user-ga Sms xabar",
            'from'         => '4546',
        ]);

        return response()->json($response->json());
    }
}
