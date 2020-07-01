@extends('template.student_master')
@section('title', 'Data Wali Kelas')
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Data Walikelas</h1>
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
         Data Guru
       </div>
       <form method="post" enctype="multipart/form-data" action="/auth/internal/inputGuru">
        @csrf

        <div class="card-body">


        </div>
      </form>

      <br/>
      <br/>
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Nomer Telpon</th>

          </tr>

        </thead>
        <tbody>

          @foreach($school_internal as $row)
          <tr>
            <td>{{$row->id}}</td>
            <td>{{$row->name}}</td>
            <td>{{$row->phone}}</td>
            <td>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </section>
@endsection