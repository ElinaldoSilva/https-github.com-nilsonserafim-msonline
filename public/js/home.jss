var capelas;
var capelas_livres;
var capela_uso;
var atualizar={{ ( Auth::user()->nivel==1) ? "false" : "true" }};
var verfica_capelas;

$(function()
{
    inicializa_tooltip();
    verifica_reservas();

    //  Transforma minusculo em maiúsculo
    //
    var inputs = $(".maiusculo");
    inputs.on("input", function (event) {
        event.target.value = (event.target.value).toUpperCase();
    });   

    $('#form_dados').submit(function(e) {
            e.preventDefault();
            fgravaSepultamento();
            return false;
    });

    //  verifica capelas disponíveis
    verfica_capelas = setInterval(fcapelas_livres, 10000);

});

function fsubmit() {
    $('#form_dados').submit();
}



//  ***************************************************************
//  Mostra a Marcações de Horários dos Sepultamentos já reservadas
//
function verifica_reservas()
{
    $.ajax(
    {
        type: "POST",
        url: '{{ route("age.horarios") }}',
        data: $("input[name='_token']").serialize(),
        success: function(ret) 
        {  
            retorno = JSON.parse(ret);

            if(retorno.qtdRegistros > 0) 
            {
                var _registros = retorno.registros;

                //  Percorre todos os registros do painel selecionados    
                //
                $.each(_registros, function(index, dados) 
                {
                    linha=$(".marcacoes_"+dados.data).first();
                    // Se for sepultamento Direto, tenta colocar na 3ª linnha, se não estiver ocupada
                    //
                    if ( (dados.capela).toUpperCase()=="DIRETO" &&
                          $(".marcacoes_"+dados['data']).last().find("td").eq(dados.inicio).hasClass('horario-liberado') &&
                          $(".marcacoes_"+dados['data']).last().find("td").eq(dados.fim).hasClass('horario-liberado') )
                    {
                        linha=$(".marcacoes_"+dados.data).last();
                    } else
                        if( linha.find("td").eq(dados.inicio).hasClass('horario-indisponivel') ||
                            linha.find("td").eq(dados.fim).hasClass('horario-indisponivel') )
                        {
                            linha=$(".marcacoes_"+dados.data).eq(1);
                            if( linha.find("td").eq(dados.inicio).hasClass('horario-indisponivel') || linha.find("td").eq(dados.fim).hasClass('horario-indisponivel') )
                            {
                                swal.fire("Falha estrutural no Agendamento", "Horário indisponível para sepultamento!!<br>" +dados.data.substr(8,2)+"/"+dados.data.substr(5,2)+"/"+dados.data.substr(0,4)+ " de " + 
                                dados.hs_inicio + " a " + dados.hs_fim, "error");
                            }
                        }

                    for(i=dados.inicio; i<=dados.fim; i++) 
                    {
                        $(linha).find("td").eq(i)
                            .removeClass("horario-liberado")
                            .addClass("horario-indisponivel c-default")
                            .attr("title", "Falecido:\n"+dados.falecido+"\nSepultamento: "+dados.capela+" de " + 
                                dados.hs_inicio + " às " + dados.hs_fim+"\nFuneraria: " +dados.funeraria);
                        _msg = ".s"+$(linha).find("td").eq(i).data("hora");
                        nome_fal = ((dados.falecido).length > 16) ? (dados.falecido).substr(0,20)+"..." : dados.falecido;
                        if(dados.alteravel=="1") {
                            //  Habilita botão de deletar se for agendamento do mesmo corretor e até 1 hora antes do sepultamento
                            $(linha).find("td").eq(i).addClass("bg-reserva");
                            $(_msg).html("<span class='close' data-url='"+'{{ url("/age/delete") }}' + "/" + dados.painelId + "'>x</span><span>"+dados['capela']+"<br>"+nome_fal.toUpperCase()+"</span>");
                        } else {
                            $(_msg).html("<span>"+dados['capela']+"<br>"+nome_fal.toUpperCase()+"</span>");
                        }
                        if(dados.cod_capela!="DIRETO") {
                            $(linha).find("td").eq(i)
                            .attr("data-capela", dados.cod_capela)
                        }
                    }
                });


                // Bloqueia horarios anteriores ao dia e hora atual
                //
                if(retorno.hora_inicial > 0) 
                {    
                    linha=$(".marcacoes_"+retorno.data_atual);
                    // Se for sepultamento Direto, tenta colocar na 3ª linnha, se não estiver ocupada
                    //
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

                //  Percorre as linhas para agrupar os horários por sepultamento
                // 
                var titulo="";
                var contador;
                var celula_inicial;

                $(".aj01.horario-indisponivel").each(function(i, e)
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
                            $(this).remove();
                        }
                    }
                });
                $(celula_inicial).attr("colspan", contador);

                controle_reservas();
                
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

    //  Botão de Cancelamento de reserva (até 1 hora antes do sepultamento)
    //
    $('.close').click(function(event) 
    {
        event.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            text: "Deseja excluir o Agendamento ?",
            icon: 'question',
            confirmButtonColor: '#008000',
            cancelButtonColor: '#d33',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
            reverseButtons: false,
            footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
        }).then((result) => {
            if (result.value) {

                url=$(this).data("url");
                $request=$("input[name='_token']").serialize();

                $.ajax(
                {
                    type: "GET",
                    url: url,
                    data: $request,
                    success: function(ret) 
                    {  
                        window.location.href="home";
                    },
                    error: function(ret) 
                    {
                        swal.fire ({
                            icon: 'error', 
                            text: 'Erro ao acessar os Horarios reservados',
                            footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
                        })
                    }
                });

            } else {
                swal.fire ({
                    icon: 'error', 
                    text: 'Exclusão Cancelada',
                    footer: '<img src= "{{ asset('img/logo2.png') }}" style="width: 80px;">'
                })
                return false;
            }
        })

    });


    //  Lança agendamentos no grid da tela
    //
    $(".horario-liberado, .reservar-horario").click(function(e)
    {
        //  Se não for direto, não aceita marcar horario na 3ª linha (exclusiva para DIRETO)
        if ( $("input[name='tipo_sepultamento']:checked").val()=='1' && ($(this).hasClass('C') || $(this).hasClass('F')) ) {
            return false;
        }

        horario_selecionado_index = $( this ).index();
        horario_selecionado = $( this );

        horario_anterior = $( this ).prev();
        tipo = $(this).data("hora").substr(5, 1);

        //  encontra o indice do limite do primeiro periodo
        index_primeiro_periodo = $(this).parent().find("[data-hora=1300-"+tipo+"]").index() - 1;

        if( horario_selecionado_index < index_primeiro_periodo ) {
            ini_horario=0;
        } else {
            ini_horario=index_primeiro_periodo+1;
        }


        if( $(this).hasClass( "reservar-horario" ) ) 
        {
            //  Desmarcar horário reservado
            //
            $(this).removeClass("reservar-horario").addClass("horario-liberado");
            _msg = ".s"+$(this).data("hora");
            $(_msg).empty();

        } else {
            //  Marcar horário para reservar
            //
            $(this).removeClass("horario-liberado").addClass("reservar-horario");
            _msg = ".s"+$(this).data("hora");
            if($("input[name='tipo_sepultamento']:checked").val()=='1') 
            {
                $(_msg).text("Reservar");
            } else {
                $(_msg).text("DIRETO");
            }

            //  Limpar 2ª marcação e outro dia de sepultamento
            //
            _elementos=".G, .A.reservar-horario, .B.reservar-horario, .C.reservar-horario, .D.reservar-horario, .E.reservar-horario, .F.reservar-horario";
            _limpar = _elementos.replace(", ."+tipo+".reservar-horario","");
            $(_limpar).each(function(i,e)
            {
                if( $(e).hasClass( "reservar-horario" )) 
                {
                    $(e).removeClass("reservar-horario").addClass("horario-liberado");
                    _msg = ".s"+$(e).data("hora");
                    $(_msg).empty();
                }
            });
        }

        fcapelas_livres();

        //  Verifica se pulou um horário
        //
        if( (horario_selecionado_index > (ini_horario + 1)) && ($(horario_anterior).hasClass( "horario-liberado" ) || $(horario_anterior).hasClass( "horario-indisponivel")) )
        {

            limite = horario_selecionado_index - 1;
            $("."+tipo).each(function(i, e)
            {
                //  Limpa horários anteriores
                if(i < limite && $(e).hasClass( "reservar-horario" )) 
                {
                    $(e).removeClass("reservar-horario").addClass("horario-liberado");
                    _msg = ".s"+$(e).data("hora");
                    $(_msg).empty();
                }
                //  Limpa horários posteriores
                if(i > horario_selecionado_index && $(e).hasClass( "reservar-horario" ) &&
                    ($(horario_selecionado).next().hasClass( "horario-liberado" ) || $(horario_selecionado).next().hasClass( "horario-indisponivel")) ) 
                {
                    $(e).removeClass("reservar-horario").addClass("horario-liberado");
                    _msg = ".s"+$(e).data("hora");
                    $(_msg).empty();
                }

            });
        } else {

            //  Se tiver horario livre após o horario reservado, limpa todo o restante dos horários
            //
            if(horario_selecionado_index >=  ini_horario && (
                ( $(horario_selecionado).hasClass( "horario-liberado" ) && $(horario_selecionado).prev().hasClass( "reservar-horario" ) ) ||
                 $(horario_selecionado).next().hasClass("horario-liberado") ) )
            {
                $("."+tipo).each(function(i, e)
                {
                    if( i > (horario_selecionado_index) && $( e ).hasClass( "reservar-horario" ) ) 
                    {
                        $(e).removeClass("reservar-horario").addClass("horario-liberado");
                        _msg = ".s"+$(e).data("hora");
                        $(_msg).empty();
                    }
                });
            }
        }

        $("."+tipo).each(function(i, e)
        {
            //  Se reserva de horario for antes ou após intervalor, limpa a outra metade do dia
            //
            if( ((ini_horario == 0 && i > index_primeiro_periodo) || (ini_horario == (index_primeiro_periodo+1) && i < index_primeiro_periodo)) && $( this ).hasClass( "reservar-horario" )) 
            {
                $(this).removeClass("reservar-horario").addClass("horario-liberado");
                _msg = ".s"+$(this).data("hora");
                $(_msg).empty();
            }
        });

        inicio_marcacao=false;
        apagar_restante=false;
        $("."+tipo).each(function(i, e)
        {
            //  Se reserva de horario for antes ou após intervalor, limpa a outra metade do dia
            //
            if( !inicio_marcacao && $( this ).hasClass("reservar-horario")) {
                inicio_marcacao=true;
            } else {
                if( inicio_marcacao && ($(this).hasClass("horario-liberado") || $( this ).hasClass("horario-indisponivel"))) {
                    apagar_restante=true;
                }

                if( apagar_restante) 
                {
                    if( $(this).hasClass("reservar-horario") ) {
                        $(this).removeClass("reservar-horario").addClass("horario-liberado");
                        _msg = ".s"+$(this).data("hora");
                        $(_msg).empty();
                    }
                }
            }
        });

    });

}


//   Verifica as capelas que estão disponiveis para uso
//
function fcapelas_livres()
{
    capelas={ A:0, B:0, C:0, D:0, E:0, F:0, G:0, H:0, I:0, J:0 };
    capelas_livres=["C", "D", "E", "F", "G", "H", "I", "J"];

    if($(".reservar-horario").length == 0) 
    {
        if ({{ Auth::user()->nivel }} == 9 ) {
            $("#capela_sepultamento").html("<option selected value='0'>Automática</option>");
        }
        return false;
    }

    elemento=$(".reservar-horario").parent().parent();
    $(elemento).find("td[data-capela]").each(function(i, e)
    {
        // Marca as capelas q estão usadas
        capelas[$(this).data("capela")]=1;
        capelas_livres.splice(capelas_livres.indexOf($(this).data("capela")), 1);
    });

    //  Se todas as capelas estiverem ocupadas utiliza a "A" e "B"
    if(capelas_livres.length==0) {
        if(capelas.A=="0") {
            capela_uso="A";
        } else 
        if(capelas.B=="0") {
            capela_uso="B";
        } else {
            swal.fire("", "Não há Capelas disponiveis para este dia", "error" );
            return false;
        }
    } else
    if( $("#capela_sepultamento").val()=="0" || {{ Auth::user()->nivel }} == 9 ) {
        capela_uso=capelas_livres[0];

        if(atualizar) 
        {
            $("#capela_sepultamento").html("<option selected value=" + capela_uso + ">" + capela_uso + "</option>");
        } else
        if ({{ Auth::user()->nivel }} == 1 ) {
            $("#capela_sepultamento").val(capela_uso);
        }
    }

}


//  *************************************
//  Grava a Marcações do Sepultamento
//
function fgravaSepultamento()
{
    //  Prepara dados dos horarios reservados
    //
    var horario_inicio='';
    var horario_fim='';
    var dataSep="";

    $(".reservar-horario").each(function(i, e)
    {
        if(horario_inicio=="") {
            horario_inicio=$(this).data("hora");
            dataSep=$(this).parent().data("date");
        }
        horario_fim=$(this).data("hora");
    });
    
    //  Checkin dos dados
    if(horario_inicio=="") {
        swal.fire("", "Selecione os horários do Agendamento", "error" );
        return false;
    }
    horario_inicio=horario_inicio.substr(0,2)+":"+horario_inicio.substr(2,2);
    horario_fim=horario_fim.substr(0,2)+":"+horario_fim.substr(2,2);

    $request="ope=c&id=&data="+dataSep+"&inicio="+horario_inicio+"&fim="+horario_fim+"&"+$("#form_dados").serialize();
    
    $.ajax(
    {
        type: "POST",
        url: '{{ route("age.grava_sepultamento") }}',
        data: $request,
        success: function(ret) 
        {  

            retorno = JSON.parse(ret);
            if (retorno.status==0) {
                swal.fire("", "Sepultamento agendado com sucesso", "success" );
                window.location.href="home";

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

