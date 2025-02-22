<?php

namespace Database\Seeders;

use App\Core\Enum\EventUserStatus;
use App\Models\Event;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $userCount = 80;
        User::factory($userCount)->create();

        Event::factory(40)->create();

        // create "interested" and "attending" relationships
        $users = User::all();
        foreach (Event::all() as $event) {
            $event->users()->attach(
                $users->random(random_int(1, $userCount)),
                ['status' => EventUserStatus::INTERESTED]
            );
            $event->users()->attach(
                $users->random(random_int(1, $userCount)),
                ['status' => EventUserStatus::ATTENDING]
            );
        }
    }
}
