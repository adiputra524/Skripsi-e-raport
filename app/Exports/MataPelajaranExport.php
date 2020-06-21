<?php

namespace App\Exports;

use App\Mata_pelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;

class MataPelajaranExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mata_pelajaran::all();
    }
}
