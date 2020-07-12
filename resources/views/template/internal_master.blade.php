<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>
    E-Raport - @yield('title')
  </title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  @yield('css_before')
  {{-- <!-- font --> --}}
  <link rel="stylesheet" type="text/css" href="{{asset('/css/all.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('/css/app.css')}}">
  {{-- <!-- icon --> --}}
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  {{-- <!-- main css --> --}}
  <link rel="stylesheet" type="text/css" href="{{asset('/css/adminlte.min.css')}}">
  {{-- <!-- iCheck --> --}}
  <link rel="stylesheet" type="text/css" href="{{asset('/css/icheck-bootstrap.min.css')}}">

  
  {{-- <!-- google font --> --}}
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  {{-- <!-- overlay scrollbars --> --}}
  <link rel="stylesheet" type="text/css" href="{{asset('/css/OverlayScrollbars.min.css')}}">

  
  {{-- <!-- jQuery --> --}}
  <script type="text/javascript" src="{{asset('/js/jquery.min.js')}}"></script>
  {{-- <!-- jQuery UI 1.11.4 --> --}}
  <script type="text/javascript" src="{{asset('/js/jquery-ui.min.js')}}"></script>
  {{-- <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip --> --}}
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  {{-- <!-- Bootstrap 4 --> --}}
  <script type="text/javascript" src="{{asset('/js/bootstrap.bundle.min.js')}}"></script>
  {{-- <!-- overlayScrollbars --> --}}
  <script type="text/javascript" src="{{asset('/js/jquery.overlayScrollbars.min.js')}}"></script>
  {{-- <!-- AdminLTE App --> --}}
  <script type="text/javascript" src="{{asset('/js/adminlte.js')}}"></script>
  {{-- <!-- graph --> --}}
  
  
  {{-- <!-- JSON --> --}}
  <script type="text/javascript" src="{{asset('js/ajax-load.js')}}"></script>

    <script type="text/javascript" src="{{ asset('js/bootstrap-notify/bootstrap-notify.js') }}"></script>

  @yield('css_after')
  @yield('js_before')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="ion-android-menu"></i></a>
        </li>   
      </ul>  
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="#" class="brand-link">
        <img src="{{asset('/image/logo-strada-edit.jpg')}}" alt="sma-strada" class="brand-image img-square"
        style="opacity: .8">
        <span class="brand-text font-weight-light">Strada School</span>
      </a>

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{asset('/image/sasuke.jpg')}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ Session::get('school_internals')->name }}</a>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="/internal/internal-dashboard" class="nav-link">
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
                  <a href="/student/internal/DataSiswa/{{ $data->id }}" class="nav-link">
                    <p>{{ $data->class_name }}</p>
                  </a>
                </li>
                @endforeach
                <li class="nav-item">
                  <a href="/pelajaran/internal/ImportNilai" class="nav-link">
                    <p>Import Nilai</p>
                  </a>
              </li>
              </ul>
            </li>

            @if(Session::get('school_internals')->role_id == '1')
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                <i class="nav-icon ion-android-people"></i>
                <p>
                    Manage
                    <i class="right ion-android-arrow-dropleft"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                
                <li class="nav-item">
                    <a href="/auth/internal/inputGuru" class="nav-link">
                    <p>Akun WaliKelas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/student/internal/inputSiswa" class="nav-link">
                    <p>Akun Siswa</p>
                    </a>
                </li>
                </ul>
            </li>
            @endif
            <li class="nav-item">
              <a href="/auth/logout" class="nav-link">
                <i class="nav-icon ion-log-out"></i>
                <p>
                  Log Out
                </p>
              </a>
            </li>
            
          </ul>
        </nav>
      </div>
    </aside>
    <div class="content-wrapper">
        @yield('content')
    </div>
    </div>
</section>
</div>
</div>

@yield('js_after')

@if(Session::has('error'))
    <script type="text/javascript">
    
    $.notify({message: '{{ Session::get('error') }}'},{ z_index: 99999, type: 'danger' });

    </script>
@endif

@if(Session::has('success'))
    <script type="text/javascript">
    
    $.notify({message: '{{ Session::get('success') }}'},{ z_index: 99999, type: 'success' });

    </script>
@endif

</body>
</html>