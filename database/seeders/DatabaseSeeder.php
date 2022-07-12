<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Grafic;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory(4)->create();
        Grafic::factory(15)->create();
        Address::factory(50)->create();

        Item::create([
            'name' => 'Ice Bucket mit Logo und Halterung',
            'description' => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
            'image' => 'Ice-Bucket-mit-logo-und-halterung.jpg',
            'external_id' => ''
        ]);

        Item::create([
            'name' => 'Ice Bucket mit Logo',
            'description' => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
            'image' => 'Ice-Bucket-mit-logo.jpg',
            'external_id' => ''
        ]);

        Item::create([
            'name' => 'Ice Bucket',
            'description' => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
            'image' => 'Ice-Bucket.jpg',
            'external_id' => ''
        ]);

        Item::create([
            'name' => 'Halterung',
            'description' => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
            'image' => 'Halterung.jpg',
            'external_id' => ''
        ]);
    }
}
