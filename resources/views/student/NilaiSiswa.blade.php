<!DOCTYPE html>
<html>
<head>
  <title>
    Nilai Siswa
  </title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- font -->
  <link rel="stylesheet" type="text/css" href="{{asset('/css/all.min.css')}}">
  <!-- icon -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- main css -->
  <link rel="stylesheet" type="text/css" href="{{asset('/css/adminlte.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" type="text/css" href="{{asset('/css/icheck-bootstrap.min.css')}}">

  
  <!-- google font -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- overlay scrollbars -->
  <link rel="stylesheet" type="text/css" href="{{asset('/css/OverlayScrollbars.min.css')}}">

  
  <!-- jQuery -->
  <script type="text/javascript" src="{{asset('/js/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script type="text/javascript" src="{{asset('/js/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script type="text/javascript" src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script type="text/javascript" src="{{asset('/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script type="text/javascript" src="{{asset('/js/adminlte.js')}}"></script>
  
  <!-- ajax load -->
  <script type="text/javascript" src="{{asset('js/al-nilai-s-kls10.js')}}"></script>


</head>
<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="ion-android-menu"></i></a>
        </li>

        <!-- Notifications Dropdown Menu -->



      </ul>  
    </nav>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img src="{{asset('/image/logo-strada-edit.jpg')}}" alt="sma-strada" class="brand-image img-square"
        style="opacity: .8">
        <span class="brand-text font-weight-light">Strada School</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('/image/sasuke.jpg')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{Session::get('tbl_students')->nama }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
             <li class="nav-item">
              <a href="/student/student-view" class="nav-link">
                <i class="nav-icon ion-android-home"></i>
                <p>
                  Home
                </p>
              </a>
            </li> 
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon ion-android-clipboard"></i>
                <p>
                  Penilaian Akademik
                  <i class="right ion-android-arrow-dropleft"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
               @foreach(Session::get('class') as $data)
               <li class="nav-item">
                <a href="/student/siswa/NilaiSiswa/{{ $data->id }}" class="nav-link">
                  <p>{{ $data->class_name }}</p>
                </a>
              </li>
              @endforeach
            </ul>
          </li>
          <li class="nav-item">
            <a href="/student/siswa/DataWaliKelas" class="nav-link">
              <i class="ion-android-people"></i>
              <p>
                List Walikelas
              </p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon ion-android-lock"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/student/StudentLogout" class="nav-link">
              <i class="nav-icon ion-log-out"></i>
              <p>
                Log Out
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Nilai</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
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
            <div class="card-body table-responsive-sm">
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
        </section>
        <!-- /.Left col -->

      </div>

         <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <div class="card-body table-responsive-sm">
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
        </section>
        <!-- /.Left col -->

      </div>
         <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <div class="card-body table-responsive-sm">
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
        </section>
        <!-- /.Left col -->

      </div>
         <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <div class="card-body table-responsive-sm">
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
        </section>
        <!-- /.Left col -->

      </div>
         <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <div class="card-body table-responsive-sm">
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
        </section>
        <!-- /.Left col -->

      </div>
         <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <div class="card-body table-responsive-sm">
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
        </section>
        <!-- /.Left col -->

      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
</div>

</body>
</html> 
