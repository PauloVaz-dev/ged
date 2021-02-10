<?php

namespace Serbinario\Http\Controllers;


//meu teste

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use DB;
use Yajra\DataTables\DataTables;
use Exception;
use Serbinario\User;

class RolesController extends Controller
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
        return view('roles.index');
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
        $rows = \DB::table('roles')
            ->leftJoin('franquias', 'franquias.id', '=', 'roles.franquia_id')
            ->select([
                'roles.id',
                'roles.name',
                'roles.is_active',
                'franquias.nome'
            ]);

        $user = User::find(Auth::id());
        if($user->franquia->id != 1){
            $rows->where('franquia_id', '=', $user->franquia->id);
        }

        #Editando a grid
        return Datatables::of($rows)
            ->addColumn('action', function ($row) {


                $acao = '<div class="btn-group btn-group-xs pull-right" role="group">';

                $user =  Auth::user();
                if($user->hasPermissionTo('update.roles')) {
                    $acao .= '<a href="roles/' . $row->id . '/edit" class="btn btn-primary" title="Edit">
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
        $permission = Permission::get();
        $rolePermissions = [];
        $permissionGroup = $permission->groupBy(function ($member) {
            return $member->model;
        })->all();
        return view('roles.create',compact('permission', 'rolePermissions', 'permissionGroup'));

        return view('users.create', compact('roles', 'franquias'));
    }

    /**
     * Store a new profile in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $role = Role::create(['name' => $request->input('name'), 'franquia_id' => Auth::user()->franquia->id]);
            $role->syncPermissions($request->input('permission'));

            return redirect()->route('roles.role.edit', $role->id)
                ->with('success_message', 'Cadastro atualizado com sucesso!');


        } catch (Exception $e) {
           // dd($e);
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
            $role = Role::find($id);
        }else{
            $role = Role::where('franquia_id', Auth::user()->franquia->id)->find($id);
        }

        $permission = Permission::get();
        $permissionGroup = $permission->groupBy(function ($member) {
            return $member->model;
        })->all();


        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        //dd($permission);
        return view('roles.edit', compact('user', 'role', 'permission', 'rolePermissions', 'permissionGroup'));

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
    public function update($id, Request $request)
    {
        try {

            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();

            $role->syncPermissions($request->input('permission'));

            return redirect()->route('roles.role.edit', $role->id)
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
            $role = Role::find($id);
            $role->delete();

            return redirect()->route('roles.rule.index')
                ->with('success_message', 'Grupo deletado com sucesso');

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
