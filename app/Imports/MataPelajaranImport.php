<?php

namespace App\Imports;

use App\Mata_pelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use DB;
use Session;
class MataPelajaranImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      
        $mata_pelajaran  = Mata_pelajaran::find($row[0]);
        
        if($row[0] === "rapor_header_id") return;

        $mata_pelajaran = DB::table('mata_pelajarans')
        ->select('*')
        ->where('id','=',trim($row[0]))
        ->get()
        ->first();

        $mata_pelajaran = DB::table('mata_pelajarans')
        ->select('*')
        ->where('nama_mata_pelajaran','=',trim($row[1]))
        ->get()
        ->first();

       
        if($mata_pelajaran ==null){

            return new Mata_pelajaran([
                'rapor_header_id' => Session::get('raport_header_id'),
                'nama_mata_pelajaran'=>$row[1],
                'nilai_uts'=>(double)$row[2],
                'nilai_uas'=>(double)$row[3],
                'catatan'=>$row[4]
            ]);
        }else if($mata_pelajaran !=null)
        {
            // dd($mata_pelajaran);

          $mata_pelajaran->nama_mata_pelajaran=$row[1];
          $mata_pelajaran->nilai_uts=(double) $row[2];
          $mata_pelajaran->nilai_uas=(double) $row[3];
          $mata_pelajaran->catatan= $row[4];
          $mata_pelajaran->save();  
        }
        return ;
    }
}
