@extends('layouts.app')

@section('content')
	<div class="authback">
		<div class="g-row">
			<div class="auth-left"></div>
			<div class="auth-right gpad">
				<div class="brand-logo">
					<img src="{{asset('images/logo.jpg')}}" alt="logo">
				</div>
				<div class="auth-form-light text-left p-5">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
		                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
