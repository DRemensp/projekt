<?php

namespace Database\Seeders;

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
        $this->call([RoleSeeder::class]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@localhost'],
            [
                'name' => 'Admin',
                'password' => 'admin123'
            ]
        );
        $admin->assignRole('admin');

        $teacher = User::firstOrCreate(['email' => 'teacher@localhost'], [
            'name' => 'Teacher',
            'password' => 'teacher123'
        ]);
        $teacher->assignRole('teacher');
    }
}
