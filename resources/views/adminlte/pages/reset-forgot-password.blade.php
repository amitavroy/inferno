@extends('adminlte.guest-html')

@section('content')
  <div class="login-box-body">
    <p class="login-box-msg">Reset your password</p>

    <form action="{{route('update-forgot-password')}}" method="post">
      {{csrf_field()}}

      <input type="hidden" name="token" value="{{$token}}"/>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="New password" name="password" tabindex="1">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <div class="HelpText error">{{$errors->first('password')}}</div>
      </div>

      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Confirm password" name="confirm_password" tabindex="2">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <div class="HelpText error">{{$errors->first('confirm_password')}}</div>
      </div>
      <button type="submit" class="btn btn-primary btn-block btn-flat">
        <i class="fa fa-save"></i> Change password
      </button>
    </form>
    <br/>

  </div>
  <!-- /.login-box-body -->
@endsection