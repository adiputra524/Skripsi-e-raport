@extends('template.student_master')
@section('title', 'Nilai Siswa')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Daftar Nilai</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
            <div class="card-body table-responsive-sm">
              <h3 class="m-0 text-dark">Kelas 10 Semester 1</h3> 
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
                  @empty($raport)
                    <tr>
                      <td colspan="5">
                        <div class="d-flex justify-content-center align-self-center">
                          Data Kosong
                        </div>
                      </td>
                    </tr>
                  @else
                    @foreach($raport as $data)
                      <tr>
                        <td> {{ $data->id }} </td>
                        <td> {{ $data->nama_mata_pelajaran }} </td>
                        <td> {{ $data->nilai_uts }} </td>
                        <td> {{ $data->nilai_uas }} </td>
                        <td> {{ $data->catatan }} </td>
                      </tr>
                    @endforeach
                  @endempty
                </tbody>
              </table>

            </div>
          </div>

          <div class="row">
            <div class="card-body table-responsive-sm">
                 <h3 class="m-0 text-dark">Kelas 10Semester 2</h3>
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
                  @empty($raport)
                    <tr>
                      <td colspan="5">
                        <div class="d-flex justify-content-center align-self-center">
                          Data Kosong
                        </div>
                      </td>
                    </tr>
                  @else
                    @foreach($raport as $data)
                      <tr>
                        <td> {{ $data->id }} </td>
                        <td> {{ $data->nama_mata_pelajaran }} </td>
                        <td> {{ $data->nilai_uts }} </td>
                        <td> {{ $data->nilai_uas }} </td>
                        <td> {{ $data->catatan }} </td>
                      </tr>
                    @endforeach
                  @endempty
                </tbody>
              </table>

            </div>
          </div>

              <div class="row">
            <div class="card-body table-responsive-sm">
                 <h3 class="m-0 text-dark">Kelas 11 Semester 1</h3>
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
                  @empty($raport)
                    <tr>
                      <td colspan="5">
                        <div class="d-flex justify-content-center align-self-center">
                          Data Kosong
                        </div>
                      </td>
                    </tr>
                  @else
                    @foreach($raport as $data)
                      <tr>
                        <td> {{ $data->id }} </td>
                        <td> {{ $data->nama_mata_pelajaran }} </td>
                        <td> {{ $data->nilai_uts }} </td>
                        <td> {{ $data->nilai_uas }} </td>
                        <td> {{ $data->catatan }} </td>
                      </tr>
                    @endforeach
                  @endempty
                </tbody>
              </table>

            </div>
          </div>

              <div class="row">
            <div class="card-body table-responsive-sm">
                 <h3 class="m-0 text-dark">Kelas 11 Semester 2</h3>
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
                  @empty($raport)
                    <tr>
                      <td colspan="5">
                        <div class="d-flex justify-content-center align-self-center">
                          Data Kosong
                        </div>
                      </td>
                    </tr>
                  @else
                    @foreach($raport as $data)
                      <tr>
                        <td> {{ $data->id }} </td>
                        <td> {{ $data->nama_mata_pelajaran }} </td>
                        <td> {{ $data->nilai_uts }} </td>
                        <td> {{ $data->nilai_uas }} </td>
                        <td> {{ $data->catatan }} </td>
                      </tr>
                    @endforeach
                  @endempty
                </tbody>
              </table>

            </div>
          </div>

              <div class="row">
            <div class="card-body table-responsive-sm">
                 <h3 class="m-0 text-dark">Kelas 12 Semester 1</h3>
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
                  @empty($raport)
                    <tr>
                      <td colspan="5">
                        <div class="d-flex justify-content-center align-self-center">
                          Data Kosong
                        </div>
                      </td>
                    </tr>
                  @else
                    @foreach($raport as $data)
                      <tr>
                        <td> {{ $data->id }} </td>
                        <td> {{ $data->nama_mata_pelajaran }} </td>
                        <td> {{ $data->nilai_uts }} </td>
                        <td> {{ $data->nilai_uas }} </td>
                        <td> {{ $data->catatan }} </td>
                      </tr>
                    @endforeach
                  @endempty
                </tbody>
              </table>

            </div>
          </div>

              <div class="row">
            <div class="card-body table-responsive-sm">
                 <h3 class="m-0 text-dark">Kelas 12 Semester 2</h3>
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
                  @empty($raport)
                    <tr>
                      <td colspan="5">
                        <div class="d-flex justify-content-center align-self-center">
                          Data Kosong
                        </div>
                      </td>
                    </tr>
                  @else
                    @foreach($raport as $data)
                      <tr>
                        <td> {{ $data->id }} </td>
                        <td> {{ $data->nama_mata_pelajaran }} </td>
                        <td> {{ $data->nilai_uts }} </td>
                        <td> {{ $data->nilai_uas }} </td>
                        <td> {{ $data->catatan }} </td>
                      </tr>
                    @endforeach
                  @endempty
                </tbody>
              </table>

            </div>
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
@endsection