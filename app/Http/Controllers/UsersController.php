<?php

namespace Serbinario\Http\Controllers;


//meu teste

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Serbinario\Entities\Instituicao;
use Serbinario\Entities\Secretaria;
use Spatie\Permission\Models\Role;
use Serbinario\Http\Controllers\Controller;
use Serbinario\Http\Requests\UserFormRequest;
use Serbinario\User;
use Yajra\DataTables\DataTables;
use Exception;
use DB;

class UsersController extends Controller
{
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
        return view('users.index');
    }

    /**
     * Display a listing of the fornecedors.
     *
     * @return Illuminate\View\View
     * @throws Exception
     */
    public function grid()
    {
        $this->token = csrf_token();
        #Criando a consulta
        $rows = \DB::table('users')
            ->leftJoin('franquias', 'franquias.id', '=', 'users.franquia_id')
            ->leftJoin('secretarias', 'secretarias.id', '=', 'users.secretaria_id')
            ->select([
                'users.id',
                'secretarias.descricao as secretaria',
                'users.email',
                'users.name',
                'franquias.nome',
                'users.is_active'
            ]);

        $user = User::find(Auth::id());
        if($user->franquia->id != 1){
            $rows->where('users.franquia_id', '=', $user->franquia->id);
        }

        #Editando a grid
        return Datatables::of($rows)->addColumn('action', function ($row) {

            $acao = '<div class="btn-group btn-group-xs pull-right" role="group">';

            $user =  Auth::user();
            if($user->hasPermissionTo('update.users')) {
                $acao .= '<a href="users/' . $row->id . '/edit" class="btn btn-primary" title="Edit">
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
    public function create()
    {

        $userLogado = User::find(Auth::id());
        if($userLogado->franquia->id === 1){
            $secretarias = Secretaria::pluck('descricao','id')->all();
            $franquias = Instituicao::pluck('nome','id')->all();
            $roles = Role::pluck('name','id')->all();
        }else{
            $secretarias = Secretaria::where('franquia_id', Auth::user()->franquia->id)->pluck('descricao','id')->all();
            $franquias = Instituicao::where('id', Auth::user()->franquia->id)->pluck('nome','id')->all();
            $roles = Role::where('franquia_id', Auth::user()->franquia->id)->pluck('name','id')->all();
        }

        $userRole = [];
        return view('users.create', compact('roles', 'franquias', 'userRole', 'secretarias'));
    }

    /**
     * Store a new profile in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(UserFormRequest $request)
    {
        try {
            //$this->affirm($request);
            $data = $this->getData($request);

            $data['password'] = \Hash::make($data['password']);


            $user = User::create($data);
            $user->syncRoles($request->input('roles'));

            return redirect()->route('users.user.edit', $user->id)
                ->with('success_message', 'Cadastro atualizado com sucesso!');


        } catch (Exception $e) {
            dd($e);
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

        $user = User::with('roles', 'franquia', 'secretaria')->findOrFail($id);

        $userLogado = User::find(Auth::id());
        if($userLogado->franquia->id === 1){
            $roles = Role::pluck('name','name')->all();
            $franquias = Instituicao::pluck('nome','id')->all();
            $secretarias = Secretaria::pluck('descricao','id')->all();
        }else{
            $roles = Role::where('franquia_id', '=', Auth::user()->franquia->id)->pluck('name','name')->all();
            $franquias = Instituicao::where('id', '=', Auth::user()->franquia->id)->pluck('nome','id')->all();
            $secretarias = Secretaria::where('franquia_id', Auth::user()->franquia->id)->pluck('descricao','id')->all();
        }

        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit', compact('user', 'roles', 'franquias', 'userRole', 'secretarias'));
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
    public function update($id, UserFormRequest $request)
    {
        try {

           // dd($request->input('roles'));
            //$this->affirm($request);
            $data = $request->getData();

            $user = User::findOrFail($id);
            if(empty($data['password'])){
                $data['password'] = $user->password;
            }else{
                $data['password'] = \Hash::make($data['password']);
            }

            $user->update($data);
            $user->syncRoles($request->input('roles'));

            return redirect()->route('users.user.edit', $user->id)
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
        $data = $request->only(['name', 'email', 'password', 'role', 'franquia_id']);

        return $data;
    }

}
