<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Créer 5 posts avec des données aléatoires
        for ($i = 0; $i < 5; $i++) {
            $user = User::inRandomOrder()->first();

            Post::create([
                'user_id' => $user->id,
                'photo_video' => $faker->imageUrl(),
                'type' => $faker->randomElement([0, 1]),
                'title' => $faker->sentence(),
            ]);
        }
    }
}
