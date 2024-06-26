<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "Anrif",
            'email' => "anrifidine.mahamoud@gmail.com",
            'password' => Hash::make('qwertyui'),
            'is_admin' => 1,
            'status' => 1

        ]);
        User::create([
            'name' => "Anrif2",
            'email' => "anrifidine.mahamoud2@gmail.com",
            'password' => Hash::make('qwertyui'),
            'is_admin' => 0,
            'status' => 1

        ]);
    }
}
