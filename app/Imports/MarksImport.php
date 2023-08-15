<?php

namespace App\Imports;

use App\Models\MyMarks;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class MarksImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new MyMarks([
    //         'nameMark' => $row[0],
    //         'markNum' => $row[1],
    //         'year' => $row[2],
    //         'semester' => $row[3],
    //         'user_id' => $row[4], // User ID from the CSV file
    //     ]);
    // }
   
   
        public function model(array $row)
        {
            // Extract data from the CSV row
            $FirstName = $row[0]; // First name from the CSV file
            $LastName = $row[1]; // Last name from the CSV file
            $FatherName = $row[2]; // Father's name from the CSV file
            $nameMark = $row[3];
            $markNum = $row[4];
            $year = $row[5];
            $semester = $row[6];
           
            
            // Find the user based on first name, last name, and father's name
            $user = User::where([
                'FirstName' => $FirstName,
                'LastName' => $LastName,
                'FatherName' => $FatherName,
            ])->first();
            
            // If the user is found, create a new MyMarks instance associated with the user
            if ($user) {
                return new MyMarks([
                    'nameMark' => $nameMark,
                    'markNum' => $markNum,
                    'year' => $year,
                    'semester' => $semester,
                    'user_id' => $user->id,
                ]);
            }
            
            // If user not found, return null (mark won't be imported for this row)
            return null;
        }
    }
    
    
