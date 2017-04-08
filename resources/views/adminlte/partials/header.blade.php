<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{Setting::get('app_name', 'AdminLTE')}} | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="{{ url('adminlte/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('adminlte/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ url('adminlte/css/ionicons.min.css') }}">
  <link rel="stylesheet" href="{{ url('adminlte/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
  <link rel="stylesheet" href="{{ url('adminlte/css/_all-skins.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <script>
    window.Laravel = { csrfToken: '{{ csrf_token() }}' }
    window.inferno = { host: '{{ url("/") }}/' }
  </script>
</head>