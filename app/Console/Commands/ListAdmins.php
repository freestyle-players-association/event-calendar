<?php

namespace App\Console\Commands;

use App\Core\UserRole;
use App\Models\User;
use Illuminate\Console\Command;

class ListAdmins extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:list-admins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Echo a list of admins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $admins = User::where('role', UserRole::ADMIN)->get();
        $this->info('Admins:');
        foreach ($admins as $admin) {
            $this->line($admin->email);
        }
    }
}
