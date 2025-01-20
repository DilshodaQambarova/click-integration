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
            'Authorization' => 'Bearer ' . $this->getToken2(),
        ])->post('notify.eskiz.uz/api/message/sms/send', [
            'mobile_phone' => "998770692029",
            'message'      => "Afisha Market MCHJ Tasdiqlovchi kodni kiriting:12345",
            'from'         => '4546',
        ]);

        return response()->json($response->json());
    }
    public function getToken2(){
        return 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3Mzk5NjM1MTksImlhdCI6MTczNzM3MTUxOSwicm9sZSI6InVzZXIiLCJzaWduIjoiNDA4Yzg5YWNhODhhMDZkODJhZDEwMDZkNjUzMzMzYmM1YjIzNzI2MzU2ZTEzZmE0NGJkMjE1YWViZTNiNGQwOCIsInN1YiI6IjM2MTYifQ.5fDNRTc6DKd4DfMg7-Z7JJOEmqTsdbFupzydidcmGAk';
    }
}
