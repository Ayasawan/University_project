<?php

namespace Database\Seeders;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class employeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->delete();

        $employees=[
            [
                'FirstName'=> 'abeer',
                'LastName'=> 'employee_1',
                'Gender'=> 'female',
                'EmployeeWork'=> 'inserting data',
                'user_type' =>'employee',
                'email' =>'abee@r.com',
                'password'=>bcrypt('123123123'),
            ],

            [
                'FirstName'=> 'aya',
                'LastName'=> 'employee_2',
                'Gender'=> 'female',
                'EmployeeWork'=> 'services',
                'user_type' =>'employee',
                'email' =>'aya@google.com',
                'password'=>bcrypt('0932'),

            ]
        ];
        Employee::insert($employees);
    }
}
