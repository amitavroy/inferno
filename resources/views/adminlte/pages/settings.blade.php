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

@section('content')
  <div class="row">
    <div class="col-sm-8">
      <div class="box box-primary">
        <form action="{{route('settings-save')}}" class="form-horizontal" method="post" id="setting-manage">
          {{csrf_field()}}
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
                         name="setting[{{$key}}]"
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

    <div class="col-sm-4">
      <div class="box box-primary">
        <form action="{{route('settings-add')}}" id="add-setting-form" method="post">
          {{csrf_field()}}

          <div class="box-header with-border">
            <h3 class="box-title">Add new setting</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="form-group">
              <label for="">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter a setting name"/>
              <div class="HelpText error">{{$errors->first('name')}}</div>
            </div>

            <div class="form-group">
              <label for="">Value</label>
              <input type="text" class="form-control" name="value" placeholder="Enter the setting value"/>
              <span class="HelpText info">For true of false value use 0 or 1</span>
              <div class="HelpText error">{{$errors->first('value')}}</div>
            </div>
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