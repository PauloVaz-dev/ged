var media_total = 0
var soma = 0


function somaServicos() {
    //produto6_nf =  document.getElementById('produto6_nf').value
    produto7_nf = document.getElementById('produto7_nf').value
    produto8_nf = document.getElementById('produto8_nf').value
    produto9_nf = document.getElementById('produto9_nf').value
    produto10_nf = document.getElementById('produto10_nf').value
    produto11_nf = document.getElementById('produto11_nf').value
    //produto12_nf = document.getElementById('produto12_nf').value
    soma_servico_operacional =  parseFloat(realDolar(produto7_nf)) + parseFloat(realDolar(produto8_nf)) + parseFloat(realDolar(produto9_nf)) + parseFloat(realDolar(produto10_nf)) + parseFloat(realDolar(produto11_nf))

    return soma_servico_operacional.toFixed(2)
}

function somaServicosEquipe() {
    //produto6_nf =  document.getElementById('produto6_nf').value
    produto7_nf = document.getElementById('produto7_nf').value
    produto8_nf = document.getElementById('produto8_nf').value
    produto9_nf = document.getElementById('produto9_nf').value
    produto10_nf = document.getElementById('produto10_nf').value
    produto11_nf = document.getElementById('produto11_nf').value
    equipe_tecnica = document.getElementById('equipe_tecnica').value

    soma_servico_operacional = parseFloat(realDolar(produto7_nf)) + parseFloat(realDolar(produto8_nf)) + parseFloat(realDolar(produto9_nf)) + parseFloat(realDolar(produto10_nf)) + parseFloat(realDolar(produto11_nf))

    return soma_servico_operacional.toFixed(2)
}

function somaEquipamentos() {
    //produto1_nf =  document.getElementById('produto1_nf').value
    //produto2_nf = document.getElementById('produto2_nf').value
    //produto3_nf = document.getElementById('produto3_nf').value
    //produto4_nf = document.getElementById('produto4_nf').value
    //produto5_nf = document.getElementById('produto5_nf').value
    //desconto_equipamentos = document.getElementById('desconto_equipamentos').value
    //console.log(produto1_nf)

    //soma_equipamentos =  parseFloat(realDolar(produto1_nf)) + parseFloat(realDolar(produto2_nf)) + parseFloat(realDolar(produto3_nf)) + parseFloat(realDolar(produto4_nf)) + parseFloat(realDolar(produto5_nf))

    //return soma_equipamentos.toFixed(2)
}


function calculaServicosEquipamentosDescontos() {
    (
        parseFloat(this.somaServicos()) +
        parseFloat(realDolar(valor_descontos))
    ).toFixed(2)

}
function atualizaValores(){
    var preco_medio_instalado = document.getElementById('preco_medio_instalado').value
    var valor_descontos = document.getElementById('valor_descontos').value
    var valor_franqueadora = document.getElementById('valor_franqueadora').value
    var valor_franquia = document.getElementById('valor_franquia').value
    var royalties = document.getElementById('royalties').value
    //var desconto_equipamentos = document.getElementById('desconto_equipamentos').value

    var total_equipamentos = document.getElementById('total_equipamentos').value
   /* var produto12_nf = document.getElementById('produto12_nf').value
    var equipe_tecnica = document.getElementById('equipe_tecnica').value*/


    //var produto7_nf = document.getElementById('produto7_nf').value
    //this.calculaDescontos()
    if(valor_descontos == "") valor_descontos = 0
    if(valor_franquia == "") valor_franquia = 0
    if(equipe_tecnica == "") equipe_tecnica = 0

    var valor_proposta = (parseFloat(this.somaServicos()) - parseFloat(realDolar(valor_descontos))).toFixed(2)

    document.getElementsByClassName('total_servico_operacional')[0].innerHTML = 'R$ ' + formatMoney(this.somaServicos())
    document.getElementById('total_servico_operacional').value = this.somaServicos()


    //Detalhamento dos equipamentos
    document.getElementsByClassName('total_equipamentos')[0].innerHTML = 'R$ ' + total_equipamentos


    //Valor Proposta
    document.getElementsByClassName('span_preco_medio_instalado')[0].innerHTML = 'R$ ' + preco_medio_instalado


    percentualKitParticipacao = (parseFloat(realDolar(valor_franquia)) / parseFloat(valor_franqueadora) * 100).toFixed(0)
    document.getElementsByClassName('span_valor_franqueadora')[0].innerHTML = 'R$ ' + formatMoney(parseFloat(valor_franqueadora))

    var totalServicos = this.somaServicosEquipe()

    //console.log(parseFloat(totalServicos) +  parseFloat(realDolar(equipe_tecnica)))

    document.getElementsByClassName('equipe_tecnica')[0].innerHTML = 'R$ ' + formatMoney(parseFloat(totalServicos) +  parseFloat(realDolar(equipe_tecnica)))

    document.getElementsByClassName('participacao')[0].innerHTML = 'R$ ' + formatMoney(parseFloat(realDolar(valor_franquia)) - parseFloat(realDolar(valor_descontos))) + " (" + percentualKitParticipacao + "%)"

    document.getElementsByClassName('royalties')[0].innerHTML = 'R$ ' + royalties + " "  + "Royalties"

    console.log( percentualKitParticipacao )
}




/*
/ Serviços Operacionais
 */

$("#produto8_nf, #produto9_nf, #produto10_nf, #produto11_nf" ).on('change', function () {
    // qtd_inst_pde = $('input[name=qtd_inst_pde]').val()
    // produto8_preco = $('input[name=produto8_preco]').val()
    // produto8_nf = qtd_inst_pde * realDolar(produto8_preco)
    // $('input[name=produto8_nf]').val(formatMoney(produto8_nf))
    atualizaValores()
}).change();

window.addEventListener('load', function() {
    var valor_descontos = document.getElementById('valor_descontos').value
    this.atualizaValores()

})





