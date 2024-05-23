<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();



        User::factory()->create([
            'name' => 'Amministratore',
            'email' => 'asdf@asdf.asdf',
            'role' => 'Amministatore',
            'phone'=> '46387402804',
        ]);

        User::factory()->create([
            'name' => 'cliente',
            'email' => 'cliente@asd.asd',
            'role' => 'cliente',
            'phone'=> '264294232342',
        ]);
    }
}
