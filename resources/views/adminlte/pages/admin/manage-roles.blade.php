@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>Manage Roles<small>All the roles available in the application</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{route('config')}}">Configurations</a></li>
      <li class="active">Roles</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-8">
      {{--Box--}}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Roles</h3>
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
            @foreach($roles as $role)
              <tr>
                <td>{{$role->id}}</td>
                <td>{{ucwords($role->name)}}</td>
                <td class="col-sm-3">
                  @if($role->id != 1 && $role->id != 2)
                    <div class="pull-left">
                      <a href="{{route('edit-role', $role->id)}}" class="btn btn-primary btn-xs">
                        <i class="fa fa-edit"></i> Edit
                      </a>
                    </div>
                    <div class="pull-left gap-left gap-10">
                      <confirm-modal
                        btn-text='<i class="fa fa-trash"></i> Delete'
                        btn-class="btn-danger"
                        url="{{url('api/v1/delete-role')}}"
                        :post-data="{{json_encode(['id' => $role->id])}}"
                        :refresh="true"
                        message="Are you sure you want to delete role {{$role->name}}?">
                      </confirm-modal>
                    </div>
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>

          {{$roles->render()}}
        </div>
        <!-- /.box-body -->
      </div>
      {{--End box--}}
    </div>

    <div class="col-sm-4">
      {{--Box--}}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Add a new Role</h3>
        </div>
        <form action="{{route('save-role')}}" method="post" id="role-save-form">
          <!-- /.box-header -->
          <div class="box-body">
            {{csrf_field()}}
            <div class="form-group">
              <label for="">Name:</label>
              <input type="text"
                     placeholder="Enter role name"
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