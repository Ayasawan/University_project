<?php

namespace Database\Seeders;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        $admins=[
            [
                'name'=> 'abeer',
                'user_type' =>'admin',
                'email' =>'abee@r.com',
                'password'=>bcrypt('123123123'),
            ],
            [
                'name'=> 'shaza',
                'user_type' =>'admin',

                'email' =>'shaz@a.com',
                'password'=>bcrypt('123123123'),
            ],
            [
                'name'=> 'aya',
                'user_type' =>'admin',
                'email' =>'aya@google.com',
                'password'=>bcrypt('0932'),

            ]
        ];
        Admin::insert($admins);
    }
}
