<?php

namespace Serbinario\Http\Controllers;


//meu teste

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Serbinario\Entities\Digitalizacao;
use Serbinario\Entities\DigitalizacaoFile;
use Serbinario\Entities\Modalidade;
use Serbinario\Entities\Secretaria;
use Serbinario\Entities\TipoDocumento;
use Serbinario\Http\Requests\DigitalizacaoFormRequest;
use Serbinario\User;
use Yajra\DataTables\DataTables;
use Exception;
use Serbinario\Traits\UtilFiles;

class DigitalizacaoController extends Controller
{
    use UtilFiles;
    private $token;
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = User::find(Auth::id());
    }

    /**
     * Display a listing of the profiles.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $userLogado = User::find(Auth::id());
        if($userLogado->franquia->id === 1){
            $secretarias = Secretaria::pluck('descricao','id')->all();
        }else{
            $secretarias = Secretaria::where('franquia_id', Auth::user()->franquia->id)->pluck('descricao','id')->all();
        }

        return view('digitalizacao.index', compact('secretarias'));
    }

    /**
     * Display a listing of the fornecedors.
     *
     * @return Illuminate\View\View
     * @throws Exception
     */
    public function grid(Request $request)
    {

        $this->token = csrf_token();
        #Criando a consulta
        $rows = \DB::table('digitalizacao')
            ->leftJoin('despesas', 'despesas.id', '=', 'digitalizacao.despesa_id')
            ->leftJoin('secretarias', 'secretarias.id', '=', 'digitalizacao.secretaria_id')
            ->leftJoin('users', 'users.id', '=', 'digitalizacao.user_id')
            ->select([
                'digitalizacao.id',
                'digitalizacao.descricao',
                'secretarias.descricao as secretaria',
                'digitalizacao.numero_processo',
                'despesas.descricao as despesa',
                'digitalizacao.competencia',
                'digitalizacao.convenio',
                'digitalizacao.conta',
                'digitalizacao.numero_licitacao',
                'digitalizacao.modalidade_id',
                'digitalizacao.objeto_licitacao',
                'digitalizacao.data_homologa'
            ]);

        $user = User::find(Auth::id());
        if($user->franquia->id != 1){
            $rows->where('users.franquia_id', '=', $user->franquia->id);
        }

        #Editando a grid
        return Datatables::of($rows)

            ->filter(function ($query) use ($request) {
                # Filtranto por disciplina
                if ($request->has('descricao')) {
                    $query->where('digitalizacao.descricao', 'like', "%" . $request->get('descricao') . "%");
                }

                if ($request->has('numero_processo')) {
                    $query->where('digitalizacao.numero_processo', 'like', "%" . $request->get('numero_processo') . "%");
                }

                if ($request->has('competencia')) {
                    $query->where('digitalizacao.competencia', 'like', "%" . $request->get('competencia') . "%");
                }

                if ($request->has('convenio')) {
                    $query->where('digitalizacao.convenio', 'like', "%" . $request->get('convenio') . "%");
                }

                if ($request->has('despesa_id')) {
                    $query->where('digitalizacao.despesa_id', '=',  $request->get('despesa_id') );
                }

                if ($request->has('numero_licitacao')) {
                    $query->where('digitalizacao.numero_licitacao', 'like', "%" . $request->get('numero_licitacao') . "%");
                }

                if ($request->has('secretaria_id')) {
                    $query->where('digitalizacao.secretaria_id', '=', $request->get('secretaria_id'));
                }

                if ($request->has('data_ini')) {
                    $tableName = $request->get('filtro_por');
                    $query->whereBetween( $tableName, [$request->get('data_ini'), $request->get('data_fim')])->get();
                }

                if ($request->has('filtro_por')) {
                    $query->where($request->get('filtro_por'), 'like', "%" . $request->get('descricao') . "%");
                }
            })

            ->addColumn('action', function ($row) {
            $acao = '<div class="btn-group btn-group-xs pull-right" role="group">';

            $user =  Auth::user();
            if($user->hasPermissionTo('update.digitalizacao')) {
                $acao .= '<a href="digitalizacao/' . $row->id . '/edit" class="btn btn-primary" title="Edit">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                      </a>';
            }
             $acao .= '               </div>';
                return $acao;
        })->make(true);
    }

    /**
     * Show the form for creating a new profile.
     *
     * @return Illuminate\View\View
     */
    public function create($despesa_tipo)
    {
        $userLogado = User::find(Auth::id());
        if($userLogado->franquia->id === 1){
            $secretarias = Secretaria::pluck('descricao','id')->all();
        }else{
            $secretarias = Secretaria::where('franquia_id', Auth::user()->franquia->id)->pluck('descricao','id')->all();
        }
        $modalidades = Modalidade::pluck('descricao','id')->all();

        $tipoDocs = TipoDocumento::pluck('descricao','id')->all();
        return view('digitalizacao.create' , compact('despesa_tipo', 'tipoDocs', 'secretarias', 'modalidades'));
    }

    /**
     * Store a new profile in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(DigitalizacaoFormRequest $request)
    {

        try {
            $data = $this->getData($request);
            $data['despesa_id'] = $request->get('despesa_id');
            $data['user_id'] = \Auth::id();

            $arquivo = $this->ImageStore($request, 'arquivo', '');
            $digi = Digitalizacao::create($data);

            DigitalizacaoFile::create(['digitalizacao_id' => $digi->id, 'file' => $arquivo ]);

            return redirect()->route('digitalizacao.edit', $digi->id)
                ->with('success_message', 'Cadastro criado com sucesso!');


        } catch (Exception $e) {
            //dd($e);
            return back()->withInput()
                ->withErrors(['error_message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified profile.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $profile = Profile::with('pool')->findOrFail($id);

        return view('profile.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified profile.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $userLogado = User::find(Auth::id());
        if($userLogado->franquia->id === 1){
            $secretarias = Secretaria::pluck('descricao','id')->all();
        }else{
            $secretarias = Secretaria::where('franquia_id', Auth::user()->franquia->id)->pluck('descricao','id')->all();
        }
        $modalidades = Modalidade::pluck('descricao','id')->all();

        $tipoDocs = TipoDocumento::pluck('descricao','id')->all();
        $digi = Digitalizacao::with('files', 'despesa', 'tipoDoc', 'secretaria')->find($id);


        $roles = \Spatie\Permission\Models\Role::pluck('name','id')->all();
        //dd($digi);
        return view('digitalizacao.edit', compact('digi','roles', 'franquias', 'tipoDocs', 'secretarias', 'modalidades'));

    }

    /**
     * Update the specified profile in the storage.
     *
     * @param  int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     * Exemplos
     * https://scotch.io/tutorials/user-authorization-in-laravel-54-with-spatie-laravel-permission
     */
    public function update($id, DigitalizacaoFormRequest $request)
    {
        try {
            $data = $this->getData($request);
            $digi = Digitalizacao::with('files')->findOrFail($id);

            $difiFiles = $digi->files()->get()->toArray();
            $files = $request->file('arquivo');

            if(isset($files)){
                foreach($files as $key => $file)
                {
                    $arquivo = $this->ImageStoreV2($file, 'arquivo', '');
                    $contratos = $digi->files()->create([
                        'file' => $arquivo,
                        'digitalizacao_id' => $digi->id,
                    ]);
                }
            }

            $digi->update($data);

            return redirect()->route('digitalizacao.edit', $digi->id)
                ->with('success_message', 'Cadastro atualizado com sucesso!');

        } catch (Exception $e) {
            return back()->withInput()
                ->withErrors(['errors_message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified profile from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $alert = Alert::findOrFail($id);
            $alert->delete();

            return redirect()->route('alert.index')
                ->with('success_message', 'Alerta deletado com sucesso');

        } catch (Exception $e) {
            return back()->withInput()
                ->withErrors(['error_message' => $e->getMessage()]);
        }
    }

    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
      protected function getData(Request $request)
        {
        $data = $request->only([
            'descricao',
            'numero_processo',
            'competencia',
            'convenio',
            'conta',
            'secretaria_id',
            'unidade_orcamento',
            'fornecedor',
            'cpf_fornecedor',
            'empenho_id',
            'data_empenho',
            'numero_empenho',
            'data_pagto',
            'numero_licitacao',
            'modalidade_id',
            'objeto_licitacao',
            'data_homologa',
            'vencedor',
            'valor',
            'funcionario',
            'cpf',
            'matricula',
            'portaria',
            'data_admissao',
            'lotacao',
            'descricaolei',
            'resumolei',
            'data_lei',
            'data_publica',
            'documento',
            'data_docto',
            'objeto_docto',
            'tipodoc_id',
            'localizacao',
            'observacao',
            'ativo',
            'excluido'
        ]);

        return $data;
    }

}
