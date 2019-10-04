<div class="col-xl-4 order-xl-2 mb-3">
    <div class="card card-profile">
        <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image text-center">
                    <a href="#">
                        <img src="{{$user->avatar_url}}" class="img-lg rounded-circle my-3">
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center">
            <h5 class="h3">{{$user->full_name}}</h5>
        </div>
        <div class="card-body pt-0">
            <div>
                <p class="clearfix">
                    <span class="float-left">Username</span>
                    <span class="float-right text-muted">{{$user->username}}</span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Mail</span>
                    <span class="float-right text-muted">{{$user->email}}</span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Last Login</span>
                    <span class="float-right text-muted">{{diffForHumans($user->last_login)}}</span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Status</span>
                    <span class="float-right text-muted">
                                       @if($user->state)
                            <span class="badge badge-pill badge-success ml-auto px-1 py-1"><i class="fas fa-check font-weight-bold"></i></span>
                        @else
                            <span class="badge badge-pill badge-danger ml-auto px-1 py-1"><i class="fas fa-times font-weight-bold"></i></span>
                        @endif
                                    </span>
                </p>
                <p class="clearfix">
                    <span class="float-left">Last Login IP</span>
                    <span class="float-right text-muted"> {{$user->last_login_ip}}</span>
                </p>
            </div>
        </div>
    </div>
</div>
