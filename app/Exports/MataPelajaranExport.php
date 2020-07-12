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
class MataPelajaranExport implements FromQuery
{
    // use ExportTable;

    protected $id;

    function __construct($id)
    {
        $this->id = $id;
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
     
        $raport = DB::table('raports as r')
        ->select('r.student_id','r.id as rapor_id')
        ->where('r.student_id','=',$this->id)
        ->get()
        ->first();
      

        if($raport == null){
            return redirect('/internal/DaftarNilaiSiswa/'.$this->id);
        }

        $query = "SELECT rh.id as rapor_header_id,semester,grade,tahun_ajaran FROM rapor_headers rh
         WHERE rh.rapor_id =". $raport->rapor_id;

         $rapor_header = DB::select($query);
      
         $raport_bundle_content = [];

        foreach ($rapor_header as $header) {
            $query = "SELECT nama_mata_pelajaran, nilai_uts, nilai_uas, catatan 
						FROM mata_pelajarans mp
							WHERE mp.rapor_header_id = " . $header->rapor_header_id;

            $datas = DB::select($query);

            $factory = new ShowRaporHeader(
                    $header->rapor_header_id,
                    $header->semester,
                    $header->grade,
                    $header->tahun_ajaran,
                    $datas
                );

            array_push($raport_bundle_content, $factory);
        }


        $rapot = new ShowRaport(
                $raport->student_id,
                $raport->rapor_id,
                $raport_bundle_content
            );

            

        // return Mata_pelajaran::where('rapor_header_id',$this->id)->get()([
        //     'id','rapor_header_id', 'nama_mata_pelajaran', 'nilai_uts', 'nilai_uas','catatan'
        // ]);
        return $rapot;
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
class ShowRaport
{
    public $student_id;
    public $rapor_id;
    public $raport_headers;

    public function __construct($a, $b, $c)
    {
        $this->student_id = $a;
        $this->rapor_id = $b;
        $this->raport_headers = $c;
    }
}
class ShowRaporHeader
{
    public $rapor_header_id;
    public $semester;
    public $grade;
    public $tahun_ajaran;
    public $mata_pelajarans;

    public function __construct($a, $b, $c, $d, $e)
    {
        $this->rapor_header_id = $a;
        $this->semester = $b;
        $this->grade = $c;
        $this->tahun_ajaran = $d;
        $this->mata_pelajarans = $e;
    }
}