<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 12/20/19
 * Time: 2:41 PM
 */

namespace Serbinario\Traits;


use Hamcrest\Thingy;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Serbinario\Entities\BasePreco;
use Serbinario\Entities\BasePrecoEstruturaEletrica;
use Serbinario\Entities\BasePrecoMaoObra;
use Serbinario\Entities\Cidade;
use Serbinario\Entities\Modulo;

trait Simulador
{
    private $valorModulo = 0;
    private $somaModulos = 0;
    private $somaInversor = 0;
    private $somaestrutura = 0;
    private $somaInfra = 0;
    private $somaKit = 0;
    private $totalInvestimento = 0;
    private $qtdModulos = 0;
    private $qtdInversores = 1;
    private $irradiacao_anual = 0;
    private $potenciaModulo = 0;
    private $valorMaoObra = 0;
    private $valorFranqueadora = 0;

    function simularGeracao($request){

        $cidade = $request->get('cidade_id');
        $valor_medio_kw = (int)$request->get('monthly_usage');
        $this->potenciaModulo = $request->get('panel_potencia');


        $modulo = Modulo::where('id', '=', $request->modulo_id)->first();


        $cidade = Cidade::where('id', '=', $cidade)->first();
        $this->irradiacao_anual =  $this->getMediaAnualIrradiacao($cidade);
        $mediaForaPonta = $request->get('monthly_usage');
        $this->qtdModulos = $this->getQtdModulos(
            $valor_medio_kw,
            0,
            '4.6',
            $this->irradiacao_anual/1000,
            '30',
            (float)$modulo->rendimento -0.01,
            $modulo->area_geracao
        );

        //Verifico se o usuário não for da solar, pega os valores da franquia se não pega os valores da tabela "base_preco"
        //Corrigir isso não deveria pegar pelo id e sim verificar outro campo
        if(Auth::user()->franquia->franqueadora != 1){
            $inversores = array();
            //Calcula quantos inversores será necessário
            if($this->qtdModulos > 126)
            {
                $i = 0;
                for($i = $this->qtdModulos; $i >= 126; $i -=126 ){
                    if($i >126){
                        $basePrecoInversores = Auth::user()->franquia->basePrecoRevenda->basePrecoInversores()->where('max_modulos', '>=', 126)->first();
                        $inversores[] += $basePrecoInversores->valor;
                     }
                }
                $basePrecoInversores = Auth::user()->franquia->basePrecoRevenda->basePrecoInversores()->where('max_modulos', '>=', $i)->first();
                $inversores[] += $basePrecoInversores->valor;
            }else{
                $basePrecoInversores = Auth::user()->franquia->basePrecoRevenda->basePrecoInversores()->where('max_modulos', '>=', $this->qtdModulos)->first();
                $inversores[] += $basePrecoInversores->valor;
            }

            $basePrecoEstruturaEletrica = Auth::user()->franquia->basePrecoRevenda->basePrecoEstruturaEletrica()->where('max_modulos', '>=', $this->qtdModulos)->first();

            $basePrecoModulos = Auth::user()->franquia->basePrecoRevenda->basePrecoModulos()->first();

            if($request->has('produto1_preco')){
                $this->valorModulo = $request->get('produto1_preco');
            }else{
                $this->valorModulo = $basePrecoModulos->valor;
            }
            //dd($basePrecoModulos);
            $this->calculaGeracaoFranquia($inversores, $basePrecoEstruturaEletrica, $basePrecoModulos, $this->valorModulo );

            $precoModuloMaoObra = BasePrecoMaoObra::where('max_modulos', '>=', $this->qtdModulos)->first();
            $this->valorMaoObra = (int)$this->qtdModulos * $precoModuloMaoObra->valor;


        }else{
            $basePreco = BasePreco::where('kw_maximo', '>=' ,$valor_medio_kw)->where('modulo_id', '=', $modulo->id)->first();


            $this->valorModulo = $basePreco->valor_modulo;

            //Valida da hora de editar, se mudar o valor do modulo vai respitar o valor que digitou
            if($request->has('produto1_preco')){
                $basePreco->valor_modulo = floatval($request->get('produto1_preco')) ;
                $this->valorModulo = floatval($request->get('produto1_preco')) ;
                //dd($request->all());
            }

            $this->calculaGeracao($basePreco);
        }

        $potenciaGerador = $this->getGeradorKwp($this->qtdModulos, (int)$modulo->potencia);

        $area = $this->getArea($this->qtdModulos, '2.1', '1.15');

        $co2 = $this->getCo2($potenciaGerador);

        $geracaoEnergiaFV = $this->getGeracaoEnergiaFV($cidade, $this->qtdModulos, $modulo->area_total, $modulo->rendimento);

        $reducaoMediaConsumo = $this->getReducaoMediaConsumo($mediaForaPonta, '0',array_sum($geracaoEnergiaFV)/12 );
        
        return
            [
                'success' => true,
                'valor_modulo' => $this->valorModulo,
                'modulo_potencia' => $modulo->potencia,
                'qtd_modulos' => $this->qtdModulos,
                'potencia_gerador' => $potenciaGerador,
                'area_minima' => $area,
                'co2' => $co2,
                'valor_kw' => $valor_medio_kw,
                'total_investimento' => round($this->totalInvestimento, 2),
                'soma_modulos' =>  $this->somaModulos,
                'qtd_inversores' => $this->qtdInversores,
                'soma_inversor' => $this->somaInversor,
                'soma_estrutura' => $this->somaestrutura,
                'soma_infra' => $this->somaInfra,
                'soma_kit' => $this->somaKit,
                'reducao_media_consumo' => $reducaoMediaConsumo,
                'geracao_fv' => $geracaoEnergiaFV,
                'valor_mao_obra' => $this->valorMaoObra,
                'valor_franqueadora' =>  $this->valorFranqueadora,
                'total_equipamentos' =>
                    $this->somaModulos
                    + $this->somaInversor
                    + $this->somaestrutura
                    + $this->somaInfra
                    + $this->somaKit
            ];
    }

    private function calculaGeracao($basePreco){
        $this->somaModulos = $this->qtdModulos * $basePreco->valor_modulo;
        $this->qtdInversores = 1;
        $this->somaInversor = $this->somaModulos * $basePreco->inversor_mult;
        $this->somaestrutura = $this->somaModulos * $basePreco->estrutura_mult;
        $this->somaInfra = ($this->somaModulos + $this->somaInversor + $this->somaestrutura) * $basePreco->infra_mult;
        $this->somaKit = ($this->somaModulos + $this->somaInversor + $this->somaestrutura) * $basePreco->kit_moni_mult;
        $this->totalInvestimento = $this->somaModulos + $this->somaInversor + $this->somaestrutura + $this->somaInfra + $this->somaKit;
    }

    private function calculaGeracaoFranquia($inversor, $estruturaEletrica, $modulo, $valorModulo){
        $this->somaModulos = $this->qtdModulos * $valorModulo ;
        $this->qtdInversores = count($inversor);
        $this->somaInversor = array_sum($inversor);
        $this->valorModulo = $valorModulo;
        $this->somaestrutura = $this->qtdModulos * $estruturaEletrica->valor_estrutura;
        $this->somaInfra = $this->qtdModulos * $estruturaEletrica->valor_eletrica;
        $this->totalInvestimento = $this->somaModulos + $this->somaInversor + $this->somaestrutura + $this->somaInfra + $this->somaKit;
        $this->valorFranqueadora = ($modulo->valor * $this->qtdModulos) + $this->somaInversor + $this->somaestrutura + $this->somaInfra + $this->somaKit;

    }

    /*
     * Potência do gerador (KWp)
     */
    function getGeradorKwp($qtdModulos, $potencia){
        //dd(round($qtdModulos, 0));
        $result = ($qtdModulos * $potencia)/1000;
        return round($result, 2);
    }

    /*
     * MÓDULO FV DAH
     * Quantidade de módulos
     * 4.7 fator de compensaçao, 5,71 - irradiação media, 30 qtd de dias, 0,14 é o rendimento, e 1,7 area
     */
    function getQtdModulos($mediaMeses, $mediaMesesPonta, $fatorCompensacao, $irradiacao, $qtdDias, $rendimentoModulo, $areaModulo){
        //dd($irradiacao);
        $result = ($mediaMeses + $mediaMesesPonta * $fatorCompensacao) / ($irradiacao * $qtdDias * $rendimentoModulo * $areaModulo);
        $result = round($result, 0);
        if(($result % 2) == 0) {
            return round($result, 0);
        }else{
            return round($result, 0) + 1;
        }

    }

    /*
     * CONSUMO FORA DE PONTA
     * É a média aritimética de todos os consumos mensais
     */
    function getMediaMesesForaPonta($model){
        return $media = ($model->jan +
                $model->feb +
                $model->mar + $model->apr + $model->may + $model->jun + $model->jul + $model->aug + $model->sep + $model->oct + $model->nov + $model->dec)/12;
    }
    /*
    * CONSUMO NA PONTA
    * É a média aritimética de todos os consumos mensais
    */
    function getMediaMesesNaPonta($model){
        return $media = (
                $model->na_ponta_jan +
                $model->na_ponta_feb +
                $model->na_ponta_mar +
                $model->na_ponta_apr +
                $model->na_ponta_may +
                $model->na_ponta_jun +
                $model->na_ponta_jul +
                $model->na_ponta_aug +
                $model->na_ponta_sep +
                $model->na_ponta_oct +
                $model->na_ponta_nov +
                $model->na_ponta_dec
            )/12;
    }


    /*
    * Área ( m²)
     * Quantidade de módulos * área total do painel * sobra
    */
    function getArea($qtdModulos, $areaTotalModulo, $sobra ){
        $result = $qtdModulos * $areaTotalModulo * $sobra;
        return round($result, 1);
    }

    /*
     * Emissão de CO2 evitadas (KG/a )
     */
    function getCo2($potenciaGerador){
        $result = 464.3269 * $potenciaGerador;
        return round($result, 0);
    }

    function  getMediaAnualIrradiacao($cidade){
        return ($cidade->irradiacao_jan +
            $cidade->irradiacao_fev +
            $cidade->irradiacao_mar +
            $cidade->irradiacao_abri +
            $cidade->irradiacao_mai +
            $cidade->irradiacao_jun +
            $cidade->irradiacao_jul +
            $cidade->irradiacao_ago +
            $cidade->irradiacao_set +
            $cidade->irradiacao_out +
            $cidade->irradiacao_nov +
            $cidade->irradiacao_dez)/12;
    }

    /*
     * GERAÇÃO ENERGIA FV
     * Qtd de dias, irradiação no mês, área do módulo, e rendimento do módulo
     */
    function getGeracaoEnergiaFV($cidade, $qtdModulos, $areaModulo, $rendimento){
        $geracao = array();
        $irradiacao = array(
            ['irradiacao' => $cidade->irradiacao_jan, 'dias' => '30', 'rendimento' => $rendimento],
            ['irradiacao' => $cidade->irradiacao_fev, 'dias' => '28', 'rendimento' => $rendimento - 0.01],
            ['irradiacao' => $cidade->irradiacao_mar, 'dias' => '30', 'rendimento' => $rendimento - 0.01],
            ['irradiacao' => $cidade->irradiacao_abri, 'dias' => '30', 'rendimento' => $rendimento - 0.01],
            ['irradiacao' => $cidade->irradiacao_mai, 'dias' => '30', 'rendimento' => $rendimento - 0.01],
            ['irradiacao' => $cidade->irradiacao_jun, 'dias' => '30', 'rendimento' => $rendimento - 0.01],
            ['irradiacao' => $cidade->irradiacao_jul, 'dias' => '30', 'rendimento' => $rendimento - 0.01],
            ['irradiacao' => $cidade->irradiacao_ago, 'dias' => '30', 'rendimento' => $rendimento - 0.01],
            ['irradiacao' => $cidade->irradiacao_set, 'dias' => '30', 'rendimento' => $rendimento - 0.01],
            ['irradiacao' => $cidade->irradiacao_out, 'dias' => '30', 'rendimento' => $rendimento - 0.01],
            ['irradiacao' => $cidade->irradiacao_nov, 'dias' => '30', 'rendimento' => $rendimento],
            ['irradiacao' => $cidade->irradiacao_dez, 'dias' => '30', 'rendimento' => $rendimento]
        );

        for($i=0;$i<12;$i++){
            $result = $qtdModulos * $irradiacao[$i]['dias'] *  $irradiacao[$i]['irradiacao']/1000 * $areaModulo *  $irradiacao[$i]['rendimento'] ;
            array_push($geracao, round($result, 1));
        }
        //dd($geracao);
        return $geracao;
    }

    /*
     * MÉD REDUÇÃO DO CONSUMO (%)
     */
    function getReducaoMediaConsumo($mediaMes, $mediaMesesPonta, $mediaGeracaoEnergiaFV){
        //dd($mediaGeracaoEnergiaFV);
        $result = ($mediaGeracaoEnergiaFV * 100)/($mediaMes + ($mediaMesesPonta * 4.7) );
        return round($result, 2);
    }

}