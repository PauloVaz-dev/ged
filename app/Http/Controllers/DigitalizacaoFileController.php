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

class DigitalizacaoFileController extends Controller
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

    public function findAllDigitalizacao(Request $request)
    {
        try {

            $digiFiles = DigitalizacaoFile::select('file')->where('digitalizacao_id', '=', $request->get('id') )->get()->toArray();

            return \Illuminate\Support\Facades\Response::json(['success' => true,  'data' => $digiFiles]);

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
