@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>Configuration<small>Watchdog entries</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Watchdog</li>
    </ol>
  </section>
@endsection

@section('breadcrumb')
  <section class="content-header">
    <h1>Settings<small>handle the application settings</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Settings</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Application settings</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

        </div>
        <!-- /.box-body -->

        <div class="box-footer">

        </div>
      </div>
    </div>
  </div>
@endsection