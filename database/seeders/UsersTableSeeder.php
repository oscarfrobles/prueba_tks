<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                'name' => 'admin',
                'email' => 'admin@fake.com',
                'password' => Hash::make('12345678'),
                'timezone' => 'UTC'
        ]);
        
        User::create([
                'name' => 'Óscar',
                'email' => 'oskijob@fake.es',
                'password' => Hash::make('12345678'),
                'timezone' => 'Europe/Spain',
        ]);
        User::create([
                'name' => 'John Smith',
                'email' => 'john.smith@fake.gb',
                'password' => Hash::make('12345678'),
                'timezone' => 'Europe/London'
        ]);
        User::create([
                'name' => 'Vinicio del Pozo',
                'email' => 'vinicio.pozo@fake.com.mx',
                'password' => Hash::make('12345678'),
                'timezone' => 'America/Mexico_City'
        ]);
    }
}
