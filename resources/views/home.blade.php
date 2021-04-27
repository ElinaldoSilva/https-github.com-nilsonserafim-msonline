@extends('templates.template_bs5')

@section('title') Home @endsection

@section('head')
    
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <!--    <link href="{ { asset('js/home.js') }}" rel="stylesheet">    -->

@endsection

@section('style')
@endsection

@section('content')
    <div class="container-fluid px-md-4 pb-4">
        <div class="row m-0 w-100">
            <div class="mt-1 w-100">
                <div class="text-center bold ft-22 c-azul mb-1">{{ __('MARCAÇÃO ON-LINE DE SEPULTAMENTOS') }}</div>
            </div>
        </div>
        <div class="mt-0" style="position: fixed;z-index: 999999; right: 20px; top: 138px; box-shadow: 0 0px 20px 5px #eee6e6;">
            <button type="button" onclick="fsubmit()" style="min-width:90px !important;" class="btn btn-primary ft-13">
                <i class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;{{ __('Gravar') }}
            </button>
        </div>

        <br>

        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        <br><br>
        @endif

        @if(isset($errors) && count($errors)>0)
        <div class="text-center mt-4 mb-4 p-2 alert-danger">
            @foreach($errors->all() as $erro)
                {{$erro}}<br>
            @endforeach
        </div>
        @endif

        <!--     Coleta dos Dados do Sepultamento  
        -->
        <div class="card row pt-3 pb-1 px-2 shadow m-auto container-1000">

          <form id="form_dados">
            @csrf
            <div class="row was-validated">
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text py-0" for="falecido">Falecido</span>
                        <input type="text" class="form-control w-xl-100 maiusculo" required maxlength="100" name="falecido" id="falecido" aria-describedby="falecidoFeedback"> 
                        <div class="invalid-feedback" id="falecidoFeedback" >Preencha o nome do Falecido</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text py-0" for="declaracao_obito">Declaração de Óbito</span>
                        <input type="text" class="form-control w-xl-100" required maxlength="15" name="declaracao_obito" id="declaracao_obito" aria-describedby="declaracaoFeedback"> 
                        <div class="invalid-feedback" id="declaracaoFeedback" >Informe o número da Declaração de Óbito</div>                
                    </div>
                </div>
            </div>

            <div class="row was-validated">
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-sm mb-2">
                        <span class="input-group-text py-0" for="munic_falecimento">Munic.Falecimento</span>
                        <input type="text" class="form-control w-xl-100 maiusculo" required maxlength="20" name="munic_falecimento" id="munic_falecimento" aria-describedby="municipioFeedback"> 
                        <div class="invalid-feedback" id="municipioFeedback" >Informe o município do Falecimento</div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-sm mb-2 maxw-400">
                        <span class="input-group-text py-0 minw-145" for="local_falecimento">Local Falecimento</span>
                        <input type="text" class="form-control w-xl-100 maiusculo" required maxlength="50" name="local_falecimento" id="local_falecimento" aria-describedby="localFeedback"> 
                        <div class="invalid-feedback" id="localFeedback" >Informe o Local do Falecimento</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 ">
                    <div class="input-group input-group-sm mb-2 st-01 d-xs-block">
                      <span class="input-group-text py-0 mr-3" for="tipo_urna">Tipo de Urna</span>
                      <div class="form-control d-contents" >
                        <div class="custom-control custom-radio ms-xs-2">
                            <input type="radio" class="custom-control-input" checked id="urna_magra" name="tipo_urna" value="MAGRA">
                            <label class="custom-control-label c-padrao" for="urna_magra">Padrão</label>
                        </div>
                        <div class="custom-control custom-radio ms-xs-2" style="min-width: 64px;">
                            <input type="radio" class="custom-control-input" id="urna_anjo" name="tipo_urna" value="ANJO" >
                            <label class="custom-control-label c-padrao" for="urna_anjo">Anjo</label>
                        </div>
                        <div class="custom-control custom-radio mb-1 ms-xs-2">
                            <input type="radio" class="custom-control-input" id="urna_gorda" name="tipo_urna" value="GORDA" >
                            <label class="custom-control-label c-padrao" for="urna_gorda">Gorda</label>
                        </div>
                        <div class="custom-control custom-radio mb-1 ms-xs-2">
                            <input type="radio" class="custom-control-input" id="urna_supergorda" name="tipo_urna" value="SUPER GORDA">
                            <label class="custom-control-label c-padrao" for="urna_supergorda">Super Gorda</label>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-sm mb-2 st-01 d-xs-block">
                      <span class="input-group-text py-0 mr-2 minw-145">Destinação</span>
                      <div class="form-control d-contents" >
                        <div class="custom-control custom-radio mx-2">
                            <input type="radio" class="custom-control-input" checked id="gaveta" name="servico" value="2" onchange="mostra_quadroSep(this.value)">
                            <label class="custom-control-label" for="gaveta">Gaveta</label>
                        </div>
                        <div class="custom-control custom-radio mx-2">
                            <input type="radio" class="custom-control-input" id="jazigo" name="servico" value="1" onchange="mostra_quadroSep(this.value)">
                            <label class="custom-control-label" for="jazigo">Jaz.Perpétuo</label>
                        </div>
                        <div class="custom-control custom-radio mx-2 mb-1">
                            <input type="radio" class="custom-control-input" id="cremacao" name="servico" value="3" onchange="mostra_quadroSep(this.value)">
                            <label class="custom-control-label" for="cremacao">Cremação</label>
                        </div>
                      </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="input-group input-group-sm mb-3" style="max-width: 200px">
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="capela_sepultamento">Capela</label>
                        </div>
                        <select class="custom-select " id="capela_sepultamento" name="capela_sepultamento">
                          <option value="0" selected>Automática</option>
                          @if ( Auth::user()->nivel==1 )
                            @foreach($regCapelas as $capela)
                                <option value="{{$capela->Nome}}">{{$capela->Nome}}</option>
                            @endforeach
                          @endif
                        </select>
                    </div>
                </div>

                <div id="quadro_sepultura" class="col-12 col-md-6" style="display: none;">
                    <div class="input-group input-group-sm mb-2 me-2" style="width: max-content;">
                        <span class="input-group-text py-0 ft-12" style="height: 29px;" for="quadro">Quadro</span>
                        <input type="text" class="form-control" maxlength="40" name="quadro" id="quadro"> 
                    </div>
                    <div class="input-group input-group-sm mb-2" style="width: max-content;">
                        <span class="input-group-text py-0 ft-12"  style="height: 29px;" for="sepultura">Sepultura</span>
                        <input type="text" class="form-control" maxlength="40" name="sepultura" id="sepultura"> 
                    </div>
                </div>

                <div class="col-12 col-md-6 ">
                    <div class="input-group input-group-sm mb-2 st-01 d-xs-block maxw-400">
                      <span class="input-group-text py-0 mr-2 minw-145" for="tipo_sepultamento">Tipo Sepultamento</span>
                      <div class="form-control d-contents" >
                        <div class="custom-control custom-radio mx-2">
                            <input type="radio" class="custom-control-input" onchange="verifica_reservas()" checked id="capela" name="tipo_sepultamento" value="1">
                            <label class="custom-control-label" for="capela">Capela</label>
                        </div>
                        <div class="custom-control custom-radio mx-2 mb-1">
                            <input type="radio" class="custom-control-input" onchange="verifica_reservas()" id="direto" name="tipo_sepultamento" value="2" >
                            <label class="custom-control-label" for="direto">Direto</label>
                        </div>
                      </div>
                    </div>
                </div>

            @if ( Auth::user()->nivel==9 )
                <input type="hidden" name="corretor" value="{{ Auth::user()->corretorId }}">      
            @else
                <div class="col-12 col-md-5">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="corretor">Corretor</label>
                        </div>
                        <select class="custom-select" id="corretor" name="corretor">
                        @foreach($regCorretores as $corretor)
                            <option @php echo ((Auth::user()->corretorId == $corretor->corretorId) ? "selected" : "") @endphp value="{{$corretor->corretorId}}">{{$corretor->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
            @endif
    
            </div>

          </form>

        </div>
        <br>

        <div class="card mt-3" style="{{ (date('H') > '18' &&  Auth::user()->nivel==9)  ? 'display:none' : ''  }}">

            <div class="card-header text-center bold ft-22 c-azul">{{ date('d/m/Y') }}</div>

            {{--     Mostra Tabela de Horarios disponiveis aos Corretores     --}}
            <div class="wrapper1">
                <div class="div-1">
                </div>
            </div>
            <div id="scroll" class="table-responsive wrapper2">
                <table id="tab-1" class="table table-bordered border-dark mb-0" style="border-bottom: 3px solid;">
                  <thead class="table-dark">
                    <tr>
                        <th ></th>
                        <th >10:00</th>
                        <th >10:15</th>
                        <th >10:30</th>
                        <th >10:45</th>
                        <th >11:00</th>
                        <th >11:15</th>
                        <th >11:30</th>
                        <th class="aj02">11:31-12:59</th>
                        <th >13:00</th>
                        <th >13:15</th>
                        <th >13:30</th>
                        <th >13:45</th>
                        <th >14:00</th>
                        <th >14:15</th>
                        <th >14:30</th>
                        <th >14:45</th>
                        <th >15:00</th>
                        <th >15:15</th>
                        <th >15:30</th>
                        <th >15:45</th>
                        <th >16:00</th>
                        <th >16:15</th>
                        <th >16:30</th>
                    </tr>
                  </thead>
                    
                  <tbody>
        
                    <tr class="agendamentos agendamentos_{{ date('Y-m-d') }}" data-date="{{ date('Y-m-d') }}">
                        <td></td>
                        <td class="aj01 horario-liberado td1000" data-hora="1000" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1000"></span></td>
                        <td class="aj01 horario-liberado td1015" data-hora="1015" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1015"></span></td>
                        <td class="aj01 horario-liberado td1030" data-hora="1030" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1030"></span></td>
                        <td class="aj01 horario-liberado td1045" data-hora="1045" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1045"></span></td>
                        <td class="aj01 horario-liberado td1100" data-hora="1100" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1100"></span></td>
                        <td class="aj01 horario-liberado td1115" data-hora="1115" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1115"></span></td>
                        <td class="aj01 horario-liberado td1130" data-hora="1130" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1130"></span></td>
                        <td class="aj03 horario-indisponivel"><span class="aj04 bold">{{ __('INTERVALO') }}</span></td>
                        <td class="aj01 horario-liberado td1300" data-hora="1300" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1300"></span></td>
                        <td class="aj01 horario-liberado td1315" data-hora="1315" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1315"></span></td>
                        <td class="aj01 horario-liberado td1330" data-hora="1330" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1330"></span></td>
                        <td class="aj01 horario-liberado td1345" data-hora="1345" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1345"></span></td>
                        <td class="aj01 horario-liberado td1400" data-hora="1400" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1400"></span></td>
                        <td class="aj01 horario-liberado td1415" data-hora="1415" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1415"></span></td>
                        <td class="aj01 horario-liberado td1430" data-hora="1430" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1430"></span></td>
                        <td class="aj01 horario-liberado td1445" data-hora="1445" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1445"></span></td>
                        <td class="aj01 horario-liberado td1500" data-hora="1500" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1500"></span></td>
                        <td class="aj01 horario-liberado td1515" data-hora="1515" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1515"></span></td>
                        <td class="aj01 horario-liberado td1530" data-hora="1530" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1530"></span></td>
                        <td class="aj01 horario-liberado td1545" data-hora="1545" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1545"></span></td>
                        <td class="aj01 horario-liberado td1600" data-hora="1600" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1600"></span></td>
                        <td class="aj01 horario-liberado td1615" data-hora="1615" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1615"></span></td>
                        <td class="aj01 horario-liberado td1630" data-hora="1630" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1630"></span></td>
                    </tr>

                    {{--     Mostra Tabela de Horarios e Capelas aos Administradores     --}}
                    @if ( Auth::user()->nivel==1 )
                    <tr><td colspan="24" style="background: black; height: 5px; margin: 2px 0 !important;  padding: 0 !important;"></td></tr>
                    @foreach($regCapelas as $capela)
                    <tr class="marcacoes marcacoes_{{ date('Y-m-d') }} capela-{{ $capela->Nome }}" data-date="{{ date('Y-m-d') }}">
                        <td class="aj05">{{ $capela->Nome }}</td>
                        <td class="aj10 horario-liberado td1000-{{ $capela->Nome }}" data-hora="1000-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1000-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1015-{{ $capela->Nome }}" data-hora="1015-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1015-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1030-{{ $capela->Nome }}" data-hora="1030-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1030-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1045-{{ $capela->Nome }}" data-hora="1045-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1045-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1100-{{ $capela->Nome }}" data-hora="1100-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1100-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1115-{{ $capela->Nome }}" data-hora="1115-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1115-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1130-{{ $capela->Nome }}" data-hora="1130-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1130-{{ $capela->Nome }}"></span></td>   
                        <td class="aj10 horario-liberado td1145-{{ $capela->Nome }}" data-hora="1145-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1145-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1300-{{ $capela->Nome }}" data-hora="1300-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1300-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1315-{{ $capela->Nome }}" data-hora="1315-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1315-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1330-{{ $capela->Nome }}" data-hora="1330-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1330-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1345-{{ $capela->Nome }}" data-hora="1345-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1345-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1400-{{ $capela->Nome }}" data-hora="1400-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1400-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1415-{{ $capela->Nome }}" data-hora="1415-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1415-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1430-{{ $capela->Nome }}" data-hora="1430-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1430-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1445-{{ $capela->Nome }}" data-hora="1445-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1445-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1500-{{ $capela->Nome }}" data-hora="1500-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1500-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1515-{{ $capela->Nome }}" data-hora="1515-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1515-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1530-{{ $capela->Nome }}" data-hora="1530-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1530-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1545-{{ $capela->Nome }}" data-hora="1545-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1545-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1600-{{ $capela->Nome }}" data-hora="1600-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1600-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1615-{{ $capela->Nome }}" data-hora="1615-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1615-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1630-{{ $capela->Nome }}" data-hora="1630-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1630-{{ $capela->Nome }}"></span></td>
                        </tr>
                    @endforeach
                    <tr class="marcacoes marcacoes_{{ date('Y-m-d') }} direto" data-date="{{ date('Y-m-d') }}">
                        <td class="aj06">DIRETO</td>
                        <td class="aj10 horario-liberado td1000-DIR s-direto" data-="1000-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1000-DIR"></span></td>
                        <td class="aj10 horario-liberado td1015-DIR s-direto" data-="1015-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1015-DIR"></span></td>
                        <td class="aj10 horario-liberado td1030-DIR s-direto" data-="1030-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1030-DIR"></span></td>
                        <td class="aj10 horario-liberado td1045-DIR s-direto" data-="1045-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1045-DIR"></span></td>
                        <td class="aj10 horario-liberado td1100-DIR s-direto" data-="1100-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1100-DIR"></span></td>
                        <td class="aj10 horario-liberado td1115-DIR s-direto" data-="1115-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1115-DIR"></span></td>
                        <td class="aj10 horario-liberado td1130-DIR s-direto" data-="1130-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1130-DIR"></span></td>   
                        <td class="aj10 horario-liberado td1145-DIR s-direto" data-="1145-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1145-DIR"></span></td>   
                        <td class="aj10 horario-liberado td1300-DIR s-direto" data-="1300-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1300-DIR"></span></td>
                        <td class="aj10 horario-liberado td1315-DIR s-direto" data-="1315-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1315-DIR"></span></td>
                        <td class="aj10 horario-liberado td1330-DIR s-direto" data-="1330-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1330-DIR"></span></td>
                        <td class="aj10 horario-liberado td1345-DIR s-direto" data-="1345-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1345-DIR"></span></td>
                        <td class="aj10 horario-liberado td1400-DIR s-direto" data-="1400-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1400-DIR"></span></td>
                        <td class="aj10 horario-liberado td1415-DIR s-direto" data-="1415-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1415-DIR"></span></td>
                        <td class="aj10 horario-liberado td1430-DIR s-direto" data-="1430-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1430-DIR"></span></td>
                        <td class="aj10 horario-liberado td1445-DIR s-direto" data-="1445-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1445-DIR"></span></td>
                        <td class="aj10 horario-liberado td1500-DIR s-direto" data-="1500-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1500-DIR"></span></td>
                        <td class="aj10 horario-liberado td1515-DIR s-direto" data-="1515-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1515-DIR"></span></td>
                        <td class="aj10 horario-liberado td1530-DIR s-direto" data-="1530-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1530-DIR"></span></td>
                        <td class="aj10 horario-liberado td1545-DIR s-direto" data-="1545-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1545-DIR"></span></td>
                        <td class="aj10 horario-liberado td1600-DIR s-direto" data-="1600-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1600-DIR"></span></td>
                        <td class="aj10 horario-liberado td1615-DIR s-direto" data-="1615-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1615-DIR"></span></td>
                        <td class="aj10 horario-liberado td1630-DIR s-direto" data-="1630-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1630-DIR"></span></td>
                    </tr>
                    @endif

                  </tbody>

                </table>
              <br>
            </div>

        </div>

        <br><br>

        <div class="card">
            @php
                $date = new DateTime();
                $date->add(new DateInterval('P1D'));
            @endphp
            <div class="card-header text-center bold ft-22 c-azul">{{ $date->format('d/m/Y') }}</div>

            <div class="wrapper3">
                <div class="div-2">
                </div>
            </div>
            <div class="table-responsive wrapper4">
                <table id="tab-2" class="table table-bordered border-dark mb-0" style="border-bottom: 3px solid;">
                  <thead class="table-dark">
                    <tr>
                        <th ></th>
                        <th >10:00</th>
                        <th >10:15</th>
                        <th >10:30</th>
                        <th >10:45</th>
                        <th >11:00</th>
                        <th >11:15</th>
                        <th >11:30</th>
                        <th class="aj02">11:31-12:59</th>
                        <th >13:00</th>
                        <th >13:15</th>
                        <th >13:30</th>
                        <th >13:45</th>
                        <th >14:00</th>
                        <th >14:15</th>
                        <th >14:30</th>
                        <th >14:45</th>
                        <th >15:00</th>
                        <th >15:15</th>
                        <th >15:30</th>
                        <th >15:45</th>
                        <th >16:00</th>
                        <th >16:15</th>
                        <th >16:30</th>
                        </tr>
                  </thead>

                  <tbody>
                    <tr class="agendamentos agendamentos_{{ $date->format('Y-m-d') }}" data-date="{{ $date->format('Y-m-d') }}">
                            <td></td>
                            <td class="aj01 horario-liberado td1000" data-hora="1000" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1000"></span></td>
                            <td class="aj01 horario-liberado td1015" data-hora="1015" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1015"></span></td>
                            <td class="aj01 horario-liberado td1030" data-hora="1030" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1030"></span></td>
                            <td class="aj01 horario-liberado td1045" data-hora="1045" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1045"></span></td>
                            <td class="aj01 horario-liberado td1100" data-hora="1100" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1100"></span></td>
                            <td class="aj01 horario-liberado td1115" data-hora="1115" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1115"></span></td>
                            <td class="aj01 horario-liberado td1130" data-hora="1130" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1130"></span></td>
                            <td class="aj03 horario-indisponivel"><span class="aj04 bold">{{ __('INTERVALO') }}</span></td>
                            <td class="aj01 horario-liberado td1300" data-hora="1300" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1300"></span></td>
                            <td class="aj01 horario-liberado td1315" data-hora="1315" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1315"></span></td>
                            <td class="aj01 horario-liberado td1330" data-hora="1330" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1330"></span></td>
                            <td class="aj01 horario-liberado td1345" data-hora="1345" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1345"></span></td>
                            <td class="aj01 horario-liberado td1400" data-hora="1400" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1400"></span></td>
                            <td class="aj01 horario-liberado td1415" data-hora="1415" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1415"></span></td>
                            <td class="aj01 horario-liberado td1430" data-hora="1430" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1430"></span></td>
                            <td class="aj01 horario-liberado td1445" data-hora="1445" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1445"></span></td>
                            <td class="aj01 horario-liberado td1500" data-hora="1500" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1500"></span></td>
                            <td class="aj01 horario-liberado td1515" data-hora="1515" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1515"></span></td>
                            <td class="aj01 horario-liberado td1530" data-hora="1530" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1530"></span></td>
                            <td class="aj01 horario-liberado td1545" data-hora="1545" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1545"></span></td>
                            <td class="aj01 horario-liberado td1600" data-hora="1600" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1600"></span></td>
                            <td class="aj01 horario-liberado td1615" data-hora="1615" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1615"></span></td>
                            <td class="aj01 horario-liberado td1630" data-hora="1630" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1630"></span></td>
                        </tr>


                        {{--     Mostra Tabela de Horarios e Capelas aos Administradores     --}}
                    @if ( Auth::user()->nivel==1 )
                    <tr><td colspan="24" style="background: black; height: 5px; margin: 2px 0 !important;  padding: 0 !important;"></td></tr>
                    @foreach($regCapelas as $capela)
                    <tr class="marcacoes marcacoes_{{ $date->format('Y-m-d') }} capela-{{ $capela->Nome }}" data-date="{{ $date->format('Y-m-d') }}">
                        <td class="aj05">{{ $capela->Nome }}</td>
                        <td class="aj10 horario-liberado td1000-{{ $capela->Nome }}" data-hora="1000-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1000-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1015-{{ $capela->Nome }}" data-hora="1015-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1015-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1030-{{ $capela->Nome }}" data-hora="1030-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1030-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1045-{{ $capela->Nome }}" data-hora="1045-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1045-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1100-{{ $capela->Nome }}" data-hora="1100-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1100-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1115-{{ $capela->Nome }}" data-hora="1115-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1115-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1130-{{ $capela->Nome }}" data-hora="1130-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1130-{{ $capela->Nome }}"></span></td>   
                        <td class="aj10 horario-liberado td1145-{{ $capela->Nome }}" data-hora="1145-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1145-{{ $capela->Nome }}"></span></td>   
                        <td class="aj10 horario-liberado td1300-{{ $capela->Nome }}" data-hora="1300-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1300-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1315-{{ $capela->Nome }}" data-hora="1315-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1315-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1330-{{ $capela->Nome }}" data-hora="1330-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1330-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1345-{{ $capela->Nome }}" data-hora="1345-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1345-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1400-{{ $capela->Nome }}" data-hora="1400-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1400-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1415-{{ $capela->Nome }}" data-hora="1415-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1415-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1430-{{ $capela->Nome }}" data-hora="1430-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1430-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1445-{{ $capela->Nome }}" data-hora="1445-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1445-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1500-{{ $capela->Nome }}" data-hora="1500-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1500-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1515-{{ $capela->Nome }}" data-hora="1515-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1515-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1530-{{ $capela->Nome }}" data-hora="1530-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1530-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1545-{{ $capela->Nome }}" data-hora="1545-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1545-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1600-{{ $capela->Nome }}" data-hora="1600-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1600-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1615-{{ $capela->Nome }}" data-hora="1615-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1615-{{ $capela->Nome }}"></span></td>
                        <td class="aj10 horario-liberado td1630-{{ $capela->Nome }}" data-hora="1630-{{ $capela->Nome }}" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1630-{{ $capela->Nome }}"></span></td>
                    </tr>
                    @endforeach
                    <tr class="marcacoes marcacoes_{{ $date->format('Y-m-d') }} direto" data-date="{{ $date->format('Y-m-d') }}">
                        <td class="aj06">DIRETO</td>
                        <td class="aj10 horario-liberado td1000-DIR s-direto" data-="1000-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1000-DIR"></span></td>
                        <td class="aj10 horario-liberado td1015-DIR s-direto" data-="1015-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1015-DIR"></span></td>
                        <td class="aj10 horario-liberado td1030-DIR s-direto" data-="1030-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1030-DIR"></span></td>
                        <td class="aj10 horario-liberado td1045-DIR s-direto" data-="1045-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1045-DIR"></span></td>
                        <td class="aj10 horario-liberado td1100-DIR s-direto" data-="1100-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1100-DIR"></span></td>
                        <td class="aj10 horario-liberado td1115-DIR s-direto" data-="1115-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1115-DIR"></span></td>
                        <td class="aj10 horario-liberado td1130-DIR s-direto" data-="1130-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1130-DIR"></span></td>   
                        <td class="aj10 horario-liberado td1145-DIR s-direto" data-="1145-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1145-DIR"></span></td>   
                        <td class="aj10 horario-liberado td1300-DIR s-direto" data-="1300-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1300-DIR"></span></td>
                        <td class="aj10 horario-liberado td1315-DIR s-direto" data-="1315-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1315-DIR"></span></td>
                        <td class="aj10 horario-liberado td1330-DIR s-direto" data-="1330-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1330-DIR"></span></td>
                        <td class="aj10 horario-liberado td1345-DIR s-direto" data-="1345-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1345-DIR"></span></td>
                        <td class="aj10 horario-liberado td1400-DIR s-direto" data-="1400-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1400-DIR"></span></td>
                        <td class="aj10 horario-liberado td1415-DIR s-direto" data-="1415-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1415-DIR"></span></td>
                        <td class="aj10 horario-liberado td1430-DIR s-direto" data-="1430-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1430-DIR"></span></td>
                        <td class="aj10 horario-liberado td1445-DIR s-direto" data-="1445-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1445-DIR"></span></td>
                        <td class="aj10 horario-liberado td1500-DIR s-direto" data-="1500-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1500-DIR"></span></td>
                        <td class="aj10 horario-liberado td1515-DIR s-direto" data-="1515-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1515-DIR"></span></td>
                        <td class="aj10 horario-liberado td1530-DIR s-direto" data-="1530-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1530-DIR"></span></td>
                        <td class="aj10 horario-liberado td1545-DIR s-direto" data-="1545-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1545-DIR"></span></td>
                        <td class="aj10 horario-liberado td1600-DIR s-direto" data-="1600-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1600-DIR"></span></td>
                        <td class="aj10 horario-liberado td1615-DIR s-direto" data-="1615-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1615-DIR"></span></td>
                        <td class="aj10 horario-liberado td1630-DIR s-direto" data-="1630-DIR" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top"><span class="s1630-DIR"></span></td>
                    </tr>
                    @endif
                  </tbody>
                </table>
            </div>
        </div>
        <br>
        
        @if ( count($regAgendamentos) > 0 )
          <br>
          <div class="card row pt-3 pb-1 px-2 shadow mx-auto my-4 container-800" style="zoom:0.88;">
            <div class="card-header text-center bold ft-22 c-azul">{{ __('AGENDAMENTOS') }}</div>
            <div class="table-responsive p-0">
                <table class="table">
                  <thead class="table-dark">
                    <tr>
                      <th scope="col">DATA</th>
                      <th scope="col">HORÁRIO</th>
                      <th scope="col">CAPELA</th>
                      <th scope="col" class="text-left aj12">FALECIDO</th>
                      @if ( Auth::user()->nivel==1 )
                        <th scope="col" class="text-left">FUNERARIA</th>
                        <th></th>
                      @endif
                    </tr>
                  </thead>
                  
                  <tbody id="rel_agendamentos">
                    @php
                        $age=$regAgendamentos[0]->DataSepultamento;
                        $date = new DateTime();
                    @endphp
                    
                    @foreach($regAgendamentos as $agendamento)
                      @php
                        if($date->format('Y-m-d')==$agendamento->DataSepultamento && $date->format('H') > 18 && Auth::user()->nivel==9) {
                          continue;
                        }
                      @endphp 
                      @if($age!=$agendamento->DataSepultamento)
                          <tr>
                            <td colspan="{{ ( Auth::user()->nivel==9 ? 4 : 6) }}" style="padding: 0 !important; height: 4px;"><hr style="height: 2px; margin: 0; opacity: 0.35;"></td>
                          <tr>
                      @endif
                      @php
                          $date=new DateTime($agendamento->DataSepultamento);
                          $age=$agendamento->DataSepultamento;
                      @endphp
                      <tr>
                        <td class="pad-01">{{ $date->format('d/m/Y') }}</td>
                        <td class="pad-01">{{ $agendamento->HorarioSepultamento }}</td>
                        <td class="pad-01">{{ $agendamento->Capela }}</td>
                        <td class="pad-01 text-left aj12">{{ $agendamento->Falecido }}</td>
                        @if ( Auth::user()->nivel==1)
                          <td class="pad-01 text-left">{{ $agendamento->NomeFuneraria }}</td>
                          <td>
                            <button title="Cancela a Marcação do Sepultamento" proto="{{ $agendamento->PainelId }}" data-toggle="tooltip" data-placement="top" class="btn btn-sm c-red apagar"><i class="fa fa-trash" aria-hidden="true"></i></button>
                          </td>
                        @endif
                        </tr>
                    @endforeach
                    
                  </tbody>
          
                </table>
          
            </div>
        </div>
        <br>
        @endif

    </div>
    <br>
@endsection

@section('script')
 // <script>

    var capelas;
    var capelas_livres;
    var capela_uso;
    var atualizar={{ ( Auth::user()->nivel==1) ? "false" : "true" }};
    var verfica_capelas;
    var capelas_ocupacao1;
    var capelas_ocupacao2;
    var dia_reserva=1;
    var avisar = true;
    var inicio = true;

    const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true
            });

    $(function()
    {

        $(".div-1").width("200");
        $(".div-2").width("200");
        $(".wrapper1").scroll(function(){
            $(".wrapper2").scrollLeft($(".wrapper1").scrollLeft());
        });
        $(".wrapper2").scroll(function(){
            $(".wrapper1").scrollLeft($(".wrapper2").scrollLeft());
        }); 
        $(".wrapper3").scroll(function(){
            $(".wrapper4").scrollLeft($(".wrapper3").scrollLeft());
        });
        $(".wrapper4").scroll(function(){
            $(".wrapper2").scrollLeft($(".wrapper4").scrollLeft());
        }); 

        inicializa_tooltip();
        verifica_reservas();

        //  Transforma minusculo em maisculo
        //
        var inputs = $(".maiusculo");
        inputs.on("input", function (event) {
            event.target.value = (event.target.value).toUpperCase();
        });   

        //  verica capelas disponiveis
        verfica_capelas = setInterval(function() {
            fcapelas_livres(dia_reserva);
        }, 8000);

    });



        //  Botão de Cancelamento do Sepultamento (até 1 hora antes do sepultamento)
        //
        $('.apagar').click(function(event) 
        {
            proto= $(this).attr("proto");
            event.preventDefault();

            swalWithBootstrapButtons.fire({
                html: "<h3>Confirma o Cancelamento do Agendamento</h3>",
                icon: 'question',
                confirmButtonColor: '#008000',
                cancelButtonColor: '#d33',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: false,
                footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
            }).then((result) => 
            {
              if (result.value) 
              {
                $request="proto="+proto+"&"+$("input[name='_token']").serialize();
                $.ajax(
                {
                    type: "GET",
                    url: '{{ route("age.delete") }}',
                    data: $request,
                    success:function(data)
                    {  
                        swal.fire ({
                            icon: 'success', 
                            html: '<h4>Agendamento do Sepultamento cancelado com Sucesso</h4>',
                            footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
                        }).then((result) => 
                        {
                            window.location.href="home";
                        });
                    },
                    error: function(ret) 
                    {
                        swal.fire ({
                            icon: 'error', 
                            text: 'Erro ao Cancelar o agendamento do Sepultamento',
                            footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
                        })
                    }
                });
              }
            })
        });


    {{--  //  Ajusta a barra de rolagem horizontal superior  --}}
          //
	document.body.onresize = function() 
	{
        ajusta_barra_rolagem();
    }
	document.getElementById("tab-1").onresize = function() 
	{
        ajusta_barra_rolagem();
    }
	document.getElementById("tab-2").onresize = function() 
	{
        ajusta_barra_rolagem();
    }


    function ajusta_barra_rolagem() 
    {
		  {{--  //  Ajusta a barra de rolagem horizontal superior  --}}
		  if( $("#tab-1").width() <= ($(".wrapper1").width()+1) ) {
			$(".div-1").width('200');
		  } else {
			$(".div-1").width($("#tab-1").width());
		  } 
		  if( $("#tab-2").width() <= ($(".wrapper1").width()+1) ) {
			$(".div-2").width('200');
		  } else {
			$(".div-2").width($("#tab-2").width());
		  } 

	};	


    function mostra_quadroSep(tipo)
    {
        if(tipo=="1") {
            $('#quadro_sepultura').css('display','inherit');
        } else {
            $('#quadro_sepultura').css('display','none');
        }					
    }

    function fsubmit() {
        fgravaSepultamento();
        return false;
    }



    //  ***************************************************************
    //  Mostra a Marcações de Horários dos Sepultamentos já reservadas
    //
    function verifica_reservas()
    {

        //  Limpa agendamentos
        $(".reservar-horario")
            .removeClass("reservar-horario")
            .find("span").html("");

        fcapelas_livres(dia_reserva);

        $.ajax(
        {
            type: "POST",
            url: '{{ route("age.horarios") }}',
            data: $("input[name='_token']").serialize(),
            success: function(ret) 
            {  
                retorno = JSON.parse(ret);

                //  Limpa agendamentos
                $(".agendamentos_"+retorno.data_atual+">.aj01.horario-indisponivel, .agendamentos_"+retorno.data2+">.aj01.horario-indisponivel, .reservar-horario")
                    .removeClass("horario-indisponivel")
                    .removeClass("reservar-horario")
                    .removeClass("c-default")
                    .addClass("horario-liberado")
                    .find("span").html("");

                $(".marcacoes>.aj10.horario-indisponivel, .reservar-horario")
                    .removeClass("horario-indisponivel")
                    .removeClass("reservar-horario")
                    .removeClass("c-default")
                    .addClass("horario-liberado")
                    .find("span").html("")
                    .attr("title", "")
                    .removeAttr("colspan");


                capelas_ocupacao1 = retorno.cap_ocupacao1;
                capelas_ocupacao2 = retorno.cap_ocupacao2;

                clearInterval;


                /* **************************************************************
                 *      Mostra agendamentos na Janela do Corretor
                 */
                var sepultamentos_capelas = retorno.sep_capelas_1;
                var sepultamentos_diretos = retorno.sep_diretos_1;
                var sepultamentos_detalhes = retorno.sep_detalhes_1;

                var tab_horarios=['10:00', '10:15', '10:30', '10:45', '11:00', '11:15', '11:30', '13:00', '13:15', '13:30', '13:45', 
                         '14:00', '14:15', '14:30', '14:45', '15:00', '15:15', '15:30', '15:45', '16:00', '16:15', '16:30'];
                
                //  Percorre os sepultamentos agendados
                //
                linha=$(".agendamentos_"+retorno.data_atual).first();

                $.each(sepultamentos_capelas, function(index, qtd_sepultamentos) 
                {
                    total_sepultamentos = qtd_sepultamentos+sepultamentos_diretos[index];
                    if( total_sepultamentos>2  || (qtd_sepultamentos>1 && $("input[name='tipo_sepultamento']:checked").val()=="1") ) {
                        $(linha).find(".td"+index.substr(0,2)+index.substr(3,2))
                            .removeClass("horario-liberado")
                            .addClass("horario-indisponivel c-default")
                            .attr("title", sepultamentos_detalhes[index])
                            .find("span").html("Horário<br>Indisponível");
                    }
                });

                {{--  verifica o primeiro horario disponivel nas capelas  --}}
                //
                prim_horario_livre="16:45";     
                $.each(capelas_ocupacao1, function(capela, horario_inicial) 
                {
                    if( horario_inicial < prim_horario_livre ) 
                    {
                        prim_horario_livre=horario_inicial;
                    }
                });

                {{-- //  Se todas as capelas estiverem ocupadas, marca como "Horários Indisponíveis"   --}}
                     //
                if( $("input[name='tipo_sepultamento']:checked").val()=="1") 
                {
                    $.each(tab_horarios, function(index, hora) 
                    {
                        if(!(hora > prim_horario_livre)) 
                        {
                        //          console.log("Prim:" + prim_horario_livre + " |  hora:"+hora);
                            $(linha).find(".td"+hora.substr(0,2)+hora.substr(3,2))
                            .removeClass("horario-liberado")
                            .addClass("horario-indisponivel c-default")
                            .find("span").html("Capelas<br>Indisponíveis<br>( só Direto )");
                        };
                    })
                }

                var sepultamentos_capelas = retorno.sep_capelas_2;
                var sepultamentos_diretos = retorno.sep_diretos_2;
                var sepultamentos_detalhes = retorno.sep_detalhes_2;

                {{--  //  Percorre os sepultamentos agendados       --}}
                      //
                linha=$(".agendamentos_"+retorno.data2).first();

                $.each(sepultamentos_capelas, function(index, qtd_sepultamentos)
                {
                    total_sepultamentos = qtd_sepultamentos+sepultamentos_diretos[index];
                    if( total_sepultamentos>2  || (qtd_sepultamentos>1 && $("input[name='tipo_sepultamento']:checked").val()=="1") ) {
                        $(linha).find(".td"+index.substr(0,2)+index.substr(3,2))
                            .removeClass("horario-liberado")
                            .addClass("horario-indisponivel c-default")
                            .attr("title", sepultamentos_detalhes[index])
                            .find("span").html("Horário<br>Indisponível");
                    }
                });

                {{--  //  verifica o primeiro horario disponivel nas capelas  --}}
                      //
                prim_horario_livre="16:45";     
                $.each(capelas_ocupacao2, function(capela, horario_inicial) 
                {
                    if( horario_inicial < prim_horario_livre ) 
                    {
                        prim_horario_livre=horario_inicial;
                    }
                });

                {{--  //  Se todas as capelas estiverem ocupadas, marca como "Horários Indisponíveis"   --}}
                      //
                if( $("input[name='tipo_sepultamento']:checked").val()=="1") 
                {
                    $.each(tab_horarios, function(index, hora) 
                    {
                        if(!(hora > prim_horario_livre)) 
                        {
                            $(linha).find(".td"+hora.substr(0,2)+hora.substr(3,2))
                            .removeClass("horario-liberado")
                            .addClass("horario-indisponivel c-default")
                            .find("span").html("Horário<br>Indisponível");
                        };
                    })
                }


                {{-- Bloqueia horarios anteriores ao dia e hora atual   --}}
                //
                linha=$(".agendamentos_"+retorno.data_atual);
                $(linha).each(function(index, event)
                {
                    horario = $(event).find('td');
                    for(i=0; i<=retorno.hora_inicial; i++) 
                    {
                        if( horario.eq(i).hasClass('horario-liberado') )
                        {
                            horario.eq(i).removeClass("horario-liberado").addClass("horario-indisponivel c-default bg-bloq");
                        }
                    }
                });

                {{-- //            Fim da Janela dos Corretores                        --}}
                {{-- // ************************************************************** --}}

                <?php
                //  Só mostra e executa esta parte do código se for administrador
                //
                if (Auth::user()->nivel==1) {
                ?>
                    
                var _registros = retorno.registros;

                {{-- //  Percorre todos os registros do painel selecionados    --}}
                     //
                $.each(_registros, function(index, dados)
                {
                    var data = (dados.data).substr(8,2)+"/"+(dados.data).substr(5,2)+"/"+(dados.data).substr(0,4);

                    nome_fal = ((dados.falecido).length > 25) ? (dados.falecido).substr(0, 25)+"..." : dados.falecido;
                    nome_fun = ((dados.funeraria).length > 25) ? "Fun: "+(dados.funeraria).substr(0, 25)+"..." : "Funerária: "+dados.funeraria;

                    if(dados.destinacao=="3")  {
                        destinacao = "Cremação" ;
                    } else if(dados.destinacao=="1")   {
                        destinacao = "Sepult. Jazigo Perpétuo"; 
                    } else {
                        destinacao = "Sepult. Gaveta"; 
                    }


                    if ( (dados.capela).toUpperCase()=="DIRETO")
                    {
                        linha=$(".marcacoes_"+dados.data+".direto");
                        msg = ".s"+$(linha).find("td").eq(dados.fim).data("hora");
                        conteudo = $(linha).find("td").eq(dados.fim).find("span").html();
                        titulo =   $(linha).find("td").eq(dados.fim).attr("title");
                        if (conteudo.length>4) {
                            conteudo += "<br>——————————————<br>" + nome_fal+"<br>"+nome_fun;
                            titulo += "\n——————————————————\n"+dados.falecido+"\n"+destinacao+": "+data+", "+dados.capela+" às " +
                                dados.hr_sepultamento+"\nFuneraria: " +dados.funeraria+"\nCorretor: " +dados.corretor;
                        } else {
                            conteudo = nome_fal + "<br>" + nome_fun;
                            titulo = dados.falecido+"\n"+destinacao+": "+data+", "+dados.capela+" às " +
                                dados.hr_sepultamento+"\nFuneraria: " +dados.funeraria+"\nCorretor: " +dados.corretor;
                        }
                        $(linha).find("td").eq(dados.fim)
                            .removeClass("horario-liberado")
                            .addClass("horario-indisponivel c-default")
                            .prop("proto", dados.protocolo)
                            .attr("title", titulo)
                            .find("span").html(conteudo);

                    } else {
                        if(dados.dt_inicio != dados.data) {
                            linha=$(".marcacoes_"+dados.dt_inicio+".capela-"+dados.cod_capela);
                            for (let i = dados.inicio; i <= 23; i++) {
                                if( $(linha).find("td").eq(i).hasClass("horario-liberado") ) {
                                    _msg = ".s"+$(linha).find("td").eq(i).data("hora");
                                    $(linha).find("td").eq(i)
                                        .removeClass("horario-liberado")
                                        .addClass("horario-indisponivel c-default bg-gray")
                                        .attr("title", dados.falecido+"\n"+destinacao+": "+data+", "+dados.capela+" às " + 
                                            dados.hr_sepultamento+"\nFuneraria: " +dados.funeraria+"\nCorretor: "+dados.corretor)
                                        .find("span").html(nome_fal.toUpperCase()+"<br>Funerária: "+dados.funeraria);
                                }
                            }
                            dados.inicio=1;
                        }
 
                        linha=$(".marcacoes_"+dados.data+".capela-"+dados.cod_capela);
                        for (let i = dados.inicio; i <= dados.fim; i++) {
                            if( $(linha).find("td").eq(i).hasClass("horario-liberado") ) {
                                _msg = ".s"+$(linha).find("td").eq(i).data("hora");
                                $(linha).find("td").eq(i)
                                    .removeClass("horario-liberado")
                                    .addClass("horario-indisponivel c-default")
                                    .attr("proto", dados.protocolo)
                                    .attr("title", dados.falecido+"\n"+destinacao+": "+data+", "+dados.capela+" às " + 
                                        dados.hr_sepultamento+"\nFuneraria: " +dados.funeraria+"\nCorretor: "+dados.corretor)
                                    .find("span").html(nome_fal.toUpperCase()+"<br>"+nome_fun);
                            }
                        }
                    }
                });


                {{--  // Bloqueia horarios anteriores ao dia e hora atual  --}}
                      //
                if(retorno.hora_inicial > 0) 
                {    
                    linha=$(".agendamentos_"+retorno.data_atual);

                    $(linha).each(function(index, event)
                    {
                        horario = $(event).find('td');
                        for(i=0; i<retorno.hora_inicial; i++) 
                        {
                            if( horario.eq(i).hasClass('horario-liberado') )
                            {
                                horario.eq(i).removeClass("horario-liberado").addClass("horario-indisponivel c-default bg-bloq");
                            }
                        }
                    });
                };

                {{-- //  Percorre as linhas para agrupar os horários por sepultamento  --}}
                     // 
                var titulo="";
                var contador;
                var celula_inicial;

                $(".marcacoes_"+retorno.data_atual + " > .aj10.horario-indisponivel").each(function(i, e)
                {
                    if(titulo!=$(this).attr("title")) {
                        //  Mescla as células do mesmo sepultamento
                        if(titulo!="") {
                            $(celula_inicial).attr("colspan", contador);
                        }
                        titulo=$(this).attr("title");
                        contador=1;
                        celula_inicial = $(this);
                    } else {
                        if(!$(this).hasClass('bg-bloq')) 
                        {
                            contador++;
                            $(this).addClass("d-none");
                        }
                    }
                });
                if(contador > 1) {
                    $(celula_inicial).attr("colspan", contador);
                }

                titulo="";
                contador;
                celula_inicial;

                $(".marcacoes_"+retorno.data2 + " > .aj10.horario-indisponivel").each(function(i, e)
                {
                    if(titulo!=$(this).attr("title")) {
                        //  Mescla as células do mesmo sepultamento
                        if(titulo!="") {
                            $(celula_inicial).attr("colspan", contador);
                        }
                        titulo=$(this).attr("title");
                        contador=1;
                        celula_inicial = $(this);
                    } else {
                        if(!$(this).hasClass('bg-bloq')) 
                        {
                            contador++;
                            $(this).addClass("d-none");
                        }
                    }
                });
                if(contador > 1) {
                    $(celula_inicial).attr("colspan", contador);
                }


                {{--  //    Bloqueia 15 minutos de limpesa das capelas    --}}
                      //
                linha=$(".marcacoes");

                $(linha).find('td').each(function(index, event)
                {
                    if( $(this).hasClass('horario-indisponivel') && !$(this).hasClass('s-direto') ) {
                        elemento=$(this).next().first();
                        if( $(elemento).hasClass('horario-liberado') ) {
                            $(elemento).removeClass("horario-liberado").addClass("horario-bloqueado c-default bg-red");
                        }
                    }
                });

              <?php  } 
              //         *************  Fim do trecho que só abre para o Administrador   **************
              ?>

              controle_reservas();
                
              {{--  //  Ajusta a barra de rolagem horizontal superior  --}}
              ajusta_barra_rolagem();

              $date=new Date();
              if( $date.hora() > '13:00' && inicio) { 
                var $target = $('.wrapper2');
                $target.scrollLeft($target.outerWidth() + 20);
                inicio=false;
              } 

            },
            error: function(ret) 
            {
                console.log(ret);
                swal.fire("", "Erro ao acessar os Horarios reservados", "error");
            }
        });
    } 


    function controle_reservas() 
    {
        //  **********************************************************
        //  Controla a Marcação de Horários dos Sepultamentos
        //

        $(".horario-liberado, .reservar-horario").unbind( "click" );


        {{--  //  Imprimir Aviso de Porta das Capelas     --}}
              //

        @if ( Auth::user()->nivel==1 )

          $(".marcacoes>.horario-indisponivel").click(function(e)
          {
            if($(this).hasClass('s-direto'))
            {
                return false;
            }
            proto = $(this).attr("proto");  
            dados = $(this).attr("title").replace(/(?:\r\n|\r|\n)/g, '<br>');

            swalWithBootstrapButtons.fire({
                title: "Aviso para porta da Capela ",
                html: "<br>Falecido:" + dados + "<br><br><h2><strong>Imprimir o Aviso ?</strong></h2><br>",
                icon: 'question',
                cancelButtonColor: '#d33',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                reverseButtons: false,
                footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
            }).then((result) => {
                if (result.value) {
                    alert 
                    window.open('aviso/' + proto ,'_blank'); 
                } 
            })
            return true;
          });

        @endif


        {{--  //  Lança agendamentos no grid da tela      --}}
              //
        $(".agendamentos>.horario-liberado, .agendamentos>.reservar-horario").click(function(e)
        {
            if( $(this).hasClass( "reservar-horario" ) ) 
            {
                //  Desmarcar horário reservado
                //
                $(this).removeClass("reservar-horario").addClass("horario-liberado");
                _msg = ".s"+$(this).data("hora");
                $(this).find(_msg).empty();
                dia_reserva=1;

            } else {
  
                avisar = true;

                //  Remove marcação anterior
                $(".agendamentos>td.reservar-horario>span").not( ".aj04" ).empty();
                $(".agendamentos>td.reservar-horario").removeClass("reservar-horario").addClass("horario-liberado");

                //  Marca horário para reservar
                _msg = ".s"+$(this).data("hora");
                $(this).removeClass("horario-liberado").addClass("reservar-horario");
                if($("input[name='tipo_sepultamento']:checked").val()=='1') 
                {
                    $(this).find(_msg).text("Reservar");
                } else {
                    $(this).find(_msg).text("Direto");
                }
            }
            now = new Date();
            data = ($(this).parent().data("date")==now.dateToString()) ? '1' : '2';
            dia_reserva = data;
            //  hora= $(this).data("hora").substr(0,2); + ":" + $(this).data("hora").substr(2,2);

            fcapelas_livres(data, $(this));

        });

    }


    //   Verifica as capelas que estão disponiveis para uso
    //
    function fcapelas_livres(data, elemento="")
    {
        if($("input[name='tipo_sepultamento']:checked").val()=='2') 
        {
            if ({{ Auth::user()->nivel }} == 9 ) {
                $("#capela_sepultamento").empty().html("<option selected value='0'>DIRETO</option>");
            } else {
                $("#capela_sepultamento").val(0);
            }
            return true;
        }

        capelas={ A:0, B:0, C:0, D:0, E:0, F:0, G:0, H:0, I:0, J:0 };
        capelas_livres=["C", "D", "E", "F", "G", "H", "I", "J"];
        if($(".reservar-horario").length == 0) 
        {
            if ({{ Auth::user()->nivel }} == 9 ) {
                $("#capela_sepultamento").html("<option selected value='0'>Automática</option>");
            }
            return false;
        }

        if(data==1) {
            array = capelas_ocupacao1;
        } else {
            array = capelas_ocupacao2;
        }

        /*  Verifica se tem Capelas totalmente livres 
            a partir da Capela C, se não tiver usa a A e B    */
        _capela="";

        var hora="";

        if(elemento) {
            hora = elemento.data("hora") + " ";
            hora= hora.substring(0, 2) + ":" + hora.substring(2, 2);
        }

        var primeiro_horario_livre="1635";
        $.each(array, function(index, horario) {
            if( horario=="" ) {
                _capela = index; 
                if(index>="C" ) {
                    return false;
                }
            } else
            if( horario<primeiro_horario_livre ) {
                primeiro_horario_livre=horario;
                primeiro_horario_livre_capela = index; 
                if(index>="C" ) {
                    return false;
                }
            }
        });

        if(!_capela && primeiro_horario_livre > "16:30" && avisar) 
        {
                swal.fire("", "Não há Capelas disponiveis para este dia<br>Contacte o Cemitério", "error" );
                $(elemento).removeClass("reservar-horario").addClass("horario-liberado");
                _msg = ".s"+$(elemento).data("hora");
                $(elemento).find(_msg).empty();
                avisar = false;
                return false;
            
        } else {
            if(!_capela && avisar) {
                _capela = primeiro_horario_livre_capela;
                avisar = false;
                swal.fire("", "Capela <strong>"+_capela+"</strong>  só estará liberada a partir das <strong>"+primeiro_horario_livre+"</strong>", "info" );
            }
            if(atualizar) 
            {
                $("#capela_sepultamento").html("<option selected value=" + _capela + ">" + _capela + "</option>");
            } else
            if ( {{ Auth::user()->nivel }} == 1 && $("#capela_sepultamento").val()=="0" ) 
            {
                $("#capela_sepultamento").val(_capela);
            }
        }

    }


    //  *************************************
    //  Grava a Marcações do Sepultamento
    //
    function fgravaSepultamento()
    {
        //  Verificação de dados preenchidos
        //
        let erros="";
        if( $("#falecido").val().length<6 )  {
            erros +="Nome do Falecido<br>";
        }       
        if( $("#declaracao_obito").val().length<3 )  {
            erros +="Número da Declaração de Óbito<br>";
        }       
        if( $("#munic_falecimento").val().length<2 )  {
            erros +="Município do Falecimento<br>";
        }       
        if( $("#local_falecimento").val().length<2 )  {
            erros +="Local do Falecimento<br>";
        }       
        if( $(".reservar-horario").length==0 )  {
            erros +="Horário do Sepultamento<br>";
        }       
        if( ($("#quadro").val().length==0 || $("#sepultura").val().length==0 ) && $("input[name='servico']:checked").val()=="1")  {
            erros +="Informe o Quadro e Sepultura do Jazigo Perpétuo<br>";
        } 

        if(erros.length > 1) 
        {
            swal.fire (
            {
                icon: 'warning',
                title: 'Preencha os seguintes campos:',
                html: erros,
                footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
            })
            return false;
        }

        //  Prepara dados dos horarios reservados
        //
        var horario_inicio='';
        var horario_fim='';
        $date=new Date();

        $(".reservar-horario").each(function(i, e)
        {
            horario_fim=$(this).parent().data("date") + " " + $(this).attr("data-hora").substr(0,2) + ":" + $(this).attr("data-hora").substr(2,2)+":00";
        });

        dataHorario_inicio = $date.datetimeToString();
        horario_inicio= $date.hora();

        if(dia_reserva==1) {
            _array = capelas_ocupacao1;
            $date = $date.data1();
        } else {
            _array = capelas_ocupacao2;
            $date = $date.data2();
        }


        /*  Verifica se o horário da Capela esta livre   */
        //
        capela= $("#capela_sepultamento").val();


        if(capela>'0' && _array[capela]) 
        {
            d = $date + " " + array[capela]+':00';
            dataHorario_ultSepultamento = new Date(d);
            dataHorario_ultSepultamento.setMinutes(dataHorario_ultSepultamento.getMinutes() + 30);
            horario_ultSepultamento= dataHorario_ultSepultamento.hora();

            d=new Date(dataHorario_inicio);

            if(d < dataHorario_ultSepultamento)
            {
                dataHorario_inicio = dataHorario_ultSepultamento.datetimeToString();

                //  Janela para confirmação do agendamento 
                //
                swalWithBootstrapButtons.fire({
                    title: "Capela "+capela+"  só estará liberada a partir das "+horario_ultSepultamento,
                    html: "<br>Deseja continuar o agendamento?<br>",
                    icon: 'info',
                    confirmButtonColor: '#008000',
                    cancelButtonColor: '#d33',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    reverseButtons: false,
                    footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
                }).then((result) => {
                    if (result.value) {
                        grava_Sepultamento(dataHorario_inicio, horario_fim);
                    }
                })
                return true;
            }
        } else 
        if($("input[name='tipo_sepultamento']:checked").val()=='2') 
        {
            dataHorario_inicio = horario_fim;
        }    
        grava_Sepultamento(dataHorario_inicio, horario_fim);
    }


    function grava_Sepultamento(horario_inicio, horario_fim)
    {

        request="ope=c&entrada="+horario_inicio+"&sep="+horario_fim+"&"+$("#form_dados").serialize();

        $.ajax(
        {
            type: "POST",
            url: '{{ route("age.grava_sepultamento") }}',
            data: request,
            success: function(ret) 
            {
                retorno = JSON.parse(ret);

                let texto = '<div style="border: 1px solid;padding:26px 12px; text-align:left; font-size:16px;"><span style="line-height: 1.1;">Falecido:<strong> ' + $("#falecido").val() + '</strong><br><br>' +
                            retorno.horario + "<br><br><center><strong>" + retorno.capela + "</strong></center><br>Protocolo:<strong> " + retorno.protocolo + "</strong><br><br></span></div>" ;

                if (retorno.status==1) {

                    swal.fire(
                    {
                        title: "Sepultamento agendado com sucesso",
                        html: texto,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonText: 'Continuar',
                        reverseButtons: false,
                        width: '34em',
                        footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
                    }).then((result) => {
                        window.location.href="home";
                    })
    
                } else {
                    swal.fire ({
                        icon: 'error', 
                        text: 'Erro ao cadastrar o agendamento',
                        footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
                    })
                }
            },
            error: function(ret) 
            {
                console.log(ret);
                swal.fire ({
                    icon: 'error', 
                    text: 'Erro ao cadastrar o agendamento',
                    footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
                })
            }
        });
    } 


    function muda_tipo(tipo) 
    {
        //  1=Capela,  2=Direto
        //

        controle_agendamentos();

        return true;

        if(tipo=='1') {
            $(".direto").addClass('c-not');
        } else {
            $(".direto").removeClass('c-not');
        }
        //  Limpar todas as marcações
        //
        _elementos=".A.reservar-horario, .B.reservar-horario, .C.reservar-horario, .D.reservar-horario, .E.reservar-horario, .F.reservar-horario";
        $(_elementos).each(function(i,e)
        {
            if( $(e).hasClass( "reservar-horario" )) 
            {
                $(e).removeClass("reservar-horario").addClass("horario-liberado");
                _msg = ".s"+$(e).data("hora");
                $(_msg).empty();
            }
        });
    }

    function inicializa_tooltip() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    }

@endsection

