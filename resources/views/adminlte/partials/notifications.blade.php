@if(session('flash_notification.message'))
  <section class="notification">
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-{{ session('flash_notification.level') }} alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {!! session('flash_notification.message') !!}
        </div>
      </div>
    </div>
  </section>
@endif