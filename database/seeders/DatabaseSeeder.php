<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Grafic;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

        User::create(['name'              => 'Bartek',
                      'email'             => 'bar-p@wp.pl',
                      'password'          => bcrypt('asdf'),
                      'email_verified_at' => now(),
                      'remember_token'    => Str::random(10),]);

        User::create(['name'              => 'Daniel',
                      'email'             => 'da@ni.el',
                      'password'          => bcrypt('asdf'),
                      'email_verified_at' => now(),
                      'remember_token'    => Str::random(10),]);

        Grafic::factory(10)->create();
        Address::factory(100)->create();

        Product::create(['name'               => 'print',
                         'description'        => '',
                         'image'              => '',
                         'show'               => false,
                         'printable'          => false,
                         'product_list'       => null,
                         'price_in_cent'      => 599,
                         'quantity_available' => 0,
                         'external_id'        => '']);

        Product::create(['name'               => 'Ice Bucket mit Halterung',
                         'description'        => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
                         'image'              => 'Ice-Bucket-mit-logo-und-halterung.jpg',
                         'show'               => true,
                         'printable'          => true,
                         'product_list'       => '[2, 3]',
                         'price_in_cent'      => 2599,
                         'quantity_available' => 150,
                         'external_id'        => '']);

        Product::create(['name'               => 'Ice Bucket Einzeln',
                         'description'        => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
                         'image'              => 'Ice-Bucket-mit-logo.jpg',
                         'show'               => true,
                         'printable'          => true,
                         'product_list'       => null,
                         'price_in_cent'      => 1599,
                         'quantity_available' => 150,
                         'external_id'        => '']);

        Product::create(['name'               => 'Halterung Einzeln',
                         'description'        => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
                         'image'              => 'Halterung.jpg',
                         'show'               => true,
                         'printable'          => false,
                         'product_list'       => null,
                         'price_in_cent'      => 1000,
                         'quantity_available' => 150,
                         'external_id'        => '']);
    }
}