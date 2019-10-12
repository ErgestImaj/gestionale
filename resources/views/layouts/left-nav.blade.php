<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    <img src="{{auth()->user()->avatar_url}}" alt="image"/>
                </div>
                <div class="profile-name">
                    <p class="name">
                        {{auth()->user()->lastname}}
                    </p>
                    <p class="designation">
                        {{auth()->user()->userRole()}}
                    </p>
                </div>
            </div>
        </li>
        <li class="nav-item @if(Request::is('amministrazione/dashboard'))active @endif">
            <a class="nav-link" href="{{route('admin.home')}}">
                <i class="fa fa-home menu-icon"></i>
                <span class="menu-title">{{trans('menu.dashboard')}}</span>
            </a>
        </li>
        <li class="nav-item @if(Request::is('amministrazione/admins*'))active @endif">
            <a class="nav-link" data-toggle="collapse" href="#employers" aria-expanded="false" aria-controls="employers">
                <i class="fas fa-user-tie menu-icon menu-icon"></i>
                <span class="menu-title">{{trans('menu.mf_users')}}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="employers">
                <ul class="nav flex-column sub-menu">
                    @hasrole('superadmin')
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('superadmin.admins.index')}}">{{trans('menu.admin')}}</a></li>
                    @endhasrole
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('admin.segreteria.index')}}">{{trans('menu.segreteria')}}</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
