<?php

namespace App\Exports;

// use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MappingRapot implements WithHeadings
{
    function __construct($data)
    {
        $this->data = $data;
    }
    public function headings(): array
    {
        	$columnIndex = 0;
            $data = $this->data;
            $array = [];
			if (count($data->raport_headers) > 0) {
				foreach ($data->raport_headers as $d) {
                    array_push($array, ['Kelas ' . $d->grade . ' Semester ' . $d->semester . ' Tahun Ajaran ' . $d->tahun_ajaran]);
                    array_push($array, ['No', 'Mata Pelajaran', 'UTS', 'UAS', 'Catatan']);
                    $idx = 1;
					foreach($d->mata_pelajarans as $mp) {
                        array_push($array, [$idx, $mp->nama_mata_pelajaran, $mp->nilai_uts, $mp->nilai_uas, $mp->catatan,]);
                        $idx += 1;
                    }
                    array_push($array, []);
				}
			}
        return $array;
    }
}