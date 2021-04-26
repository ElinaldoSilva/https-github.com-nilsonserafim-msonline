@extends('templates.template_bs4')
<style>
    .pad-e-4 {
        padding-right: 1.5rem!important;
    }
    @media (max-width: 768px) { 
        .pad-e-4 {
            padding-right: 0.2rem!important;
        }
    }
    .c-red {
            color: red;
        }
    
</style>

@section('title', 'Marcação de Sepultamento')

@section('content')

    <div class="col-12 col-md-10 m-auto">
        <div class="text-end mt-3 mb-4">
            <a href="{{url(route("cad.corretores"))}}"><button class="btn btn-primary">Cadastrar</button></a>
        </div>
    </div>

    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <div class="col-12 col-md-10 m-auto">
     <div class="table-responsive">
      <table class="table ft-13">
        <thead class="table-dark">
            <tr>
            <th scope="col">Nome</th>
            <th scope="col">Funerária</th>
            <th scope="col"></th>
            </tr>
        </thead>
        
        <tbody>

            @foreach($regCorretores as $corretor)
                @php
                    $funeraria = strlen($corretor->nome_funeraria) > 30 ? substr($corretor->nome_funeraria, 0, 30) . "..." : $corretor->nome_funeraria; 
//                    $funeraria=$corretor->find($corretor->id)->funeraria;
//                    $funeraria= strlen($funeraria->Nome) > 24 ? substr($funeraria->Nome, 0, 24) . "..." : $funeraria->Nome; 
                @endphp

                <tr>
                <th scope="row">{!! strtoupper($corretor->Nome)  . (($corretor->status==0) ? " - <span class='c-red'>DESATIVADO</span>" : "") !!}</th>
                <td>{!! $corretor->nome_funeraria !!}</td>
                <td style="width:140px; padding: 0.25rem;">
                    <a href="{{ url("cor/edit/$corretor->id")}}"><button class="btn btn-sm btn-primary">Editar</button></a>
                    <a href="{{ url("cor/desativa/$corretor->corretorId") }}" class="js-del"><button class="btn btn-sm btn-danger">Desativar</button></a>  
                </tr>
            @endforeach

        </tbody>

      </table>

          <div class="d-flex justify-content-center pt-4">
              {{ $regCorretores->links() }}    
            </div>

     </div>
    </div>


    <script src="{{url("js/corretores.js")}}"></script>

@endsection
