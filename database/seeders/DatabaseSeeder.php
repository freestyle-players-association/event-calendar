<?php

namespace Database\Seeders;

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

        User::factory(50)->create();

        Event::factory(20)->create();

        // create "interested" and "attending" relationships
        $events = Event::all();
        $users = User::all();
        foreach ($events as $event) {
            $interested = $users->random(random_int(1, 30));
            $attending = $users->random(random_int(1, 20));
            $event->users()->attach($interested, ['status' => Event::$interested]);
            $event->users()->attach($attending, ['status' => Event::$attending]);
        }
    }
}
