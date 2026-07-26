<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class BackfillUserType extends Command
{
    protected $signature = 'users:backfill-user-type';
    protected $description = 'Set user_type_id for any users where it is null (defaults to learner)';

    public function handle()
    {
        $count = User::whereNull('user_type_id')->count();

        if ($count === 0) {
            $this->info('All users already have a user_type_id.');
            return 0;
        }

        User::whereNull('user_type_id')->update(['user_type_id' => 2]);

        $this->info("Updated {$count} user(s) with null user_type_id to learner (type 2).");
        return 0;
    }
}
