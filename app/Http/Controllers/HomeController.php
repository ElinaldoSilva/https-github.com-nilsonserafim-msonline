<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DateInterval;

use App\Models\paineis_novo;
use App\Models\funerariasModel;
use App\Models\capelasModel;
use App\Models\User;

use Auth;
use Helper;

class HomeController extends Controller
{

    private $objPainel;
    private $objCapelas;
    private $objFunerarias;
    

    public function __construct()
    {
        //  Só entra na pagina se estiver logado
        //
        $this->middleware('auth');

        $this->objPainel = new paineis_novo();
        $this->objCapelas = new capelasModel();
        $this->objFunerarias = new funerariasModel();
    }


    /**
     * Mostra a Pagina Inicial
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date = new DateTime();
        $date->add(new DateInterval('P1D'));

        $regCapelas=$this->objCapelas->all()->Where("Liberada", "1")->sortBy('Nome');
        if(Auth::user()->nivel==1 ) {
          $regAgendamentos = paineis_novo::whereBetween('DataSepultamento', [date('Y-m-d'), $date->format('Y-m-d')])->orderBy("DataSepultamento")->orderBy("HorarioSepultamento")->get();
        } else {  
          $regAgendamentos = paineis_novo::where('CorretorId', Auth()->user()->corretorId)->whereBetween('DataSepultamento', [date('Y-m-d'), $date->format('Y-m-d')])->orderBy("DataSepultamento")->orderBy("HorarioSepultamento")->get();
        }
        $regCorretores = User::where('status', 1)->orderBy("name")->get();

        return view('home',compact('regCapelas', 'regAgendamentos', 'regCorretores'));

    }



    //   Carrega os Horários agendados no Banco de Dados
    //
    public function horarios() 
    {
        $now = new DateTime();
        $date= new DateTime();
        $date_ant= new DateTime();
        $date->add(new DateInterval('P1D'));
        $date_ant->sub(new DateInterval('P1D'));

        $regPainel = paineis_novo::whereBetween('DataSepultamento', [date('Y-m-d'), $date->format('Y-m-d')])->orderBy("DataSepultamento")->orderBy("HorarioSepultamento")->get();

        $tab_horarios = array('10:00'=>0, '10:15'=>1, '10:30'=>2, '10:45'=>3, '11:00'=>4,'11:15'=>5, "11:30"=>6, "11:45"=>7, "12:00"=>7, "12:15"=>7, 
                    "12:30"=>7,"12:45"=>7, '13:00'=>8, '13:15'=>9, '13:30'=>10, '13:45'=>11, '14:00'=>12,'14:15'=>13, '14:30'=>14, '14:45'=>15,
                    '15:00'=>16, '15:15'=>17, '15:30'=>18, '15:45'=>19, '16:00'=>20,'16:15'=>21, '16:30'=>22);

        $capela_ocupacao1 = array( "A"=>"", "B"=>"", "C"=>"", "D"=>"", "E"=>"", "F"=>"", "G"=>"", "H"=>"", "I"=>"", "J"=>"" );
        $capela_ocupacao2 = array( "A"=>"", "B"=>"", "C"=>"", "D"=>"", "E"=>"", "F"=>"", "G"=>"", "H"=>"", "I"=>"", "J"=>"" );
                    
        $sepultamentos_capelas_1 = array(
            '10:00'=>0, '10:15'=>0, '10:30'=>0, '10:45'=>0, '11:00'=>0, '11:15'=>0, '11:30'=>0,
            '13:00'=>0, '13:15'=>0, '13:30'=>0, '13:45'=>0, '14:00'=>0, '14:15'=>0, '14:30'=>0, '14:45'=>0,
            '15:00'=>0, '15:15'=>0, '15:30'=>0, '15:45'=>0, '16:00'=>0, '16:15'=>0, '16:30'=>0);
        $sepultamentos_diretos_1 = array(
            '10:00'=>0, '10:15'=>0, '10:30'=>0, '10:45'=>0, '11:00'=>0, '11:15'=>0, '11:30'=>0, 
            '13:00'=>0, '13:15'=>0, '13:30'=>0, '13:45'=>0, '14:00'=>0, '14:15'=>0, '14:30'=>0, '14:45'=>0,
            '15:00'=>0, '15:15'=>0, '15:30'=>0, '15:45'=>0, '16:00'=>0, '16:15'=>0, '16:30'=>0);
        $sepultamentos_detalhes_1 = array(
            '10:00'=>"", '10:15'=>"", '10:30'=>"", '10:45'=>"", '11:00'=>"", '11:15'=>"", '11:30'=>"",
            '13:00'=>"", '13:15'=>"", '13:30'=>"", '13:45'=>"", '14:00'=>"", '14:15'=>"", '14:30'=>"", '14:45'=>"",
            '15:00'=>"", '15:15'=>"", '15:30'=>"", '15:45'=>"", '16:00'=>"", '16:15'=>"", '16:30'=>"");

        $sepultamentos_capelas_2 = array(
            '10:00'=>0, '10:15'=>0, '10:30'=>0, '10:45'=>0, '11:00'=>0, '11:15'=>0, '11:30'=>0,
            '13:00'=>0, '13:15'=>0, '13:30'=>0, '13:45'=>0, '14:00'=>0, '14:15'=>0, '14:30'=>0, '14:45'=>0,
            '15:00'=>0, '15:15'=>0, '15:30'=>0, '15:45'=>0, '16:00'=>0, '16:15'=>0, '16:30'=>0);
        $sepultamentos_diretos_2 = array(
            '10:00'=>0, '10:15'=>0, '10:30'=>0, '10:45'=>0, '11:00'=>0, '11:15'=>0, '11:30'=>0,
            '13:00'=>0, '13:15'=>0, '13:30'=>0, '13:45'=>0, '14:00'=>0, '14:15'=>0, '14:30'=>0, '14:45'=>0,
            '15:00'=>0, '15:15'=>0, '15:30'=>0, '15:45'=>0, '16:00'=>0, '16:15'=>0, '16:30'=>0);
        $sepultamentos_detalhes_2 = array(
            '10:00'=>"", '10:15'=>"", '10:30'=>"", '10:45'=>"", '11:00'=>"", '11:15'=>"", '11:30'=>"",
            '13:00'=>"", '13:15'=>"", '13:30'=>"", '13:45'=>"", '14:00'=>"", '14:15'=>"", '14:30'=>"", '14:45'=>"",
            '15:00'=>"", '15:15'=>"", '15:30'=>"", '15:45'=>"", '16:00'=>"", '16:15'=>"", '16:30'=>"");

        $tab_minutos = array("0"=> "0", "1"=> "5", "3"=> "0", "4"=> "5" );
            
        $result = array();
        
        //  Verifica o Horario inicial para agendamento de sepultamento
        
        $hr_inicial=0;
        if(date('H:i') < "16:15") {
            foreach($tab_horarios as $key => $value) 
            {
                if(date('H:i') < $key) {
                    $hr_inicial = $value;
                    break;
                }
            }
        } else {
            $hr_inicial=23;
        }
        
        $registros = count($regPainel);
        foreach($regPainel as $panel)
        {
            $ret = array();
            $panel['Capela']=strtoupper($panel['Capela']);

            if($panel['DataSepultamento']==date('Y-m-d') ) {
                $dia = 1;
                if (strtoupper($panel['Capela'])=="DIRETO") {
                    $sepultamentos_diretos_1[$panel['HorarioSepultamento']]++;
                } else {
                    $sepultamentos_capelas_1[$panel['HorarioSepultamento']]++;

                    //  encontra proximo horario (coloca 15 minutos a mais para limpeza da capela)
                    $pesq = $panel['HorarioSepultamento'];
                    $hor = $tab_horarios[$pesq];

                    $key = array_search(($hor+1), $tab_horarios); 

                    $capela_ocupacao1[$panel['Capela']]=$key;

                }

                $sepultamentos_detalhes_1[$panel['HorarioSepultamento']] .= $panel['Falecido'] . 
                    (strtoupper($panel['Capela'])!="DIRETO" ? 
                    "\nCAPELA " . strtoupper($panel['Capela']) : "\nDIRETO")  ."\nFuneraria: " . $panel['NomeFuneraria'] ."\n——————————————\n" ;


            } else {
                $dia = 2;
                if (strtoupper($panel['Capela'])=="DIRETO") { 
                    $sepultamentos_diretos_2[$panel['HorarioSepultamento']]++;
                } else {
                    $sepultamentos_capelas_2[$panel['HorarioSepultamento']]++;

                    //  encontra proximo horario (coloca 15 minutos a mais para limpeza da capela)
                    $pesq = $panel['HorarioSepultamento'];
                    $hor = $tab_horarios[$pesq];

                    $key = array_search(($hor+1), $tab_horarios); 

                    $capela_ocupacao2[$panel['Capela']]=$panel['HorarioSepultamento'];
                }
                $sepultamentos_detalhes_2[$panel['HorarioSepultamento']] .= $panel['Falecido'] . 
                (strtoupper($panel['Capela'])!="DIRETO" ? "\nCAPELA " . strtoupper($panel['Capela'])  : "\nDIRETO") ."\nFuneraria: " . $panel['NomeFuneraria'] ."\n——————————————————\n" ;
                
            }

            $ret['data'] = $panel['DataSepultamento']; 
            $ret['dia'] = $dia; 
            $ret['protocolo'] = (string) $panel['PainelId'];
            $ret['falecido'] = strtoupper($panel['Falecido']);
            $ret['capela'] = (strtoupper($panel['Capela'])=="DIRETO" ? "DIRETO" : "CAPELA " . strtoupper($panel['Capela']) ) ;
            $ret['destinacao'] = $panel['destinacao'];
            $ret['cod_capela'] = strtoupper($panel['Capela']);
            $ret['funeraria'] = strtoupper($panel['NomeFuneraria']);
            $ret['corretor'] = strtoupper($panel['Corretor']);
            $ret['hr_sepultamento'] = $panel['HorarioSepultamento'];
            $ret['fim'] = $tab_horarios[$panel['HorarioSepultamento']]+1;

            $dt_inicio = (($panel['DataHoraLiberacaoCapela']) ? $panel['DataHoraLiberacaoCapela'] : $now->format('Y-m-d H:i:s'));
            $ret['dt_inicio'] = substr($dt_inicio,0,10);

            //  Calcula a hora de inicio da marcação na tela
            if (substr($dt_inicio, 11, 5) < "10:00") {
                $ret['inicio'] = "1";
                $ret['hs_inicio'] = "10:00";
            } else
            //  Arredonda os horario de 15 em 15 minutos
            if (substr($dt_inicio, 11, 5) > "16:00") {
                $ret['dt_inicio'] = $panel['DataSepultamento'];
                $ret['inicio'] = "1";
                $ret['hs_inicio'] = "10:00";
            } else {
                $dthora=substr($dt_inicio, 14, 1);
                $a1=array("/2/", "/5/");
                $a2=array("3", "4");

                $minuto  = preg_replace($a1, $a2, $dthora );
                $minuto2 = $tab_minutos[$minuto];
                $hr_inicio = substr($dt_inicio, 11, 3) . $minuto . $minuto2;
                $ret['inicio'] = $hr_inicio;
                try {
                    $ret['inicio'] = $tab_horarios[$hr_inicio]+1;
                    $ret['hs_inicio'] = $hr_inicio;
                } catch (Exception $e) {
                    $ret['inicio'] = "erro:" . $hr_inicio;
                }
            }

            $ret['corretorId'] = (string) $panel['CorretorId'];

            $ret['hs_fim'] = $panel['HorarioSepultamento'];

            //  Limita a possibilidade de cancelamento do sepultamento até 1 hora antes
            $agora = new DateTime();
            $limite = new DateTime($panel['DataSepultamento'] . " " . $panel['HorarioSepultamento'] . ":00");
            $limite->sub(new DateInterval('PT1H'));
            $ret['horalimite'] = $limite->format('Y-m-d H:i:s');

            //  Se for o mesmo corretor que fez o agendamento permite excluir o agendamento
            if( $agora <= $limite && ($panel['CorretorId']==Auth()->user()->corretorId || Auth()->user()->nivel=='1') ) {
                $ret['alteravel'] = "1";
            } else {
                $ret['alteravel'] = "0";
            }
            //  Se for administrador permite excluir o agendamento
            if( Auth()->user()->nivel=='1' ) {
                $ret['alteravel'] = "1";
            }

            array_push($result, $ret);

        }

        return json_encode(array("qtdRegistros"=>$registros, "hora_inicial"=>$hr_inicial, "data_atual"=>date('Y-m-d'), "data2"=>$date->format('Y-m-d'),
             "registros"=>$result, "cap_ocupacao1"=>$capela_ocupacao1, "cap_ocupacao2"=>$capela_ocupacao2,
             "sep_diretos_1"=>$sepultamentos_diretos_1, "sep_capelas_1"=>$sepultamentos_capelas_1, "sep_detalhes_1"=>$sepultamentos_detalhes_1,
             "sep_diretos_2"=>$sepultamentos_diretos_2, "sep_capelas_2"=>$sepultamentos_capelas_2, "sep_detalhes_2"=>$sepultamentos_detalhes_2));

    }


    //   Gravação dados de sepultamento
    //
    public function grava_sepultamento(Request $request) 
    {

        $regCorretores = User::where('corretorId', $request->corretor)->get();
        $regCorretor = $regCorretores[0];

        //  Dados da Funeraria
        if($regFuneraria = funerariasModel::find($regCorretor->funerariaId)) {
            $funeraria = $regFuneraria->Nome;
            $cmc=(($regFuneraria->CMC) ? $regFuneraria->CMC : "");
        } else {
            $funeraria="Não Encontrada!";
            $cmc="";
        }

        //  Data do Sepultamento
        if($request->data=='1') {
            $data = date('Y-m-d');
        } else {
            $date = new DateTime();
            $date->add(new DateInterval('P1D'));
            $data=$date->format('Y-m-d');
        }

        // Horario de liberação da Capela
        $tab_minutos = array("0"=> "0", "1"=> "5", "3"=> "0", "4"=> "5" );

        //  Arredonda os horario de 15 em 15 minutos  
        $dthora=substr($request->entrada, 14, 1);
        $a1=array("/2/", "/5/");
        $a2=array("3", "4");
        $minuto  = preg_replace($a1, $a2, $dthora );
        $minuto2 = $tab_minutos[$minuto];
        $liberacaoCapela = substr($request->entrada, 0, 14) . $minuto . $minuto2 . ":00";

        $painelId = Helper::uniqueidentifier();    // Função que cria o id único  -> App/Helpers/Helper.php
        $usuario = Auth()->user()->name;

        $capela = (($request->tipo_sepultamento=="2" || $request->capela_sepultamento=="0") ? "DIRETO" :  $request->capela_sepultamento);

        $result=$this->objPainel->create([
        //  $result=[ 
            'PainelId' => $painelId,
            'Capela' => $capela,
            'Falecido' => $request->falecido,
            'HorarioSepultamento' => substr($request->sep, 11, 5),
            'DataHoraLiberacaoCapela'=>$liberacaoCapela,
            'DataSepultamento' => substr($request->sep, 0, 10),
            'NomeFuneraria' => strtoupper($funeraria),
            'CorretorId' => $request->corretor,
            'Corretor' => strtoupper($regCorretor->name),
            'CMC' => $cmc,
            'LocalFalecimento' => $request->local_falecimento,
            'DeclaracaoObito' => $request->declaracao_obito,
            'MunicipioFalecimento' => $request->munic_falecimento,
            'TipoUrna' => $request->tipo_urna,
            'Cemiterio' => ($request->servico==3 ? "CREMAÇÃO" : "SEPULTAMENTO"),
            'destinacao' => $request->servico,
            'quadro' => $request->quadro,
            'sepultura' => $request->sepultura,
            'UsuarioRegistro' => "S.ONLINE-" . strtoupper($usuario),
            'DataHoraRegistro' => date("Y-m-d H:i:s")
        ]);
        //  ];

        if($result) {
            $status=1;
        } else {
           $status=0;
        }

        $d = new DateTime($request->sep); 

        if($request->servico=='1') {
            $destino = "Sepultamento em <strong>Jazigo Perpétuo</strong>: <strong>Quadro " . $request->quadro . ", Sepultura " . $request->sepultura . "</strong><br>Horário do Sepultamento: <strong>" . $d->format('d/m/Y à\s H:i') . "</strong>";
        } else 
        if($request->servico=='3' && $capela=="DIRETO") {
            $destino = "Horário da Cremação: " . $d->format('d/m/Y à\s H:i');
        } else {
            $destino = "Horário do Sepultamento: <strong>" . $d->format('d/m/Y à\s H:i') . "</strong>";
            if($request->servico=='3') {
                $destino .= "<br><strong>Cremação</strong>";
            }
        }

        if($capela!="DIRETO")   {
            $capela = "Capela: " . $capela;
        }

        return json_encode(array("status"=>$status, "protocolo"=>substr(substr($painelId,1), 0, -1), "horario"=>$destino, 'capela' => $capela ));

    }


    /**
     * Remove o agendamento
     *
     * @param  int  $id  -  PainelId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request )
    {
        $painelId=$request['proto'];

        $del=$this->objPainel->destroy($painelId);
        return($del) ? "1" : "";    
    }

}
