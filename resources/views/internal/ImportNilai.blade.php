@extends('template.internal_master')
@section('title', 'Import Nilai')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 diplay-3 text-dark">Input Nilai Raport</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="container">
    <div class="row pt-5">
        <div class="col-md-2"></div>
        <div class="col-12 col-md-8 d-inline justify-content-center">
            <div class="row">
                <form method="post" class="form-inline" enctype="multipart/form-data" action="/pelajaran/internal/DaftarNilaiSiswa">

                <div class="col-8 d-flex justify-content-center">
                        @csrf  
                        <input name="select_file" type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="select_file" class="form-control-file"  />
                </div>

                <div class="col-4 d-flex justify-content-center">
                        <input type="submit" name="upload" class="btn btn-primary" value="Upload" />            
                </div>
                </form> 

            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

@endsection