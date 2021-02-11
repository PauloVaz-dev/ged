<?php

namespace Serbinario\Http\Controllers;


//meu teste

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\AssignOp\Mod;
use Serbinario\Entities\Digitalizacao;
use Serbinario\Entities\DigitalizacaoFile;
use Serbinario\Entities\Modalidade;
use Serbinario\Entities\TipoDocumento;
use Serbinario\Http\Requests\DigitalizacaoFormRequest;
use Serbinario\Http\Requests\ModalidadeFormRequest;
use Yajra\DataTables\DataTables;
use Exception;
use Serbinario\Traits\UtilFiles;

class ModalidadeController extends Controller
{
    use UtilFiles;
    private $token;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('modalidade.index');
    }

    public function grid(Request $request)
    {
        $this->token = csrf_token();
        #Criando a consulta
        $rows = \DB::table('modalidades')
            ->select([
                'id',
                'descricao',
                'ativo'
            ]);

        #Editando a grid
        return Datatables::of($rows)
            ->addColumn('action', function ($row) {
                $acao = '<div class="btn-group btn-group-xs pull-right" role="group">';

                $user =  Auth::user();
                if($user->hasPermissionTo('update.modalidade')) {
                    $acao .= '<a href="modalidade/' . $row->id . '/edit" class="btn btn-primary" title="Edit">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                      </a>';
                }
                $acao .= '               </div>';
                return $acao;
            })->make(true);
    }

    public function create()
    {
        return view('modalidade.create');
    }

    public function store(ModalidadeFormRequest $request)
    {

        try {
            //$this->affirm($request);
            $data = $this->getData($request);
            $digi = Modalidade::create($data);

            return redirect()->route('modalidade.edit', $digi->id)
                ->with('success_message', 'Cadastro atualizado com sucesso!');


        } catch (Exception $e) {
            //dd($e);
            return back()->withInput()
                ->withErrors(['error_message' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $profile = Profile::with('pool')->findOrFail($id);

        return view('profile.show', compact('profile'));
    }

    public function edit($id)
    {
        $modalidade = Modalidade::find($id);

        //dd($user->roles[0]->id);
        return view('modalidade.edit', compact('modalidade'));

    }

    public function update($id, ModalidadeFormRequest $request)
    {
        try {
            $data = $this->getData($request);
            $modalidade = Modalidade::findOrFail($id);
            $modalidade->update($data);

            return redirect()->route('modalidade.edit', $modalidade->id)
                ->with('success_message', 'Cadastro atualizado com sucesso!');

        } catch (Exception $e) {
            return back()->withInput()
                ->withErrors(['errors_message' => $e->getMessage()]);
        }
    }

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

    protected function getData(Request $request)
        {
        $data = $request->only([
            'descricao',
            'ativo'

        ]);

        return $data;
    }
}
