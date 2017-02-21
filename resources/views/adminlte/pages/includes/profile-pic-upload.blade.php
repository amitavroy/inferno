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

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Change password</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form action="{{route('change-password')}}" method="post" id="change-password-form">
        {{csrf_field()}}

        <div class="form-group">
          <label for="">Current password</label>
          <input type="password" class="form-control"
                 name="current_password"
                 placeholder="Your current password"/>
          <span class="Message error">{{$errors->first('current_password')}}</span>
        </div>

        <div class="form-group">
          <label for="">New password</label>
          <input type="password" class="form-control"
                 name="new_password"
                 placeholder="You new password"/>
          <span class="Message error">{{$errors->first('new_password')}}</span>
        </div>

        <div class="form-group">
          <label for="">Confirm password</label>
          <input type="password" class="form-control"
                 name="confirm_password"
                 placeholder="Re enter your new password"/>
          <span class="Message error">{{$errors->first('confirm_password')}}</span>
        </div>

        <button class="btn btn-success">
          <i class="fa fa-save"></i> Change
        </button>
      </form>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>