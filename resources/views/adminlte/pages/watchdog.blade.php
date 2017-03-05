@extends('adminlte.html')

@section('breadcrumb')
  <section class="content-header">
    <h1>Configuration<small>Watchdog entries</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Watchdog</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">My activities</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          @if($options != null)
            <form action="{{route('activities')}}" method="get" class="">
              <div class="row gap-bottom gap-20">
                <div class="col-sm-6">
                  <div class="form-group">
                    <input type="text"
                           name="search_text"
                           placeholder="Search a description"
                           value="{{$options['search_text']}}"
                           class="form-control" />
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <select name="level" id="level" class="form-control">
                      <option value="">Select</option>
                      <option value="info" {{($options['level'] === 'info') ? 'selected' : ''}}>Info</option>
                      <option value="warning" {{($options['level'] === 'warning') ? 'selected' : ''}}>Warning</option>
                      <option value="danger" {{($options['level'] === 'danger') ? 'selected' : ''}}>Danger</option>
                    </select>
                  </div>
                </div>

                <div class="col-sm-3">
                  <button class="btn btn-success">
                    <i class="fa fa-filter"></i> Filter
                  </button>
                  <a href="{{route('activities')}}" class="btn btn-primary">Reset</a>
                </div>
              </div>
            </form>
          @endif
          <div class="row">
            <div class="col-sm-12 gap-bottom gap-10">
              <strong>Total: </strong>{{$rows->total()}}
            </div>
          </div>

          <table class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>#</th>
              <th>Description</th>
              <th>Level</th>
              <th>IP Address</th>
              <th>User id</th>
              <th>Time</th>
            </tr>
            </thead>

            <tbody>
            @foreach($rows as $watchdog)
              <tr>
                <td>{{$watchdog->id}}</td>
                <td>{{$watchdog->description}}</td>
                <td>{{$watchdog->level}}</td>
                <td>{{$watchdog->ip_address}}</td>
                <td>{{$watchdog->user_id}}</td>
                <td>{{$watchdog->created_at}}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          @if ($options != null)
            {{$rows->appends($options)->links()}}
          @else
            {{$rows->render()}}
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection