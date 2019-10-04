@extends('layouts.auth')

@section('auth')
        <div class="auth-form-light text-left p-5">
            <div class="brand-logo">
                <img src="{{asset('images/logo.jpg')}}" alt="logo">
            </div>
            <h4>Elearning, Corsi di Formazione</h4>
            <h6 class="font-weight-light">Inserisci le credenziali di accesso.</h6>
            <form class="pt-3" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">

                    <input id="login" type="login"  placeholder="Username" class="form-control  form-control-lg {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" name="login" value="{{ old('username') ?: old('email') }}" required autocomplete="email" autofocus>
                    @if ($errors->has('username') || $errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                            </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="password" type="password" placeholder="Password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Accedi</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check form-check-flat form-check-primary">
                            <label class="form-check-label">
                                <input name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} class="form-check-input">
                                 Salva credenziali
                                <i class="input-helper">

                                </i></label>
                        </div>
                    @if (Route::has('password.request'))
                         <a href="{{ route('password.request') }}" class="auth-link text-black">Hai dimenticato la password?</a>
                    @endif
                </div>
            </form>
        </div>
@endsection
