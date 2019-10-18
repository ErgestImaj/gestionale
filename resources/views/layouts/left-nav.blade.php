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
                <i class="fas fa-user-tie menu-icon"></i>
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
        <li class="nav-item @if(Request::is('amministrazione/course*'))active @endif">
            <a class="nav-link" data-toggle="collapse" href="#course" aria-expanded="false" aria-controls="course">
                <i class="fas fa-book-open menu-icon"></i>
                <span class="menu-title">{{trans('menu.course')}}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="course">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="#">{{trans('form.add_course')}}</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="#">{{trans('menu.course')}}</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('admin.categories')}}">{{trans('menu.category')}}</a></li>
                </ul>
            </div>
        </li>
        @hasrole('superadmin')
        <li class="nav-item @if(Request::is('amministrazione/settings*'))active @endif">
            <a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
                <i class="fas fa-tools  menu-icon"></i>
                <span class="menu-title">{{trans('menu.settings')}}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="settings">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('superadmin.permission')}}">{{trans('menu.permission')}}</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('superadmin.email')}}">{{trans('menu.email_settings')}}</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('superadmin.payment')}}">{{trans('menu.payment_settings')}}</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('superadmin.iva')}}">{{trans('menu.iva')}}</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('superadmin.maintenance')}}">{{trans('menu.maintenance')}}</a></li>
                </ul>
            </div>
        </li>
        @endhasrole
    </ul>
</nav>
