@extends('template.student_master')
@section('title', 'Dashboard')
@section('css_after')
<link rel="stylesheet" href="{{ asset('css/Chart.css') }}" />
@endsection
@section('content')
  <div class="content-header">
    <div class="chart"></div>

    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div>
      </div>
  </div>

   <section class="content">
      <div class="container-fluid">
       
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-12">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            
            
            
          </section>
          <!-- /.Left col -->
         
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

@endsection
@section('js_after')
  {{-- <script type="text/javascript" src="{{asset('js/Chart.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/canvasjs.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/graph-v3.js')}}"></script> --}}
@endsection