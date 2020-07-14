@extends('template.internal_master')
@section('title', 'Dashboard')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit Data Siswa</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="post" action="/student/internal/update/{{$students->id}}">
      {{csrf_field()}}
      {{method_field('PUT')}}


      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <!-- Main row -->
          <div class="row">
          <input type="hidden" name="id" value="{{$students->id}}">
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Email</th>
                  <th>Nomer Telpon</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="text" name="nis" id="nis" value="{{$students->nis}}" ></td>
                  <td><input type="text" name="nama" id="nama" value="{{$students->nama}}"></td>
                  <td><input type="text" name="kelas" id="kelas" value="{{$students->class_id}}"></td>
                  <td><input type="email" name="email" id="email" value="{{$students->email}}"></td>
                  <td><input type="text" name="phone" id="phone" value="{{$students->phone}}"></td>
                </tr>
              </tbody>
            </table>
            <br>
            <div class="form-group">
              <input type="submit" class="btn btn-success" value="Simpan">
            </div>
            <div class="card-body">
            </div>
          </div>
        </form>
        <!-- /.row (main row) -->
@endsection