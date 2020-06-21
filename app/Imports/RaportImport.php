<?php

namespace App\Imports;

use App\Raport;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
class RaportImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $raport = Raport::find($row[0]);
        if($row[0]=== "id") return;

        $raport = DB::table('raports')
        ->select('*')
        ->where('student_id','=',trim($row[1]))
        ->get()
        ->first();

        if(isset($raport->id)){
            return;
        }
        if($raport == null){


            return new Raport([
                'student_id'=> (int)$row[1],
                'created_at'=> new\DateTime('now')
                
            ]);

        }else if($raport != null)
        {
            $raport->student_id = (int) $row[1];
            $raport->updated_at = new\DateTime('now');
            $raport->save();
        }

        return;
    }
}
