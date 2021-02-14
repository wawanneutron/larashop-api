<?php

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];

        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) {
            $avatar_path = 'public/images/users';
            $avatar_fullpath = $faker->image($avatar_path, 640, 480, 'cats', true, true, 'Faker');
            $avatar = str_replace($avatar_path . '/', '', $avatar_fullpath);
            $users[$i] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('123456'),
                'roles' => json_encode(['CUSTOMER']),
                'avatar' => $avatar,
                'created_at' => Carbon::now(),
            ];
        }
        DB::table('users')->insert($users);
    }
}
