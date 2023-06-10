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
                'name'=> 'employee_1',
                'user_type' =>'employee',
                'email' =>'abee@r.com',
                'password'=>bcrypt('123123123'),
            ],

            [
                'name'=> 'employee_2',
                'user_type' =>'employee',
                'email' =>'aya@google.com',
                'password'=>bcrypt('0932'),

            ]
        ];
        Admin::insert($admins);
    }
}
