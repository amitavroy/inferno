@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>My profile<small>Manage my settings and other aspects of application</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Profile</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="section">
    <div class="row">
      <div class="col-md-7 col-sm-12">
        <form action="{{route('update-profile')}}" method="post">
          {{--Box--}}
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">My profile details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              {{csrf_field()}}

              <div class="form-group">
                <label for="display_name">Name:</label>
                <input type="text"
                       class="form-control"
                       name="name"
                       value="{{Auth::user()->name}}"
                       placeholder="Enter your name"/>
                <div class="Message error">{{$errors->first('name')}}</div>
              </div>

              <div class="form-group">
                <label for="display_name">Email:</label>
                <input type="text"
                       class="form-control"
                       value="{{Auth::user()->email}}"
                       placeholder="Enter your email address" disabled/>
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> Update
              </button>
            </div>
          </div>
        </form>
        {{--End box--}}
      </div>

      <div class="col-md-5 col-sm-12">
        {{--Box--}}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">My profile pic</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <image-upload
              img-url="{{Auth::user()->present()->profilePic}}">
            </image-upload>
          </div>
          <!-- /.box-body -->
        </div>
        {{--End box--}}
      </div>
    </div>
  </div>
@endsection