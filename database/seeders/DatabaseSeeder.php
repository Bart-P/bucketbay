<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Grafic;
use App\Models\Order;
use App\Models\OrderObject;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
                         'name'              => 'Bartek',
                         'email'             => 'bar-p@wp.pl',
                         'password'          => bcrypt('asdf'),
                         'email_verified_at' => now(),
                         'remember_token'    => Str::random(10),
                     ]);

        User::create([
                         'name'              => 'Daniel',
                         'email'             => 'da@ni.el',
                         'password'          => bcrypt('asdf'),
                         'email_verified_at' => now(),
                         'remember_token'    => Str::random(10),
                     ]);

        Grafic::factory(10)->create();
        Address::factory(100)->create();

        Product::create([
                            'name'               => 'print',
                            'description'        => '',
                            'image'              => '',
                            'show'               => false,
                            'printable'          => false,
                            'product_list'       => null,
                            'price_in_cent'      => 599,
                            'quantity_available' => 0,
                            'external_id'        => '',
                        ]);

        Product::create([
                            'name'               => 'Ice Bucket mit Halterung',
                            'description'        => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
                            'image'              => 'Ice-Bucket-mit-logo-und-halterung.jpg',
                            'show'               => true,
                            'printable'          => true,
                            'product_list'       => '[3, 4]',
                            'price_in_cent'      => 2599,
                            'quantity_available' => 0,
                            'external_id'        => '',
                        ]);

        Product::create([
                            'name'               => 'Ice Bucket Einzeln',
                            'description'        => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
                            'image'              => 'Ice-Bucket-mit-logo.jpg',
                            'show'               => true,
                            'printable'          => true,
                            'product_list'       => null,
                            'price_in_cent'      => 1599,
                            'quantity_available' => 110,
                            'external_id'        => '',
                        ]);

        Product::create([
                            'name'               => 'Halterung Einzeln',
                            'description'        => 'This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.',
                            'image'              => 'Halterung.jpg',
                            'show'               => true,
                            'printable'          => false,
                            'product_list'       => null,
                            'price_in_cent'      => 1000,
                            'quantity_available' => 128,
                            'external_id'        => '',
                        ]);

        // create orders and add one order object to each order
        Order::factory(20)->create()->each(function ($order) {
            $products = Product::all();
            $productId = $products->pluck('id')->toArray()[rand(0, count($products) - 1)];
            if ($productId === 1) $productId = 2;
            $graficsLength = Grafic::count();
            $graficsArr = [];
            for ($i = 0; $i < rand(1, 2); $i++) {
                $graficsArr[] = rand(1, $graficsLength);
            }

            OrderObject::create([
                                    'order_id'      => $order->id,
                                    'product_id'    => $productId,
                                    'product_price' => Product::find($productId, 'price_in_cent')['price_in_cent'],
                                    'grafics'       => rand(0, 3) ? json_encode($graficsArr) : json_encode([]),
                                    'quantity'      => rand(1, 15),
                                ]);
        });

        OrderObject::factory(30)->create();
    }
}