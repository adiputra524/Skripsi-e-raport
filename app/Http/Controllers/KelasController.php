<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use Illuminate\Support\Facades\DB;
class KelasController extends Controller
{
    public function IndexGetClass()
    {
        $kelas = kelas::all();
        return view('',[''=>$kelas]);
    }

    public function tambahKelas()
    {
        return view('');
    }

    public function storeKelas(Request $request)
    {
    	$this->validate($request,[
    		'class_name' =>'required',
    		'grade' => 'required'

    	]);

    	Kelas::create([
    		'class_name' => $request->class_name,
    		'grade' => $request->grade

    	]);

    	return redirect('');
    }



    public function editKelas($id)
    {
    	$kelas = Kelas::find($id);
    	return view('',['' => $pegawai]);
    }

    public function updateKelas($id, Request $request)
    {
    	$this->validate($request[
    		'class_name'=>'required',
    		'grade' => 'required'

    	]);

    	$kelas =  kelas::find($id);
    	$kelas->class_name = $request->class_name;
    	$kelas->grade=$request->grade;
    	$kelas->save();
    	return redirect('');


    }

    public function deleteKelas($id)
    {
    	$kelas = Kelas::find($id);
    	$kelas->delete();
    	return redirect('');
    }


}
