<?php
/**
 * Created by PhpStorm.
 * User: serbinario
 * Date: 04/08/18
 * Time: 10:39
 */

namespace serbinario\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Serbinario\Entities\Cliente;
use Serbinario\Entities\MeioCaptacao;
use Serbinario\Http\Controllers\Controller;


class Dashboard extends Controller
{
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
     * Display a listing of the clientes.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact('clientes'));
    }

    /**
     * Chama a procudere qtdInstalacaoes passando dois paramentros, data inicio e data fim
     * retorna a quantidade de instalaçoes mes
     * Falta corrigir as datas pois estao fixas, deveria retornar dos utimos 6 meses ou colocar um botao para escolher
     */
    public function clientesPorMes()
    {
        $result = DB::select('call qtdInstalacaoes("2019-01-01", "2019-12-31")');

        $result2018 = DB::select('call qtdInstalacaoes("2019-01-01", "2019-12-31")');

        return \Illuminate\Support\Facades\Response::json($result);
    }

    public function getProjetos(Request $request){

        $rows = \DB::table('projetos')
            ->rightJoin('projetos_status', 'projetos_status.id', '=', 'projetos.projeto_status_id')

            ->select([
                    'projetos_status.status_nome',
                \DB::raw('COUNT(projetos.id) as soma')
            ])
            ->groupBy('projetos_status.id')
            ->get();

        return \Illuminate\Support\Facades\Response::json($rows);
    }



}