<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\User;

class UpdateVerifyCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-verify-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update verification codes for all users every minute';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                $user->update([
                    'verification_code' => rand(10000, 99999),
                ]);
            }
        });

        $this->info('Verification codes have been successfully updated for all users.');

        return 0;
    }
}
