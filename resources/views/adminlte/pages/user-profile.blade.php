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
      @include('adminlte.pages.includes.profile-details')
      @include('adminlte.pages.includes.profile-pic-upload')
    </div>
    <!-- /.row -->
    <div class="row">

    </div>
  </div>
@endsection