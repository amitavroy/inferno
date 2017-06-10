<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <user-image
          img-class="img-circle"
          src="{{Auth::user()->present()->profilePic}}"
          alt="{{Auth::user()->name}}">
        </user-image>
      </div>
      <div class="pull-left info">
        <p>{{Auth::user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>

      <li class="{{ Request::is('dashboard') ? 'active' : ''  }} treeview">
        <a href="{{route('dashboard')}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
      </li>

      <li class="{{ Request::is('media-manager') ? 'active' : ''  }} treeview">
        <a href="{{route('media-manager')}}"><i class="fa fa-picture-o"></i><span>Media Manager</span></a>
      </li>

      @role('admin')
        <li class="{{ Request::is('config/user/*') ? 'active' : ''  }} treeview">
          <a href="#">
            <i class="fa fa-user"></i> <span>Users and Roles</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Request::is('config/user/import') ? 'active' : ''  }}">
              <a href="{{route('import-user')}}"><i class="fa fa-circle-o"></i> Import Users</a>
            </li>
            <li class="{{ Request::is('config/user/roles') ? 'active' : ''  }}">
              <a href="{{route('manage-roles')}}"><i class="fa fa-circle-o"></i> Manage Roles</a>
            </li>
            <li class="{{ Request::is('config/user/permissions') ? 'active' : ''  }}">
              <a href="{{route('manage-permissions')}}"><i class="fa fa-circle-o"></i> Manage Permissions</a>
            </li>
            @if(\Setting::get('user_can_register'))
              <li class="{{ Request::is('config/user/activation-pending') ? 'active' : ''  }}">
                <a href="{{route('user-activation-pending')}}"><i class="fa fa-circle-o"></i> Activation pending</a>
              </li>
            @endif
          </ul>
        </li>
      @endrole
      <li class="{{ Request::is('config/system/*') ? 'active' : ''  }} treeview">
        <a href="#">
          <i class="fa fa-gear"></i> <span>Configuration</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ Request::is('config/system/my-activities') ? 'active' : ''  }}">
            <a href="{{route('my-activities')}}"><i class="fa fa-circle-o"></i> My Activities</a>
          </li>
          @role('admin')
            <li class="{{ Request::is('config/system/activities') ? 'active' : ''  }}">
              <a href="{{route('activities')}}"><i class="fa fa-circle-o"></i> Activities</a>
            </li>
            <li class="{{ Request::is('config/system/settings') ? 'active' : ''  }}">
              <a href="{{route('settings')}}"><i class="fa fa-circle-o"></i> Settings</a>
            </li>
          @endrole
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>