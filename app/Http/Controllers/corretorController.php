<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//
// use App\Http\Requests\corretorRequest;

use App\Models\funerariasModel;
use App\Models\User;
use Helper;


class corretorController extends Controller
{
    private $objFuneraria;
    private $objCorretor;

    public function __construct()
    {
        //  Só entra na pagina se estiver logado
        //
        $this->middleware('auth');

        $this->objFuneraria = new funerariasModel();
        $this->objCorretor = new User();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regCorretores=$this->objCorretor
            ->select('users.id', 'users.Nome', 'Funerarias.nome as nome_funeraria', 'users.corretorId', 'users.status')
            ->join('Funerarias', 'Funerarias.FunerariaId', '=', 'users.funerariaId')
            ->orderBy('users.name')
            ->paginate(10);

        /*
        $regCorretores=User::
            select('users.id', 'users.Nome', 'Funerarias.nome as nome_funeraria', 'users.corretorId', 'users.status')
            ->join('Funerarias', 'Funerarias.FunerariaId', '=', 'users.funerariaId')
            ->orderBy('users.name')
            ->toSql();
        */

        return view('corretores.corretoresIndex',compact('regCorretores'));
    }



    public function cadastro()
    {
        $funerarias=$this->objFuneraria->select('FunerariaId', 'Nome', 'CMC')->orderBy('Nome')->get();
        return view('auth.register', compact('funerarias'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $corretores=$this->objCorretor->all();
        return view('corretoresCreate', compact('corretores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $corretorId = Helper::uniqueidentifier();    // Função que cria o id único  -> App/Helpers/Helper.php

        $result=$this->objCorretor->create([
            'name'=>$request->name,
            'Nome'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'funerariaId'=>$request->funerariaId,
            'nivel'=>$request->nivel,
            'corretorId'=>$corretorId
        ]);
        if($result) {
            return redirect('corretor');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $corretor=User::find($id);
        $funerarias=$this->objFuneraria->all();

        return view('auth\register',compact('corretor', 'funerarias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  uniqueidentifier  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        User::where(['id'=>$id])->update([
            'name'=>$request->name,
            'Nome'=>$request->name,
            'email'=>$request->email,
            'funerariaId'=>$request->funerariaId,
            'nivel'=>$request->nivel,
            'status'=>$request->status,
        ]);

        return redirect('corretores');    
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        echo $id;
//        $del=$this->objCorretor->destroy($id);
        return($del)?"sim":"não";    
    }



    //   Desativação do cadastro do Corretor
    //
    public function desativa($id) 
    {  
        
        $result = User::where('corretorId', $id)->update(['status' => 0]);
        return redirect('corretores');    

    }


}
