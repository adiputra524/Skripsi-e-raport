<?php

namespace App\Imports;

use App\SchoolInternal;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use DB;
class SchoolInternalImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $guru = SchoolInternal::find($row[0]);
        
        if($row[0] === "id") return;

        $email = DB::table('school_internals')
        ->select('*')
        ->where('email','=',trim($row[2]))
        ->get()
        ->first();
        // dd($email);

        if(isset($email->id)){
            return;
        }

        if($guru == null){
            return new SchoolInternal([
                'name' => $row[1],
                'email' => $row[2],
                'phone' => $row[3],
                'password' => Hash::make($row[4]),
                'role_id' => (int) $row[5],


            ]);

        }else if($guru != null)
        {
            $guru->name=$row[1];
            $guru->email=$row[2];
            $guru->phone=$row[3];
            $guru->password=Hash::make($row[4]);
            $guru->role_id=(int) $row[5];
            $guru->save();

        }
        return ;
    }
}
