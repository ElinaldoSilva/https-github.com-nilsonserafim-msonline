@extends('templates.template_bs5')

@section('title') Corretores @endsection

@section('content')
<div class="container container-800">
    <div class="row justify-content-center mt-md-4">
        <div class="col-md-11">
            <div class="card shadow">
                <div class="card-header text-center title ft-20 bold">{{ __('CADASTRO DE CORRETORES') }}
                @if(isset($corretor)) <h4 class="text-center" style="color:#f1a951; margin-bottom: 0;">Atualização</h4>@endif
                </div>    

                <div class="card-body ">
                  @if(isset($corretor))
                    <form method="post" action="{{ url('corretor/' . $corretor->id)}}">
                        @method('PUT')
                  @else
                    <form method="POST" action="{{ route('register') }}">
                  @endif
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Nome') }}</label>

                            <div class="col-md-8">
                                <input id="name" type="text" maxlength="100" class="form-control maiusculo @error('name') is-invalid @enderror" name="name" value="{{ $corretor->name ?? '' }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nivel" class="col-md-3 col-form-label text-md-right">{{ __('Funerária') }}</label>

                            <div class="col-md-8">
                                <select class="custom-select " id="funerariaId" name="funerariaId">
                                    @if(!isset($corretor)) 
                                        <option selected value="0">selecione o funerária...</option>
                                    @endif    
                                    @foreach($funerarias as $funeraria)
                                        <option {{ (isset($corretor) && $funeraria->FunerariaId==$corretor->funerariaId) ? "selected" : '' }} value="{{ $funeraria->FunerariaId}}">{{strtoupper($funeraria->Nome)}}</option>
                                    @endforeach
           
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required  value="{{ $corretor->email ?? '' }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nivel" class="col-md-3 col-form-label text-md-right">{{ __('Nível') }}</label>

                            <div class="col-md-8">
                                <select class="custom-select " id="nivel" name="nivel">
                                    <option value="1" {{ (isset($corretor) && $corretor->nivel==1) ? "selected" : '' }}>Administrador</option>
                                    <option value="9" {{ ((isset($corretor) && $corretor->nivel==9) || !isset($corretor) ) ? "selected" : '' }}>Corretor</option>
                                </select>
                            </div>
                        </div>

                      @if(isset($corretor))
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Status') }}</label>
                            <div class="form-control d-contents" >
                                <div class="custom-control custom-radio ml-3 my-1">
                                    <input type="radio" class="custom-control-input" {{ ( ($corretor->status!=0) ? "checked" : "") }} id="ativo" name="status" value="1" >
                                    <label class="custom-control-label p-0 px-1" for="ativo">Ativo</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 my-1">
                                    <input type="radio" class="custom-control-input" {{ ( ($corretor->status==0) ? "checked" : "") }} id="desativado" name="status" value="2">
                                    <label class="custom-control-label p-0 px-1" for="desativado">Desativado</label>
                                </div>
                            </div>
                        </div>
                      @else  
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password"  name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label text-md-right">{{ __('Confirme a Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                      @endif

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @if(isset($corretor)) {{ __('Atualizar') }} @else {{ __('Registrar') }} @endif
                                </button>
                            </div>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</div>

@endsection


@section('script')
 // <script>
    //  Transforma minusculo em maisculo
    //
    var inputs = $(".maiusculo");
    inputs.on("input", function (event) {
        event.target.value = (event.target.value).toUpperCase();
    });   

@endsection
