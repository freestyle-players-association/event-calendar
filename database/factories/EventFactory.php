<?php

namespace Database\Factories;

use App\Core\Service\LoremPicsumService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     * @throws \DateMalformedStringException
     */
    public function definition(): array
    {
        $startDate = \DateTimeImmutable::createFromMutable(fake()->dateTimeBetween('now', '+8 month'));
        $days = fake()->numberBetween(1, 4);
        $endDate = $startDate->modify("+{$days} day");

        $name = fake()->words(fake()->numberBetween(1, 3), true);
        $slug = \Illuminate\Support\Str::slug($name);

        $users = \App\Models\User::all();

        return [
            'name' => $name,
            'user_id' => $users->random()->id,
            'slug' => $slug,
            'description' => fake()->sentence(),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'location' => fake()->city(),
            'banner' => app(LoremPicsumService::class)->getBanner(),
            'icon' => app(LoremPicsumService::class)->getIcon(),
        ];
    }
}
