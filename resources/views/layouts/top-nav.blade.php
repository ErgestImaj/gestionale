<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="#"><img src="{{asset('images/logo.jpg')}}" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="#"><img src="{{asset('images/collapsed-logo.jpg')}}" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler toggleefect align-self-center" type="button" data-toggle="minimize">
            <span class="fas fa-bars"></span>
        </button>

        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item dropdown d-none d-lg-flex">
                <div class="nav-link">
                    <span class="dropdown-toggle btn btn-outline-dark" id="languageDropdown" data-toggle="dropdown">Nuovo Sessione</span>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                        <a class="dropdown-item font-weight-medium" href="#">
                            French
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#">
                            Espanol
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#">
                            Latin
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#">
                            Arabic
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown d-none d-lg-flex">
                <div class="nav-link">
                    <span class="dropdown-toggle btn btn-outline-dark" id="languageDropdown" data-toggle="dropdown">Nuovo Utente</span>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                        <a class="dropdown-item font-weight-medium" href="#">
                            Admin
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#">
                           Studente
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#">
                            Latin
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item font-weight-medium" href="#">
                            Arabic
                        </a>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                    <i class="fas fa-bell mx-0"></i>
                    <span class="count">16</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                    <a class="dropdown-item">
                        <p class="mb-0 font-weight-normal float-left">You have 16 new notifications
                        </p>
                        <span class="badge badge-pill badge-warning float-right">View all</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-danger">
                                <i class="fas fa-exclamation-circle mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-medium">Application Error</h6>
                            <p class="font-weight-light small-text">
                                Just now
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-warning">
                                <i class="fas fa-wrench mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-medium">Settings</h6>
                            <p class="font-weight-light small-text">
                                Private message
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-info">
                                <i class="far fa-envelope mx-0"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <h6 class="preview-subject font-weight-medium">New user registration</h6>
                            <p class="font-weight-light small-text">
                                2 days ago
                            </p>
                        </div>
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-envelope mx-0"></i>
                    <span class="count">25</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                    <div class="dropdown-item">
                        <p class="mb-0 font-weight-normal float-left">You have 7 unread mails
                        </p>
                        <span class="badge badge-info badge-pill float-right">View all</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="{{asset('images/logo.png')}}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-medium">David Grey
                                <span class="float-right font-weight-light small-text">1 Minutes ago</span>
                            </h6>
                            <p class="font-weight-light small-text">
                                The meeting is cancelled
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="{{asset('images/logo.png')}}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-medium">Tim Cook
                                <span class="float-right font-weight-light small-text">15 Minutes ago</span>
                            </h6>
                            <p class="font-weight-light small-text">
                                New product launch
                            </p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item">
                        <div class="preview-thumbnail">
                            <img src="{{asset('images/logo.png')}}" alt="image" class="profile-pic">
                        </div>
                        <div class="preview-item-content flex-grow">
                            <h6 class="preview-subject ellipsis font-weight-medium"> Johnson
                                <span class="float-right font-weight-light small-text">18 Minutes ago</span>
                            </h6>
                            <p class="font-weight-light small-text">
                                Upcoming board meeting
                            </p>
                        </div>
                    </a>
                </div>
            </li>

            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <img src="{{auth()->user()->avatar_url}}" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="/profile">
                        <i class="fas fa-user text-primary"></i>{{trans('menu.profile')}}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off text-primary"></i>
                        {{ trans('menu.logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right mobile-menu d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="fas fa-bars"></span>
        </button>
    </div>
</nav>
