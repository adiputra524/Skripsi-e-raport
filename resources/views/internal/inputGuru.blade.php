@extends('template.internal_master')
@section('title', 'Kontol Berdebu')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Daftar Walikelas</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
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
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
          <div class="col-lg-6">
          </div>

          <div class="card-header">
           Data Walikelas
         </div>
         <form method="post" enctype="multipart/form-data" action="/auth/internal/inputGuru">
          @csrf

          <div class="card-body">
           Input Guru <input type="file" name="select_file">
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
              <th>Nama</th>
              <th>Email</th>
              <th>Nomer Telpon</th>
            </tr>
          </thead>
          <tbody>
            @foreach($school_internal as $row)
            <tr>
              <td>{{$row->id}}</td>
              <td>{{$row->name}}</td>
              <td>{{$row->email}}</td>
              <td>{{$row->phone}}</td>
              <td>
                <a href="/auth/internal/EditDataWalikelas/edit/{{$row->id}}" class="btn btn-warning">Edit</a>
                <a href="/auth/internal/inputGuru/hapus/{{$row->id}}
                  " class="btn btn-danger">Hapus</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div>
      </section>

@endsection