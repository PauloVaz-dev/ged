<?php

namespace Serbinario\Http\Controllers;


//meu teste

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\AssignOp\Mod;
use Serbinario\Entities\Digitalizacao;
use Serbinario\Entities\DigitalizacaoFile;
use Serbinario\Entities\Modalidade;
use Serbinario\Entities\Secretaria;
use Serbinario\Entities\TipoDocumento;
use Serbinario\Http\Requests\DigitalizacaoFormRequest;
use Serbinario\Http\Requests\ModalidadeFormRequest;
use Yajra\DataTables\DataTables;
use Exception;
use Serbinario\Traits\UtilFiles;

class SecretariaController extends Controller
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
        return view('secretaria.index');
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
        $rows = \DB::table('secretarias')
            ->select([
                'id',
                'descricao',
                'ativo'
            ]);

        #Editando a grid
        return Datatables::of($rows)


            ->addColumn('action', function ($row) {
            return '<form id="' . $row->id   . '" method="POST" action="secretaria/' . $row->id   . '/destroy" accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            <input name="_token" value="'.$this->token .'" type="hidden">
                            <div class="btn-group btn-group-xs pull-right" role="group">                              
                                <a href="secretaria/'.$row->id.'/edit" class="btn btn-primary" title="Edit">
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
    public function create()
    {
        return view('secretaria.create');
    }

    /**
     * Store a new profile in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(ModalidadeFormRequest $request)
    {
        try {
            //$this->affirm($request);
            $data = $this->getData($request);
            $secretaria = Secretaria::create($data);
            return redirect()->route('secretaria.edit', $secretaria->id)
                ->with('success_message', 'Cadastro atualizado com sucesso!');


        } catch (Exception $e) {
            //dd($e);
            return back()->withInput()
                ->withErrors(['error_message' => $e->getMessage()]);
        }
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
        $secretaria = Secretaria::find($id);

        //dd($user->roles[0]->id);
        return view('secretaria.edit', compact('secretaria'));

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
            $secretaria = Secretaria::findOrFail($id);

            $secretaria->update($data);

            return redirect()->route('secretaria.edit', $secretaria->id)
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
            'ativo'

        ]);

        return $data;
    }

}
