<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->getToken2(),
        ])->post('https://notify.eskiz.uz/api/message/sms/send', [
            'mobile_phone' => $this->user->phoneNumber,
            'message'      => "Afisha Market MCHJ Tasdiqlovchi kodni kiriting:",,
            'from'         => '4546',
        ]);
    }

    public function getToken2(){
        return 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3Mzk5NjM1MTksImlhdCI6MTczNzM3MTUxOSwicm9sZSI6InVzZXIiLCJzaWduIjoiNDA4Yzg5YWNhODhhMDZkODJhZDEwMDZkNjUzMzMzYmM1YjIzNzI2MzU2ZTEzZmE0NGJkMjE1YWViZTNiNGQwOCIsInN1YiI6IjM2MTYifQ.5fDNRTc6DKd4DfMg7-Z7JJOEmqTsdbFupzydidcmGAk';
    }

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
}
