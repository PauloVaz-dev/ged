<?php

namespace Serbinario\Http\Controllers;

use Illuminate\Http\Request;
use Serbinario\Entities\Cidade;
use Serbinario\Entities\Cliente;
use Serbinario\Entities\Contrato;
use Serbinario\Entities\Endereco;
use Serbinario\Entities\PreProposta;
use Serbinario\Entities\ProjetosContasContrato;
use Serbinario\Entities\ProjetosDocumento;
use Serbinario\Entities\ProjetosExecurcao;
use Serbinario\Entities\ProjetosFinalizado;
use Serbinario\Entities\ProjetosFinalizando;
use Serbinario\Entities\ProjetosPrioridade;
use Serbinario\Traits\SimuladorV2;
use Serbinario\Traits\UtilReports;
use Serbinario\User;
use Illuminate\Support\Facades\Auth;
use Serbinario\Entities\Projetov2;


class UtilController extends Controller
{
    use UtilReports, SimuladorV2;
    private $token;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
	    //$this->middleware('auth');
	}

	public function getClientes(Request $request){

	    //Falta  colocar o filtro por permissão

	    $user = User::find(Auth::id());
	    $result = array();
        $user = User::find(Auth::id());
        if($user->hasRole('super-admin')) {
            $clientes = Cliente::select('id', 'nome_empresa')
                ->where('nome_empresa', 'like', "%" . $request->get('searchTerm') . "%")
                ->limit(10)->get();
        }else{
            $clientes = Cliente::select('id', 'nome_empresa')
                ->where('user_id', '=', $user->id)
                ->where('nome_empresa', 'like', "%" . $request->get('searchTerm') . "%")
                ->limit(10)->get();
        }

        foreach ( $clientes as $cliente) {
            array_push($result, ['id' => $cliente->id, 'text' => $cliente->nome_empresa] );
        }
        $usersJson = json_encode($result);
        return $usersJson;

    }

    public function simular(Request $request){
	    dd($request->all());
    }

    public function arquivarProposta(Request $request){

        try {

            $proposta  = PreProposta::where('id', '=', $request->id)->first();

            $proposta->update( [ 'arquivado' => $request->arquivar]);
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Proposta arquivado com sucesso']);

        } catch (Exception $exception) {;
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
	   //dd($request->id);

    }

    public function arquivarProjeto(Request $request){

        try {
            $projeto  = Projetov2::where('id', '=', $request->id)->first();

            $projeto->update( [ 'arquivado' => $request->arquivar] );
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Projeto arquivado com sucesso']);

        } catch (Exception $exception) {;
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
        //dd($request->id);

    }
	
    /**
     * Display a listing of the pools.
     *
     * @return Illuminate\View\View
     */
    public function consultaCpfCnpf(Request $request)
    {
       $cpf_cnpj =  Cliente::where('cpf_cnpj', '=', $request->input('cpf_cnpj') )->first();
       //dd($cpf_cnpj);
       if(isset($cpf_cnpj->cpf_cnpj)){
           return \Illuminate\Support\Facades\Response::json(['success' => true, 'msg' => 'Ja existe um cliente cadastrado']);
       }
        return \Illuminate\Support\Facades\Response::json(['success' => false,  'msg' => $cpf_cnpj]);
    }

    public function getCidades($id){
        $cidades = Cidade::where('estado_id', '=', $id)->pluck('nome','id');
        return \Illuminate\Support\Facades\Response::json(['success' => false,  'cidades' => $cidades]);
    }

    public function simulador(Request $request){

        $ip = request()->ip();

        $validator = \Validator::make($request->all(), [
            'monthly_usage' => 'required',
            'estado_id' => 'required',
            'cidade_id' => 'required',
            'modulo_id' => 'required'
        ]);

        if ($validator->fails()) {
            return \Illuminate\Support\Facades\Response::json(['success' => false,
                $validator->errors()
            ]);
        }

        $return = $this->simularGeracao($request);

        return \Illuminate\Support\Facades\Response::json(
            [
                'success' => true,
                'qtd_modulos' => $return['qtd_modulos'],
                'wkp' => $return['potencia_gerador'],
                'area_minima' => $return['area_minima'],
                'c02' => $return['co2'],
                'valor_kw' => "",
                //round(1, 2)
                'total_nvestimento' => $return['total_investimento'],
                'irradiacao_anual' => $return['irradiacao_anual']
            ]
        );
    }


    public function criarProjeto($id){

        try {
            $projetoDocumento = ProjetosDocumento::create();
            $projetosExecurcao = ProjetosExecurcao::create();
            $projetosFinalizando = ProjetosFinalizando::create();
            $projetosFinalizado = ProjetosFinalizado::create();
            $endereco = Endereco::create();

            $data = array();
            $data['proposta_id'] = $id;
            $data['projeto_status_id'] = 8;
            $data['projeto_documento_id'] = $projetoDocumento->id;
            $data['projeto_execurcao_id'] = $endereco->id;
            $data['endereco_id'] = $endereco->id;
            $data['projeto_finalizando_id'] = $projetosFinalizando->id;
            $data['projeto_finalizado_id'] = $projetosFinalizado->id;
            $data['projeto_prioridade_id'] = 1;

            Projetov2::create($data);

        } catch (Exception $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'message' => $e]);
        }
        return \Illuminate\Support\Facades\Response::json(['success' => true]);
    }

    public function criarContrato(Request $request){

        try {
            $data = array();
            $data['projeto_id'] = $request->get('projeto_id');
            $data['franquia_id'] = Auth::user()->franquia->id;
            $data['report_layout_id'] = $request->get('minuta_contrato');;
            $data['projeto_id'] = $request->get('projeto_id');
            $data['ano'] = $request->get('ano');
            $data['created_by'] = Auth::user()->id;

            Contrato::create($data);

        } catch (Exception $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'message' => $e]);
        }
        return \Illuminate\Support\Facades\Response::json(['success' => true]);
    }

    public function deletaContratoConcercionaria(Request $request){
        $idContrato = "";
        try {

            $idContrato = $request->get('idContrato');

            $contaContato = ProjetosContasContrato::find($idContrato);
            $contaContato->delete();


        } catch (Exception $e) {
            return \Illuminate\Support\Facades\Response::json(['success' => true, 'message' => $e]);
        }
        return \Illuminate\Support\Facades\Response::json(['success' => true, 'body' => $idContrato ]);
    }
}
