<?php

namespace App\Exports;

use App\Mata_pelajaran;
use App\Rapor_header;
use App\Raport;
use App\Exports\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
class MataPelajaranExport implements  FromQuery
{
    // use ExportTable;

    protected $id;

    function __construct($id)
    {
        $this->id = $id;

      
        return $this;
    }
    public function headings(): array
    {
        return [
            'id',
            'rapor_header_id',
            'nama_mata_pelajaran',
            'nilai_uts',
            'nilai_uas',
            'catatan',
        ];
    }

    public function query()
    {
        return Mata_pelajaran::where('rapor_header_id',$this->id)->get()([
            'id','rapor_header_id', 'nama_mata_pelajaran', 'nilai_uts', 'nilai_uas','catatan'
        ]);
        return Mata_pelajaran::where('id', $this->id);
    }

    // public function query()
    // {
    //     return Mata_pelajaran::where('rapor_header_id', $this->id);
    // }


    // public function query($id)
    // {

    //     return Mata_pelajaran::query()
    //         ->select('mata_pelajarans.id', 'rapor_header_id', 'nama_mata_pelajaran', 'nilai_uts', 'nilai_uas', 'catatan')
    //         ->join('rapor_headers as rh', 'mata_pelajarans.rapor_header_id', '=', 'rh.id')
    //         ->join('raports as r', 'rh.rapor_id', '=', 'r.id')
    //         ->where('r.student_id','=',$id)
    //         ->get();
    //         // ->where('student_id', '=', Session::raport()->id);


    //     // // return MataPelajaran::query()
    //     // $raport = DB::table('mata_pelajarans as mp')
    //     // ->select('*')
    //     // ->join('rapor_headers as rh', 'mp.rapor_header_id', '=', 'rh.id')
    //     // ->join('raports as r', 'rh.rapor_id', '=', 'r.id')
    //     // ->where('student_id', '=', 'id')
    //     // ->get();

    // }

}
