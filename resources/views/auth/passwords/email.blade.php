@extends('templates.template_login')

@section('content')
<div class="container container-700">
    <div class="row justify-content-center mt-md-4">
        <div class="col-md-11">
            <div class="card shadow">
                <div class="card-header text-center title">{{ __('REDEFINIÇÃO DE SENHA') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row mt-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <br>
                        
                        <div class="form-group row my-3">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enviar link de redefinição de senha') }}
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
