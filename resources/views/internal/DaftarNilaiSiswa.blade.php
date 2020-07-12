@extends('template.internal_master')
@section('title', 'Dashboard')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Daftar Nilai</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
   <a href="/auth/internal/DaftarNilaiSiswa/{{$rapot->student_id}}" class="btn btn-secondary">Export</a>
    <section class="content">
      @foreach($rapot->raport_headers as $data)
          <div class="row">
            <div class="card-body table-responsive-sm">
            <h3 class="m-0 text-dark">Kelas {{ $data->grade }} Semester {{ $data->semester }}</h3>
              <table class="table table-bordered table-hover table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Mata Pelajaran</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Catatan</th>
                  </tr>
                </thead>
                <tbody>
                  @empty($data->mata_pelajarans)
                    <tr>
                      <td colspan="5">
                        <div class="d-flex justify-content-center align-self-center">
                          Data Kosong
                        </div>
                      </td>
                    </tr>
                  @else   
                    @foreach($data->mata_pelajarans as $pelajaran)
                      <tr>
                        <td> {{ $loop->index }} </td>
                        <td> {{ $pelajaran->nama_mata_pelajaran }} </td>
                        <td> {{ $pelajaran->nilai_uts }} </td>
                        <td> {{ $pelajaran->nilai_uas }} </td>
                        <td> {{ $pelajaran->catatan }} </td>
                      </tr>
                    @endforeach
                  @endempty
                </tbody>
              </table>
            </div>
          </div>
      @endforeach
    </section>
@endsection