<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// use App\Models\funerariasModel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar as rotas da web para seu aplicativo. Estas
| rotas são carregadas pelo RouteServiceProvider dentro de um grupo que
| contém o grupo de middleware "web". 
|
*/

/**
 *   Rotas de Login e Controle de autenticação
 *
 */
    Route::get('/', function () {
        Auth::logout();
        return view('auth.login');
    });

    Auth::routes();
    Auth::routes(['verify' => true]);

    Route::get('/logout', [App\Http\Controllers\auth\LogoutController::class, 'logout'])->name('home');

    Route::get('/aviso/{protocolo}', [App\Http\Controllers\pdfGenerateController::class, 'generate']);


    /**
     *      Rotas de Controle  da  pagina Inicial (Home)
     *
     */
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/age/horarios', [App\Http\Controllers\HomeController::class, 'horarios'])->name('age.horarios');
    Route::post('/age/grava_sepultamento', [App\Http\Controllers\HomeController::class, 'grava_sepultamento'])->name('age.grava_sepultamento');
    Route::get('/age/delete', [App\Http\Controllers\HomeController::class, 'destroy'])->name('age.delete');



    /**
     *      Rotas de controle de Cadastro de Corretores
     *
     */
    Route::put('corretor/{id}', [App\Http\Controllers\corretorController::class, 'update']);

    Route::get('/corretores',   [App\Http\Controllers\corretorController::class, 'index'])->name('corretores');
    Route::get('/cor/cadastro', [App\Http\Controllers\corretorController::class, 'cadastro'])->name('cad.corretores');
    Route::get('/cor/edit/{id}', [App\Http\Controllers\corretorController::class, 'edit'])->name('cor.edita');
    Route::get('/cor/desativa/{id}', [App\Http\Controllers\corretorController::class, 'desativa'])->name('cor.desativa');

    

/*********************************************************
 *               AREA RESERVADA PARA TESTES
 * 
 */

    Route::get('send-mail', function ($falecido, $capela, $horario, $corretor, $funeraria) {
   
        $details = [
            'title' => 'Recebido Novo Agendamento de Sepultamento',
            'body' => 'Novo Sepultamento agendado às xxxx para: <br><br>' +
                      'Falecido: ' + $falecido + '<br>' +
                      'Capela: ' + $capela + '<br>' + 
                      'Horário: ' + $horario + '<br>' + 
                      'Funerária: ' + $funeraria + '<br>' + 
                      'Corretor: ' + $corretor + '<br>'
        ];
       
        \Mail::to('nilsonserafim@gmail.com')
                ->send(new \App\Mail\msonlineMail($details));

        dd("Email is Sent.");
    });

 
    Route::get('/teste/{falecido}/{data}/{hora}/{funeraria}', function ($falecido, $data, $hora, $funeraria) 
    {

        $regSepultamento=array(
            "falecido"=>$falecido, 
            "data"=>$data, 
            "hora"=>$hora, 
            "funeraria"=>$funeraria
        );

        return view('relSepultamento', compact('regSepultamento'));

        //    $funerarias=funerariasModel::find('b31376f1-cc8d-4ea5-a226-3b3ecba5f5cd');
        //    print_r($funerarias->CMC);

    });


        
    /* ******************************************************** 
    /      Rotas para Teste 
    */
    Route::get('/teste2', function () 
    {
/*        
        $regSepultamento=array()
        return view('pdf', compact('regCapelas', 'regAgendamentos', 'regCorretores'));
*/
            
    })->middleware('auth.basic');   // verifica se o usuário está autenticado


