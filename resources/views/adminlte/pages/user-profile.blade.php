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

              <fieldset>
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
              </fieldset>

              <div class="form-group">
                <label for="display_name">Country:</label>
                <input type="text"
                       class="form-control"
                       name="country"
                       value="{{Auth::user()->profile->country}}"
                       placeholder="Enter your country"/>
                <div class="Message error">{{$errors->first('country')}}</div>
              </div>

              <div class="form-group">
                <label for="display_name">Twitter id:</label>
                <input type="text"
                       class="form-control"
                       name="twitter"
                       value="{{Auth::user()->profile->twitter}}"
                       placeholder="Enter your twitter username"/>
                <div class="Message error">{{$errors->first('twitter')}}</div>
              </div>

              <div class="form-group">
                <label for="display_name">Facebook profile:</label>
                <input type="text"
                       class="form-control"
                       name="facebook"
                       value="{{Auth::user()->profile->facebook}}"
                       placeholder="Enter your facebook profile url"/>
                <div class="Message error">{{$errors->first('facebook')}}</div>
              </div>

              <div class="form-group">
                <label for="display_name">Skype:</label>
                <input type="text"
                       class="form-control"
                       name="skype"
                       value="{{Auth::user()->profile->skype}}"
                       placeholder="Enter your Skype username"/>
                <div class="Message error">{{$errors->first('skype')}}</div>
              </div>

              <div class="form-group">
                <label for="display_name">Linked In:</label>
                <input type="text"
                       class="form-control"
                       name="linkedin"
                       value="{{Auth::user()->profile->linkedin}}"
                       placeholder="Enter your Linekd In username"/>
                <div class="Message error">{{$errors->first('linkedin')}}</div>
              </div>

              <div class="form-group">
                <label for="display_name">Designation:</label>
                <input type="text"
                       class="form-control"
                       name="designation"
                       value="{{Auth::user()->profile->designation}}"
                       placeholder="Enter your Linekd In username"/>
                <div class="Message error">{{$errors->first('designation')}}</div>
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
        <div class="box box-primary" id="profile-pic-block">
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