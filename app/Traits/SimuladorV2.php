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
use Serbinario\Entities\Vendas\CaboModulo;
use Serbinario\Entities\Vendas\InversorModulo;
use Serbinario\Entities\Vendas\MaoObraModulos;
use Serbinario\Entities\Vendas\Produto;
use Serbinario\Entities\Vendas\StringboxPotencia;

trait SimuladorV2
{
    private $valorModulo = 0;
    private $somaModulos = 0;
    private $somaInversor = 0;
    private $somaEstrutura = 0;
    private $somaString = 0;
    private $somaKit = 0;
    private $totalInvestimento = 0;
    private $qtdModulos = 0;
    private $qtdInversores = 1;
    private $irradiacao_anual = 0;
    private $potenciaModulo = 0;
    private $valorMaoObra = 0;
    private $valorMaoObraPorModulo = 0;
    private $valorFranqueadora = 0;
    private $inversores = 0;
    private $mc4 = 0;

    function simularGeracao($request){

        $cidade = $request->get('cidade_id');
        $estado_id = $request->get('estado_id');

        $valor_medio_kw = (int)$request->get('monthly_usage');
        $this->potenciaModulo = $request->get('modulo_id');
        $precoKwh = $request->get('preco_kwh');

        $modulo = Modulo::where('id', '=', $request->modulo_id)->first();

        $cidade = Cidade::where('id', '=', $cidade)->where('estado_id', '=', $estado_id)->first();

            //dd($cidade);

        $this->irradiacao_anual =  $this->getMediaAnualIrradiacao($cidade);

        //dd($this->irradiacao_anual);
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


        $this->inversores = $this->calculaQtdInversores($modulo->id);
        $this->qtdInversores = count($this->inversores );

        //MÓDULO FOTOVOLTAICO POLICRITALINO SOLAR 330W - DAH = id = 2
        if($this->potenciaModulo == 1){
            $this->valorModulo =  Produto::select('preco_franquia')->where('id' , '=', '2')->first()->preco_franquia;
            $ModuloFabricante =  Produto::with('marca')->where('id' , '=', 2)->first()->marca->marca;
        }else{
            $this->valorModulo =  Produto::select('preco_franquia')->where('id' , '=', '1')->first()->preco_franquia;
            $ModuloFabricante =  Produto::with('marca')->where('id' , '=', 1)->first()->marca->marca;
        }


        //Salva a quantidade de MC4 e a soma do inversor
        foreach ($this->inversores as $inversor){
            $this->mc4 += $inversor['mc4'];
            $this->somaInversor += $inversor['valor'];
        }

        $obs = "INVERSOR KSTAR ";
        $array = $this->inversores;
        for($i=0; $i < count($array); $i++ ){
            $obs .= $array[$i]['potenciaInversor'] . "k";
            $i < count($array) -1 ? $obs .= " + ": "";
        }

        $this->somaModulos = $this->calculaModulos($this->valorModulo);
        $this->somaEstrutura = $this->calculaEsttutura();
        $this->somaString = $this->calculaString();

        $this->valorMaoObra = $this->calculaMaoObra($modulo->id);

        $this->totalInvestimento = $this->somaModulos + $this->somaInversor + $this->somaEstrutura + $this->somaString +  $this->valorMaoObra;

        //dd($modulo->potencia);
        $potenciaGerador = $this->getGeradorKwp($this->qtdModulos, (int)$modulo->potencia);
        //dd($potenciaGerador, $this->qtdModulos);
        $area = $this->getArea($this->qtdModulos, '2.1', '1.15');

        $co2 = $this->getCo2($potenciaGerador);

        $geracaoEnergiaFV = $this->getGeracaoEnergiaFV($cidade, $this->qtdModulos, $modulo->area_total, $modulo->rendimento);



        $reducaoMediaConsumo = $this->getReducaoMediaConsumo($mediaForaPonta, '0',array_sum($geracaoEnergiaFV)/12 );


        $reducaoMediaConsumo > 107.8 ? $reducaoMediaConsumo = 106.47 : "";


        $roi = $this->roi($precoKwh, $this->totalInvestimento, $valor_medio_kw);

        return
            [
                'success' => true,
                'valor_modulo' => $this->valorModulo,
                'modulo_potencia' => $modulo->potencia,
                'qtd_modulos' => $this->qtdModulos,
                'modulo_marca' => $ModuloFabricante,
                'potencia_gerador' => $potenciaGerador,
                'area_minima' => $area,
                'co2' => $co2,
                'valor_kw' => $valor_medio_kw,
                'preco_kwh' => $precoKwh,
                'roi' => $roi,

                //Equipamentos
                'soma_modulos' =>  $this->somaModulos,
                'qtd_inversores' => $this->qtdInversores,
                'soma_inversor' => $this->somaInversor,
                'soma_estrutura' => $this->somaEstrutura,
                'soma_string' => $this->somaString,
                'total_equipamentos' =>
                    $this->somaModulos
                    + $this->somaInversor
                    + $this->somaEstrutura
                    + $this->somaString,

                //Seviço Operacional
                'valor_mao_obra' =>  $this->valorMaoObra,
                'valor_mao_obra_por_modulo' => $this->valorMaoObraPorModulo,
                'total_investimento' => round($this->totalInvestimento, 2),

                'inversores' => $this->inversores,
                'reducao_media_consumo' => $reducaoMediaConsumo,
                'geracao_fv' => $geracaoEnergiaFV,
                'valor_franqueadora' =>  $this->valorFranqueadora,
                'irradiacao_anual' => $this->irradiacao_anual,
                'obs' => $obs

            ];
    }

    private function roi($precoKwh, $totalInvestimento, $valor_medio_kw){

        return round($totalInvestimento / ((float)$valor_medio_kw  * 0.79 * 12)  , 1);

    }

    private function calculaEsttutura(){
        // PERFIL RETANGULAR ALUMINIO 3M - id = 15
        $perfilQtd = (($this->qtdModulos * 2) /3)* 1.1;
        $perfilValor = Produto::select('preco_franquia')->where('id' , '=', '15')->first()->preco_franquia;
        $PerfilTotal = $perfilQtd * $this->convertesRealIngles($perfilValor);
        //dd($perfilQtd, $perfilValor, $PerfilTotal);

        //ANCORAGEM L GALVANIZADA
        //$ancoragemQtd = (($this->qtdModulos * 2) /1.3)* 1.1;
        //$ancoragemValor = Produto::select('preco_franquia')->where('id' , '=', '12')->first()->preco_franquia;
        //$ancoragemTotal = $ancoragemQtd * $this->convertesRealIngles($ancoragemValor);
        //dd($ancoragemQtd, $ancoragemValor, $ancoragemTotal);

        //PARAFUSO ESTRUTURAL 250MM METAL id = 38
        $parafusoQtd = (($this->qtdModulos * 2) /1.3)* 1.1;
        $parafusoValor = Produto::select('preco_franquia')->where('id' , '=', '38')->first()->preco_franquia;
        $parafusoTotal = $parafusoQtd * $this->convertesRealIngles($parafusoValor);
        //dd($parafusoQtd, $parafusoValor, $parafusoTotal);

        //CHAPAS INTERMERDIARIA QUADRADA ALUMINIO id = 39
        $chapaInterQtd = ($this->qtdModulos * 2) -2;
        $chapaInterValor = Produto::select('preco_franquia')->where('id' , '=', '39')->first()->preco_franquia;
        $chapaInterTotal = $chapaInterQtd * $this->convertesRealIngles($chapaInterValor);
        //dd($chapaInterQtd, $chapaInterValor, $chapaInterTotal);

        //FIXADOR ALUMINIO ( L ) id 40
        $fixadorAluQtd = ($this->qtdModulos /8) * 4;
        $fixadorAluValor = Produto::select('preco_franquia')->where('id' , '=', '40')->first()->preco_franquia;
        $fixadorAluTotal = $fixadorAluQtd * $this->convertesRealIngles($fixadorAluValor);
        //dd($fixadorAluQtd, $fixadorAluValor, $fixadorAluTotal);

        //PARAFUSO AUTOBROCANTE 12 x 4'' CT - id = 13
        $parafusAuto12x4Qtd = (int)($this->qtdModulos/20);
        $parafusAuto12x4Valor = Produto::select('preco_franquia')->where('id' , '=', '13')->first()->preco_franquia;
        $parafusAuto12x4Total = $parafusAuto12x4Qtd * $this->convertesRealIngles($parafusAuto12x4Valor);
        //dd($parafusAuto12x4Qtd, $parafusAuto12x4Valor, $parafusAuto12x4Total);

        //PARAFUSO AUTOBROCANTE 12x 2.1/2'' CT id = 14
        $parafusAuto12x2Qtd = (int)($this->qtdModulos/20);
        $parafusAuto12x2Valor = Produto::select('preco_franquia')->where('id' , '=', '14')->first()->preco_franquia;
        $parafusAuto12x2Total = $parafusAuto12x2Qtd * $this->convertesRealIngles($parafusAuto12x2Valor);
        //dd($parafusAuto12x2Qtd, $parafusAuto12x2Valor, $parafusAuto12x2Total);

        //SELANTE PU 300G - id = 18
        $selanteQtd = ($this->qtdModulos/10);
        $selanteValor = Produto::select('preco_franquia')->where('id' , '=', '18')->first()->preco_franquia;
        $selanteTotal = $selanteQtd * $this->convertesRealIngles($selanteValor);
        //dd($selanteQtd, $selanteValor, $selanteTotal);

        //dd($PerfilTotal , $ancoragemTotal , $parafusoTotal , $chapaInterTotal , $fixadorAluTotal , $parafusAuto12x4Total , $parafusAuto12x2Total , $selanteTotal);
        return  round($PerfilTotal + $parafusoTotal + $chapaInterTotal + $fixadorAluTotal + $parafusAuto12x4Total + $parafusAuto12x2Total + $selanteTotal, 2);


    }

    private function calculaMaoObra($id){
        $this->valorMaoObraPorModulo = MaoObraModulos::select('valor_mao_obra')->where('modulo_id', '=', $id)->where('max_modulos' , '>=', $this->qtdModulos )->orderBy('max_modulos', 'asc')->first()->valor_mao_obra;
        //dd($valorMaoObra);
        return $this->qtdModulos * $this->valorMaoObraPorModulo;
    }

    private function calculaString(){
        //STRINGBOX
        $stringQtd = 0;
        $stringValor = 0;
        $stringTotal = 0;
        foreach ($this->inversores as $inversor){

            $stringValor = StringboxPotencia::with('produto')->where('potencia' , '=',  $inversor['potenciaInversor']  )->first()->produto->preco_revenda;

            $stringTotal += $this->convertesRealIngles($stringValor) * $inversor['stringbox'];

            $stringQtd += $inversor['stringbox'];

        }


        //CABO 4MM BRASFIO 1KV - COBRE / PRETO - id = 42
        if($this->qtdModulos > 400 ){
            $metros = $this->qtdModulos * 1.4;
        }else{
            $metros = CaboModulo::where('max_modulos', '>=', $this->qtdModulos)->first()->metros;
        }
        $caboValor = Produto::select('preco_franquia')->where('id' , '=', '42')->first()->preco_franquia;
        $caboTotal = (int)$metros * $this->convertesRealIngles($caboValor);
        //dd($metros, $caboValor, $caboTotal);

        //CONECTOR MC4 id = 41
        $conectorQtd = $this->mc4;
        $conectorValor = Produto::select('preco_franquia')->where('id' , '=', '41')->first()->preco_franquia;
        $conectorTotal = $conectorQtd * $this->convertesRealIngles($conectorValor);

            //dd($stringTotal , $caboTotal , $conectorTotal);
        return $stringTotal + $caboTotal + $conectorTotal;

    }

    private function calculaModulos($valorModulo){

        return $this->qtdModulos *  $this->convertesRealIngles($valorModulo);
    }

    private function calculaQtdInversores($id){
        $inversores = array();


        //Regra para módulo 330
        if($this->qtdModulos >= 21 && $this->qtdModulos <= 30 && $id = 1){
            $resultado = $this->qtdModulos - 20;
            $basePrecoInversores = InversorModulo::with('produto')->where('modulo_id', '=', $id)->where('max_modulos', '>=', 20)->first();
            $precoInversor = $this->convertesRealIngles($basePrecoInversores->produto->preco_franquia);
            $inversores[] = [ 'valor' => $precoInversor, 'id' => $basePrecoInversores->produto->id, 'potenciaInversor' => $basePrecoInversores->potencia_inversor, 'mc4' => $basePrecoInversores->mc4, 'stringbox' => $basePrecoInversores->stringbox   ];

            $basePrecoInversores = InversorModulo::with('produto')->where('modulo_id', '=', $id)->where('max_modulos', '>=', $resultado)->first();
            $precoInversor = $this->convertesRealIngles($basePrecoInversores->produto->preco_franquia);
            $inversores[] = [ 'valor' => $precoInversor, 'id' => $basePrecoInversores->produto->id, 'potenciaInversor' => $basePrecoInversores->potencia_inversor, 'mc4' => $basePrecoInversores->mc4, 'stringbox' => $basePrecoInversores->stringbox   ];

            return $inversores;
        }

        if($this->qtdModulos > 126 && $id == 1){
            $i = 0;
            for($i = $this->qtdModulos; $i >= 126; $i -=126 ){
                if($i >126){
                    $basePrecoInversores = InversorModulo::with('produto')->where('modulo_id', '=', $id)->where('max_modulos', '>=', 126)->first();
                    //dd($basePrecoInversores);
                    $precoInversor = $this->convertesRealIngles($basePrecoInversores->produto->preco_franquia);
                    $inversores[] = [ 'valor' => $precoInversor, 'id' => $basePrecoInversores->produto->id, 'potenciaInversor' => $basePrecoInversores->potencia_inversor, 'mc4' => $basePrecoInversores->mc4, 'stringbox' => $basePrecoInversores->stringbox   ];
                }
            }
            $basePrecoInversores = InversorModulo::with('produto')->where('modulo_id', '=', $id)->where('max_modulos', '>=', $i)->first();
            $precoInversor = $this->convertesRealIngles($basePrecoInversores->produto->preco_franquia);
            $inversores[] = [ 'valor' => $precoInversor, 'id' => $basePrecoInversores->produto->id, 'potenciaInversor' => $basePrecoInversores->potencia_inversor, 'mc4' => $basePrecoInversores->mc4, 'stringbox' => $basePrecoInversores->stringbox   ];
        }elseif($id == 1){


            $basePrecoInversores = InversorModulo::with('produto')->where('modulo_id', '=', $id)->where('max_modulos', '>=', $this->qtdModulos)->first();
            $precoInversor = $this->convertesRealIngles($basePrecoInversores->produto->preco_franquia);
            $inversores[] = [ 'valor' => $precoInversor, 'id' => $basePrecoInversores->produto->id, 'potenciaInversor' => $basePrecoInversores->potencia_inversor, 'mc4' => $basePrecoInversores->mc4, 'stringbox' => $basePrecoInversores->stringbox   ];
        }

        if($this->qtdModulos > 108 && $id == 2){
            $i = 0;
            for($i = $this->qtdModulos; $i >= 108; $i -=108 ){
                if($i >108){
                    $basePrecoInversores = InversorModulo::with('produto')->where('modulo_id', '=', $id)->where('max_modulos', '>=', 108)->first();
                    //dd($basePrecoInversores);
                    $precoInversor = $this->convertesRealIngles($basePrecoInversores->produto->preco_franquia);
                    $inversores[] = [ 'valor' => $precoInversor, 'id' => $basePrecoInversores->produto->id, 'potenciaInversor' => $basePrecoInversores->potencia_inversor, 'mc4' => $basePrecoInversores->mc4, 'stringbox' => $basePrecoInversores->stringbox   ];
                }
            }
            $basePrecoInversores = InversorModulo::with('produto')->where('modulo_id', '=', $id)->where('max_modulos', '>=', $i)->first();
            $precoInversor = $this->convertesRealIngles($basePrecoInversores->produto->preco_franquia);
            $inversores[] = [ 'valor' => $precoInversor, 'id' => $basePrecoInversores->produto->id, 'potenciaInversor' => $basePrecoInversores->potencia_inversor, 'mc4' => $basePrecoInversores->mc4, 'stringbox' => $basePrecoInversores->stringbox   ];
        }elseif($id == 2){


            $basePrecoInversores = InversorModulo::with('produto')->where('modulo_id', '=', $id)->where('max_modulos', '>=', $this->qtdModulos)->first();
            $precoInversor = $this->convertesRealIngles($basePrecoInversores->produto->preco_franquia);
            $inversores[] = [ 'valor' => $precoInversor, 'id' => $basePrecoInversores->produto->id, 'potenciaInversor' => $basePrecoInversores->potencia_inversor, 'mc4' => $basePrecoInversores->mc4, 'stringbox' => $basePrecoInversores->stringbox   ];
        }



        return $inversores;
    }

    private function calculaGeracao($basePreco){
        $this->somaModulos = $this->qtdModulos * $basePreco->valor_modulo;
        $this->qtdInversores = 1;
        $this->somaInversor = $this->somaModulos * $basePreco->inversor_mult;
        $this->somaEstrutura = $this->somaModulos * $basePreco->estrutura_mult;
        $this->somaInfra = ($this->somaModulos + $this->somaInversor + $this->somaEstrutura) * $basePreco->infra_mult;
        $this->somaKit = ($this->somaModulos + $this->somaInversor + $this->somaEstrutura) * $basePreco->kit_moni_mult;
        $this->totalInvestimento = $this->somaModulos + $this->somaInversor + $this->somaEstrutura + $this->somaInfra + $this->somaKit;
    }

    private function calculaGeracaoFranquia($inversor, $estruturaEletrica, $modulo, $valorModulo){
        $this->somaModulos = $this->qtdModulos * $valorModulo ;
        $this->qtdInversores = count($inversor);
        $this->somaInversor = array_sum($inversor);
        $this->valorModulo = $valorModulo;
        $this->somaEstrutura = $this->qtdModulos * $estruturaEletrica->valor_estrutura;
        $this->somaInfra = $this->qtdModulos * $estruturaEletrica->valor_eletrica;
        $this->totalInvestimento = $this->somaModulos + $this->somaInversor + $this->somaEstrutura + $this->somaInfra + $this->somaKit;
        $this->valorFranqueadora = ($modulo->valor * $this->qtdModulos) + $this->somaInversor + $this->somaEstrutura + $this->somaInfra + $this->somaKit;

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

    function convertesRealIngles($value){
        $var = str_replace(".","",$value);
        return str_replace(",",".",$var);
    }




}