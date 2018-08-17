<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->name = env('ADMIN_NAME');
        $user->email = env('ADMIN_EMAIL');
        $user->password = bcrypt(env('ADMIN_PASSWORD'));
        if($user->save()){
            echo "Admin User Created\n";
        }
    }
}
