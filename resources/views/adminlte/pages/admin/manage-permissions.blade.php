@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>Manage permissions<small>Manage the permissions available in the application</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{route('config')}}">Configurations</a></li>
      <li class="active">Permissions</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-8">
      {{--Box--}}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Permissions</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <td>#</td>
              <td>Name</td>
              <td></td>
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $permission)
              <tr>
                <td>{{$permission->id}}</td>
                <td>{{ucwords($permission->name)}}</td>
                <td class="col-sm-3">
                  <div class="pull-left">
                    <a href="{{route('edit-permission', $permission->id)}}" class="btn btn-primary btn-xs">
                      <i class="fa fa-edit"></i> Edit
                    </a>
                  </div>
                  <div class="pull-left gap-left gap-10">
                    <confirm-modal
                      btn-text='<i class="fa fa-trash"></i> Delete'
                      btn-class="btn-danger"
                      url="{{url('api/v1/delete-permission')}}"
                      :post-data="{{json_encode(['id' => $permission->id])}}"
                      :refresh="true"
                      message="Are you sure you want to delete role {{$permission->name}}?">
                    </confirm-modal>
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>

          {{$permissions->render()}}
        </div>
        <!-- /.box-body -->
      </div>
      {{--End box--}}
    </div>

    <div class="col-sm-4">
      {{--Box--}}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add a new Permission</h3>
        </div>
        <form action="{{route('save-permission')}}" method="post" id="perm-save-form">
          <!-- /.box-header -->
          <div class="box-body">
            {{csrf_field()}}
            <div class="form-group">
              <label for="">Name:</label>
              <input type="text"
                     placeholder="Enter permission name"
                     name="name"
                     value="{{old('name')}}"
                     class="form-control">
              <div class="HelpText error">{{$errors->first('name')}}</div>
            </div>
          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
      {{--End box--}}
    </div>
  </div>
@endsection