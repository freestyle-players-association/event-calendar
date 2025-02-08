<?php

namespace App\Console\Commands;

use App\Core\UserRole;
use App\Models\User;
use Illuminate\Console\Command;

class RemoveAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove admin priviledges from a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        try {
            $user = User::firstWhere('email', $email);
            if (!$user->isAdmin()) {
                $this->info("'{$email}' is already a user");
                return;
            }
            $user->role = UserRole::USER;
            $user->save();
        } catch (\Exception $e) {
            $this->error('User not found');
            return;
        }

        $this->info("'{$email}' is now a user");
    }
}
