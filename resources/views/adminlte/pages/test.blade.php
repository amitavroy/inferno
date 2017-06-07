@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>Test Page<small>Random testing</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <form action="{{url('test')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <file-field></file-field>
        </div>

        <button class="btn btn-primary">
          <i class="fa fa-upload"></i> Upload
        </button>
      </form>
    </div>
  </div>
@endsection