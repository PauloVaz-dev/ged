<?php

namespace Serbinario\Http\Controllers;


//meu teste

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Serbinario\Entities\DocumentoUpload;
use Serbinario\Entities\Instituicao;
use Serbinario\Entities\Pool;
use Serbinario\Entities\Profile;
use Serbinario\Entities\Router;
use Serbinario\Http\Controllers\Controller;
use Serbinario\Http\Requests\UserFormRequest;
use Serbinario\Traits\UtilFiles;
use Serbinario\User;
use Yajra\DataTables\DataTables;
use Exception;

class DocumentoUploadController extends Controller
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
        return view('documento.index');
    }


    /**
     * Show the form for creating a new profile.
     *
     * @return Illuminate\View\View
     */
    public function upload(Request $request)
    {
        $documento_franquia_id = $request->get('documento_franquia_id');

        $file = $this->ImageStore($request,'arquivo');

        $docUpload = DocumentoUpload::where('documento_franquia_id', '=', $documento_franquia_id)->first();

        if($docUpload){
            //dd($docUpload);
            $data = DB::table('documentos_upload')
                ->where('documento_franquia_id', $documento_franquia_id)
                ->update(['image' =>$file]);
            //$docUpload->update(['image' => $file ]);
        }else{
            DocumentoUpload::create(['documento_status_id' => 1, 'fanquia_id' => 14, 'documento_franquia_id' => $documento_franquia_id, 'image' => $file]);
        }

        return response()->json(['success' => true, 'msg' => $documento_franquia_id]);
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


        } catch (Exception $e) {
            dd($e);
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
        $franquias = Instituicao::pluck('nome','id')->all();
        $user = User::with('roles', 'franquia')->findOrFail($id);
        //dd($user);
        $roles = \Spatie\Permission\Models\Role::pluck('name','id')->all();

        //dd($user->roles[0]->id);
        return view('users.edit', compact('user', 'roles', 'franquias'));

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



        } catch (Exception $e) {
            return back()->withInput()
                ->withErrors(['error_message' => $e->getMessage()]);
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
