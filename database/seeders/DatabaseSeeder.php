<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Interview Admin',
            'email' => 'admin@example.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
        ]);

        $vendor = User::factory()->create([
            'name' => 'Interview Vendor',
            'email' => 'vendor@example.test',
            'password' => Hash::make('password'),
            'role' => UserRole::Vendor,
        ]);

        $vendors = User::factory()
            ->count(8)
            ->create(['role' => UserRole::Vendor]);

        User::factory()
            ->count(12)
            ->create(['role' => UserRole::Customer]);

        $owners = $vendors->push($vendor);

        Product::factory()
            ->count(500)
            ->recycle($owners)
            ->create();

        Product::factory()
            ->count(8)
            ->for($admin)
            ->create();
    }
}
