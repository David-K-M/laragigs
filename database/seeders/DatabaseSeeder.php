<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(5)->create();
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com'
        ]);
        
        Listing::Factory(6)->create([
            'user_id' => $user->id
        ]); 
        /*
        Listing::create([
            'title' => 'Laravel Senior Developer',
            'tags' => 'laravel, javascript',
            'company' => 'Acme Corp',
            'location' => 'Lusaka',
            'email' => 'test@email.com',
            'website' => 'https://www.acme.com',
            'description' => 'This is the description of a senior laravel developer',
        ]); 

        Listing::create([
            'title' => 'Full stack Developer',
            'tags' => 'laravel, backend, api',
            'company' => 'Stark Industries',
            'location' => 'Ndola',
            'email' => 'stark@email.com',
            'website' => 'https://www.stark.com',
            'description' => 'This is the description of a full stack developer',
        ]); */
    }
}
