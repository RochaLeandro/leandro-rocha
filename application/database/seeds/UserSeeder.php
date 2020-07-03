<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 500)->create()->each(function ($user) {
            $user->accesses()->createMany(
                factory(App\Models\UserAccess::class, rand(8, 15))->make()->toArray()
            );
        });
    }
}
