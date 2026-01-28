<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Content\Models\Content;
use Modules\Interaction\Models\Comment;
use Modules\User\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Setup Roles
        $roles = [
            'super-admin',
            'admin',
            'user',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // 2. Create Super Admin User
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('super-admin');
        $admin->markEmailAsVerified();

        // 3. Seed Content and Comments using correct factory chaining
        // This creates 5 Content records, associates them with the $admin user (assuming Content belongsTo User),
        // and ensures each of those 5 Content records has 5 associated Comment records.
        Content::factory()
            ->count(5)
            ->for($admin) // Establishes the User-to-Content relationship (e.g., sets user_id)
            ->has(Comment::factory()->count(5)->for($admin)) // Establishes the Content-to-Comment relationship
            ->create();

        // Optional: Create a few general 'user' entries for testing other roles/users
        User::newFactory()->count(10)->create()->each(function ($user) {
            $user->assignRole('user');
            $user->markEmailAsVerified();
        });
    }
}
