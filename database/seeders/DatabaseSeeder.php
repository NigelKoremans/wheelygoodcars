<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
            User::factory(150)->create();
            Tag::factory(20)->create();
        $carCount = Car::count();
        $users = User::all();
        $tags = Tag::all();

        for ($i = $carCount; $i < 250; $i++) {
            $car = Car::factory()->create([
                'user_id' => $users->random()->id,
            ]);

            $car->tags()->attach(
                $tags->random(rand(1, 5))->pluck('id')->toArray()
            );
        }
    }
}
