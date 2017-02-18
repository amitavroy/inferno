@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>Activations Pending<small>Users in the system whose's activation is pending</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{route('config')}}"><i class="fa fa-gear"></i> Configuration</a></li>
      <li class="active">User activation pending</li>
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
          <user-activation :users="{{$users}}"></user-activation>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">

        </div>
      </div>
    </div>
  </div>
@endsection