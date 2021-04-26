@extends('templates.template_login')

@section('title')Cemitério do Catumbi @endsection

@section('style')
    .login-wrap {
        width: 330px;
        margin: 0 auto;
    }
    @media (max-width: 591px) 
    {
        .login-wrap 
        {   width: 92%;   }
    }
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="login-wrap mt-md-3">
            <div class="card shadow">
                <div class="card-header text-center title">{{ __('LOGIN') }}</div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-12 col-form-label">{{ __('E-Mail') }}</label>

                            <div class="col">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-12 col-form-label">{{ __('Senha') }}</label>

                            <div class="col-10">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label mt-1" for="remember">
                                        {{ __('Relembrar') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-auto">

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link btn-sm p-1" style="color:#7f1b18;" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu sua senha?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-1 mt-4 justify-content-center">
                            <div class="col-auto" style="width: 88%;">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Entrar') }}
                                </button>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
