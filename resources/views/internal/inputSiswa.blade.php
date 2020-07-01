@extends('template.internal_master')
@section('title', 'Input Siswa')
@section('content')
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Daftar Siswa</h1>
          </div>
        </div>
        @isset($success)
          <div class="row">
            <div class="col-12">
              <div class="alert alert-success" role="alert">
                  <strong>
                    {{ $success }}
                  </strong>
                    }
              </div>
            </div>
          </div>
        @endisset
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <section class="col-lg-12">
            <div class="col-lg-6">
            </div>

            <div class="card-header">
             Data Siswa
           </div>
           <form method="post" enctype="multipart/form-data" action="/student/internal/inputSiswa">
            @csrf

           <div class="card-body">
           Input Siswa <input type="file" name="select_file">
            <td width="30%" align="Left">
              <input type="submit" name="upload" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class="btn btn-primary" value="Upload">
            
            </div>
          </form>

            <br/>
            <br/>
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Email</th>
                  <th>Nomer Telpon</th>

                </tr>

              </thead>
              <tbody>

                @foreach($tbl_student as $row)
                <tr>
                  <td>{{$row->id}}</td>
                  <td>{{$row->nis}}</td>
                  <td>{{$row->nama}}</td>
                  <td>{{$row->grade}}</td>
                  <td>{{$row->email}}</td>
                  <td>{{$row->phone}}</td>
                  <td>
                  <a href="/student/internal/EditDataSiswa/edit/{{$row->id}}" class="btn btn-warning">Edit</a>
                  <a href="/student/internal/inputSiswa/hapus/{{$row->id}}
                  " class="btn btn-danger">Hapus</a>
                </td>
                </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </section>
@endsection