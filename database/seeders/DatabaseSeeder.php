<?php

namespace Database\Seeders;

use App\Core\Enum\AssetType;
use App\Core\Enum\EventUserStatus;
use App\Core\Service\AssetManagerService;
use App\Models\Event;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct(private AssetManagerService $assetManagerService) {}

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->assetManagerService->deleteAll(AssetType::BANNER);
        $this->assetManagerService->deleteAll(AssetType::ICON);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $userCount = 40;
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
