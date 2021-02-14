<?php

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $name = $faker->unique()->word();
            $name = str_replace('.', '', $name);
            $slug = str_replace('', '-', strtolower($name));

            $categories[$i] = [
                'name' => $name,
                'slug' => $slug,
                'created_at' => Carbon::now()
            ];
        }
        DB::table('categories')->insert($categories);
    }
}
