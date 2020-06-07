<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Raport;
use DB;
use Excel;
class RaportController extends Controller
{
	public function IndexGetRaport()
	{

		$data = Raport::all();
		return view('',compact('data'));

	}

	public function DownloadDataNilai($type)
	{
		$data = Raport::get()->toArray();
		return Excel::create('NilaiSiswa',function($excel)use($data){
			$excel->sheet('mysheet',function($sheet)use($data)
			{ 
				$sheet->fromArray($data);

			});
		})->download($type);
	}

	function ImportNilai(Request $request)
	{
		Raport::truncate();
		$this->validate($request,['select_file'=>'required|mimes:xls,xlsx']);
		$path = $request->file('select_file')->getRealPath();
		$data = Excel::load($path)->get();
		if($data->count()>0)
		{
			foreach($data as $row)
			{
				$insert_data[] = array(
					'matapelajaran' =>$row['matapelajaran'],
					'nilai' => $row['nilai'],
					'catatan ' => $row['catatan']
				);
			}

			if(!empty($insert_data))
			{
				DB::table('raport')->($insert_data);
			}
		}

		return back()->with('success','Excel Data Imported successfully');
	}
    
}
