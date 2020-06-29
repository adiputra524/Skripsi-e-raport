<?php

namespace App\Imports;

use App\TblStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use DB;
class TblStudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $student = TblStudent::find($row[0]);
        
        if($row[0] === "id") return;
        


        if($student == null){
            $data = DB::table('tbl_students')
            ->select('*')
            ->where('nis','=',  trim($row[1]))
            ->get()
            ->first();


            if(isset($data->id)){
                return;
            }

            $email = DB::table('tbl_students')
            ->select('*')
            ->where('email','=', trim($row[4]))
            ->get()
            ->first();

            if(isset($email->id)){
                return;
            }

            
            return new TblStudent([
                'nis' => $row[1],
                'nama' => $row[2],
                'class_id' => (int) $row[3],
                'email' => $row[4],
                'phone' => $row[5],
                'password' => Hash::make($row[6]),
                'created_at' => new \DateTime('now')
            ]);
        }else if($student != null){
            $student->nis = $row[1];
            $student->nama = $row[2];
            $student->class_id = (int) $row[3];
            $student->email = $row[4];
            $student->phone = $row[5];
            $student->password = Hash::make($row[6]);
            $student->updated_at = new \DateTime('now');
            $student->save();
        }

        return;
    }
}
