<?php

namespace Serbinario\Http\Controllers;


//meu teste

use Serbinario\Entities\BasePrecoRevenda;
use Serbinario\Entities\Instituicao;
use Serbinario\Entities\Parametro;
use Serbinario\Http\Controllers\Controller;
use Serbinario\Http\Requests\FranquiaFormRequest;
use Illuminate\Support\Facades\Auth;
use Serbinario\User;
use Yajra\DataTables\DataTables;
use Exception;

class FranquiaController extends Controller
{
    private $token;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct(){
            $this->middleware('auth');
     }
    /**
     * Display a listing of the franquias.
     *
     * @return Illuminate\View\View
     */
    public function index(){
        $franquias = Instituicao::paginate(25);

        return view('franquia.index', compact('franquias'));
    }

    /**
         * Display a listing of the fornecedors.
         *
         * @return Illuminate\View\View
         * @throws Exception
         */
        public function grid(){
            $this->token = csrf_token();
            #Criando a consulta
            $rows = \DB::table('franquias');


            #Editando a grid
            return Datatables::of($rows)->addColumn('action', function ($row) {
                return '<form id="' . $row->id   . '" method="POST" action="franquia/' . $row->id   . '/destroy" accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            <input name="_token" value="'.$this->token .'" type="hidden">
                            <div class="btn-group btn-group-xs pull-right" role="group">                            
                                <a href="franquia/'.$row->id.'/edit" class="btn btn-primary" title="Edit">
                                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                </a>
                                <button type="submit" class="btn btn-danger delete" id="' . $row->id   . '" title="Delete">
                                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </button>
                        </form>
                        ';
                            })->make(true);
        }

    /**
     * Show the form for creating a new franquia.
     *
     * @return Illuminate\View\View
     */
    public function create(){
        return view('franquia.create');
    }

    /**
     * Store a new franquia in the storage.
     *
     * @param Serbinario\Http\Requests\FranquiaFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(FranquiaFormRequest $request){
        try {
            $data = $request->getData();
            $franquia = Instituicao::create($data);

            //[RF006-RN003]:Toda franquia criada já se gera um parametro para ela
            Parametro::create(['franquia_id' => $franquia->id]);

            return redirect()->route('franquia.franquia.edit', $franquia->id)
                ->with('success_message', 'Cadastro realizado com sucesso!');

        } catch (Exception $e) {
            return back()->withInput()
                         ->withErrors(['unexpected_error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified franquia.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id){
        $franquia = Instituicao::findOrFail($id);

        return view('franquia.show', compact('franquia'));
    }

    /**
     * Show the form for editing the specified franquia.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id){
        $franquia = Instituicao::findOrFail($id);

        return view('franquia.edit', compact('franquia'));
    }

    /**
     * Update the specified franquia in the storage.
     *
     * @param  int $id
     * @param Serbinario\Http\Requests\FranquiaFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, FranquiaFormRequest $request){
        try {
            
            $data = $request->getData();
            
            $franquia = Instituicao::findOrFail($id);

            $user = User::find(Auth::id());
            //dd($user);
            if(!$user->hasRole('super-admin')){
                 $data['is_active'] = true;
            }

            $franquia->update($data);

            return redirect()->route('franquia.franquia.edit', $franquia->id)
                ->with('success_message', 'Cadastro atualizado com sucesso!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified franquia from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id){
        try {
            $franquia = Instituicao::findOrFail($id);
            $franquia->delete();

            return redirect()->route('franquia.franquia.index')
                             ->with('success_message', 'Instituicao was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }



}
