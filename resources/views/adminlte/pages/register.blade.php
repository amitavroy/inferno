<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Inferno | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="{{ url('adminlte/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('adminlte/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{url('/')}}"><b>Inferno</b></a>
  </div>
@include('flash::message')
<!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Hell awaits you... register with us</p>

    <form action="{{route('do-register')}}" method="post" id="registration-form">
      {{csrf_field()}}

      <div class="form-group has-feedback">
        <input type="text"
               name="name"
               class="form-control"
               placeholder="Full name"
               value="{{old('name')}}">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <div class="HelpText error">{{$errors->first('name')}}</div>
      </div>
      <div class="form-group has-feedback">
        <input type="email"
               name="email"
               class="form-control"
               value="{{old('email')}}"
               placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <div class="HelpText error">{{$errors->first('email')}}</div>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <div class="HelpText error">{{$errors->first('password')}}</div>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="cpassword" class="form-control" placeholder="Retype password">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        <div class="HelpText error">{{$errors->first('cpassword')}}</div>
      </div>
      <div class="row">
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    @if(Setting::get('social_login'))
      <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
          Facebook</a>
        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
          Google+</a>
      </div>
      <!-- /.social-auth-links -->
    @endif
    <br>
    <a href="{{url('/')}}" class="text-center">I already have an account</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

</body>
</html>
