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
            <a class="nav-link" href="{{route('superadmin.home')}}">
                <i class="fa fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item @if(Request::is('amministrazione/admins*'))active @endif">
            <a class="nav-link" data-toggle="collapse" href="#employers" aria-expanded="false" aria-controls="employers">
                <i class="fas fa-user-tie menu-icon menu-icon"></i>
                <span class="menu-title">Employers</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="employers">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('superadmin.admins.index')}}">Admin</a></li>
                    <li class="nav-item"> <a class="nav-link" href="pages/layout/rtl-layout.html">RTL</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="pages/layout/horizontal-menu.html">Horizontal Menu</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
