@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>Configuration<small>Watchdog entries</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{route('config')}}">Configurations</a></li>
      <li class="active">Settings</li>
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
        <form action="" class="form-horizontal">
          <div class="box-header with-border">
            <h3 class="box-title">Application settings</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            @foreach($settings as $key => $value)
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">{{$key}}</label>
                <div class="col-sm-10">
                  <input type="{{$key}}"
                         class="form-control"
                         id="inputEmail3"
                         value="{{$value}}"
                         placeholder="{{$key}}">
                </div>
              </div>
            @endforeach

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button class="btn btn-success">
              <i class="fa fa-save"></i> Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection