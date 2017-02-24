@extends('adminlte.guest-html')

@section('content')
  <div class="login-box-body">
    <p class="login-box-msg">Get email to reset your password.</p>

    <form action="{{route('forgot-password-send')}}" method="post">
      {{csrf_field()}}
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" tabindex="1">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <div class="HelpText error">{{$errors->first('email')}}</div>
      </div>
      <button type="submit" class="btn btn-primary btn-block btn-flat">
        <i class="fa fa-envelope"></i> Send email
      </button>
    </form>
    <br/>

  </div>
  <!-- /.login-box-body -->
@endsection