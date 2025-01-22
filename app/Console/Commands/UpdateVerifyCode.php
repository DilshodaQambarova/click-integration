<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateVerifyCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-verify-codes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update verify codes for all users every minute';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::query()->update([
            'verification_code' => rand(10000, 99999)
        ]);

        $this->info('All user verify codes have been updated.');
        return 1;
    }
}
