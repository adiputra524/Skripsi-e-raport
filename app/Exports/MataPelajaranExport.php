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
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class MataPelajaranExport implements FromQuery, WithStrictNullComparison, WithHeadings
{
    // use ExportTable;

    public function headings(): array
    {
        return [
            'id',
            'raport_header_id',
            'nama_mata_pelajaran',
            'nilai_uts',
            'nilai_uas',
            'catatan',
        ];
    }
    public function query()
    {

        return Mata_pelajaran::query()
            ->select('mata_pelajarans.id', 'rapor_header_id', 'nama_mata_pelajaran', 'nilai_uts', 'nilai_uas', 'catatan')
            ->join('rapor_headers as rh', 'mata_pelajarans.rapor_header_id', '=', 'rh.id')
            ->join('raports as r', 'rh.rapor_id', '=', 'r.id')
            ->where('rapor_header_id','!=','2');
            // ->where('student_id', '=', Session::raport()->id);


        // // return MataPelajaran::query()
        // $raport = DB::table('mata_pelajarans as mp')
        // ->select('*')
        // ->join('rapor_headers as rh', 'mp.rapor_header_id', '=', 'rh.id')
        // ->join('raports as r', 'rh.rapor_id', '=', 'r.id')
        // ->where('student_id', '=', 'id')
        // ->get();

    }
    // public function collection()
    // {
    //     return Mata_pelajaran::all();
    // }
}
