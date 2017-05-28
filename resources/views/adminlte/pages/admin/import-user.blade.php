@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>Import users<small> Import bulk users to the system.</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Import users</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-3">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Select a file to import</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="{{route('bulk-import-user')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="form-group">
              <label for="file">CSV file to upload</label>
              <input type="file" name="file" id="file" class="form-control">
              <div class="HelpText error">{{$errors->first('file')}}</div>
            </div>

            <div class="form-group">
              <button class="btn btn-primary">
                <i class="fa fa-upload"></i> Upload
              </button>
            </div>
          </form>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">

        </div>
      </div>
    </div>

    <div class="col-sm-9">
      @if($errors = Session::get('error_rows'))
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Error in data</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <table class="table table-hover table-striped">
              <thead>
              <tr>
                @foreach($errors[0] as $key => $value)
                  <th>{{ucfirst($key)}}</th>
                @endforeach
              </tr>
              </thead>

              <tbody>
              @foreach($errors as $key => $value)
                <tr>
                  @foreach($value as $data)
                    <td>{{$data}}</td>
                  @endforeach
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">

          </div>
        </div>
      @endif
    </div>
  </div>
@endsection