<?php

namespace Database\Seeders;

use App\Models\Post;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(20)->create([
        //     'password' => '123456789'
        // ]);

        // User::factory()->create([
        //     'name' => 'テスト ユーザー',
        //     'email' => 'test@example.com',
        //     'password' => '123456789',
        //     'location_id' => 21
        // ]);

        //$user = User::factory(20)->create();
        
        Post::factory(10)->create();
    }
}
