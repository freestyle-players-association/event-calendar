<?php

namespace App\Console\Commands;

use App\Core\Enum\UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;

class AdminConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:admin-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        while (true) {
            $task = select(
                'What do you want to do?',
                [
                    'add' => 'Make a user an admin',
                    'remove' => 'Remove admin role from a user',
                    'list' => 'List all admins',
                    'exit' => 'Exit'
                ]
            );

            switch ($task) {
                case 'add':
                    $this->addAdmin();
                    break;
                case 'remove':
                    $this->removeAdmin();
                    break;
                case 'list':
                    $admins = User::where('role', UserRole::ADMIN)->get();
                    if (count($admins) === 0) {
                        $this->info('No admins found');
                        break;
                    }
                    $this->info('Admins:');
                    $this->table(['ID', 'Name', 'Email'], $admins->map(fn(User $user) => [$user->id, $user->name, $user->email]));
                    break;
                case 'exit':
                    exit(0);
            }
        }
    }

    private function removeAdmin(): void
    {
        $users = User::where('role', UserRole::ADMIN)->get();
        if (count($users) === 0) {
            $this->info('No admins found');
            return;
        }
        $userId = select(
            label: 'Select the user to remove the admin role',
            options: $users->pluck('name', 'id')->all()
        );

        $user = $users->firstWhere('id', $userId);

        try {
            $email = $user->email;
            if (!$user->isAdmin()) {
                $this->info("'{$email}' is not an admin");
                return;
            }
            $user->role = UserRole::USER;
            $user->save();
        } catch (\Exception) {
            $this->error("'{$email}' not found");
            return;
        }

        $this->info("'{$email}' is no longer an admin");
    }

    private function addAdmin(): void
    {
        $id = search(
            label: 'Search for the user by email',
            options: fn(string $value) => strlen($value) > 0
                ? User::whereLike('name', "%{$value}%")->pluck('name', 'id')->all()
                : []
        );

        if (!$id) {
            $this->error('User not found');
            return;
        }

        $user = User::find($id);

        if (!$user) {
            return;
        }

        try {
            $email = $user->email;
            if ($user->isAdmin()) {
                $this->info("'{$email}' is already an admin");
                return;
            }
            $user->role = UserRole::ADMIN;
            $user->save();
        } catch (\Exception) {
            $this->error("'{$email}' not found");
            return;
        }

        $this->info("'{$email}' is now an admin");
    }
}
