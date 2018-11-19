<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menus</li>
            <!-- Optionally, you can add icons to the links -->
             <li class="{{ Route::currentRouteName() == 'dashboard'?'active':'' }}"><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="{{ Route::currentRouteName() == 'users.index'?'active':'' }}"><a href="{{ route('users.index') }}"><i class="fa fa-users"></i> <span>Users</span></a></li>
            @if (Auth::user()->isCompanyAdmin())
                <li class="{{ Route::currentRouteName() == 'companies.edit'?'active':'' }}"><a href="{{ route('companies.edit', Auth::user()->company->id) }}"><i class="fa fa-globe"></i> <span>My Company</span></a></li>
            @else
                <li class="{{ Route::currentRouteName() == 'companies.index'?'active':'' }}"><a href="{{ route('companies.index') }}"><i class="fa fa-globe"></i> <span>Companies</span></a></li>
                <li class="treeview {{ Route::currentRouteName() == 'settings'?'active':'' }}">
                    <a href="#">
                        <i class="fa fa-cog"></i> <span>Settings</span>
                        <span class="pull-right-container">
                          <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="{{ Route::currentRouteName() == 'settings'?'active':'' }}"><a href="{{ route('settings') }}"><i class="fa fa-cog"></i> <span>API Settings</span></a></li>
                        <li class="{{ Route::currentRouteName() == 'clearcache'?'active':'' }}"><a href="{{ route('clearcache') }}"><i class="fa fa-eraser"></i> <span>Clear Cache</span></a></li>
                    </ul>
                </li>
            @endif
            <li class="treeview {{ Route::currentRouteName() == 'cases.index' || Route::currentRouteName() == 'cases.fake' || Route::currentRouteName() == 'cases.trusted'?'active':'' }}">
                <a href="#">
                    <i class="fa fa-newspaper-o"></i> <span>Cases</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Route::currentRouteName() == 'cases.index'?'active':'' }}"><a href="{{ route('cases.index') }}"><i class="fa fa-newspaper-o"></i> <span>In-Analysis</span></a></li>
                    <li class="{{ Route::currentRouteName() == 'cases.fake'?'active':'' }}"><a href="{{ route('cases.fake') }}"><i class="fa fa-newspaper-o"></i> <span>Fake</span></a></li>
                    <li class="{{ Route::currentRouteName() == 'cases.trusted'?'active':'' }}"><a href="{{ route('cases.trusted') }}"><i class="fa fa-newspaper-o"></i> <span>Trusted</span></a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
