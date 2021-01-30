<?php

namespace Serbinario\Http\Controllers;


//meu teste

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Serbinario\Entities\Digitalizacao;
use Serbinario\Entities\DigitalizacaoFile;
use Serbinario\Entities\TipoDocumento;
use Serbinario\Http\Requests\DigitalizacaoFormRequest;
use Yajra\DataTables\DataTables;
use Exception;
use Serbinario\Traits\UtilFiles;

class DigitalizacaoController extends Controller
{
    use UtilFiles;
    private $token;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the profiles.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return view('digitalizacao.index');
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
            ->select([
                'digitalizacao.id',
                'digitalizacao.descricao',
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

                if ($request->has('conta')) {
                    $query->where('digitalizacao.conta', 'like', "%" . $request->get('conta') . "%");
                }

                if ($request->has('numero_licitacao')) {
                    $query->where('digitalizacao.numero_licitacao', 'like', "%" . $request->get('numero_licitacao') . "%");
                }

                if ($request->has('despesa_id')) {
                    $query->where('digitalizacao.despesa_id', '=', $request->get('despesa_id') );
                }
            })


            ->addColumn('action', function ($row) {
            return '<form id="' . $row->id   . '" method="POST" action="digitalizacao/' . $row->id   . '/destroy" accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            <input name="_token" value="'.$this->token .'" type="hidden">
                            <div class="btn-group btn-group-xs pull-right" role="group">                              
                                <a href="digitalizacao/'.$row->id.'/edit" class="btn btn-primary" title="Edit">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
                               
                        </form>
                        ';
        })->make(true);
    }

    /**
     * Show the form for creating a new profile.
     *
     * @return Illuminate\View\View
     */
    public function create($despesa_tipo)
    {
        $tipoDocs = TipoDocumento::pluck('descricao','id')->all();
        return view('digitalizacao.create' , compact('despesa_tipo', 'tipoDocs'));
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

            //$this->affirm($request);
            $data = $this->getData($request);
            //dd($request->all());
            $data['despesa_id'] = $request->get('despesa_id');

            //dd($data);
            $data['user_id'] = \Auth::id();


            $arquivo = $this->ImageStore($request, 'arquivo', '');



            $digi = Digitalizacao::create($data);

            DigitalizacaoFile::create(['digitalizacao_id' => $digi->id, 'file' => $arquivo ]);

            return redirect()->route('digitalizacao.edit', $digi->id)
                ->with('success_message', 'Cadastro atualizado com sucesso!');


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
        $tipoDocs = TipoDocumento::pluck('descricao','id')->all();
        $digi = Digitalizacao::with('files', 'despesa', 'tipoDoc')->find($id);

        $roles = \Spatie\Permission\Models\Role::pluck('name','id')->all();

        //dd($user->roles[0]->id);
        return view('digitalizacao.edit', compact('digi','roles', 'franquias', 'tipoDocs'));

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
                    //dd($file);
                    $arquivo = $this->ImageStoreV2($file, 'arquivo', '');
                    //dd($arquivo);
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
