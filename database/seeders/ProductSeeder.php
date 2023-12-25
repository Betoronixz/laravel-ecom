<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('products')->insert([
                'name' => $faker->name,
                'price' => $faker->randomDigit,
                'description' => $faker->paragraph,
                'category' => $faker->name,
                'gallery' => $faker->imageUrl($width = 200, $height = 200)
            ]);
        }
    }
}
