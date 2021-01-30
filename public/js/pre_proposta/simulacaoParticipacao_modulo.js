var media_total = 0
var soma = 0


function somaServicos() {
    produto6_nf =  document.getElementById('produto6_nf').value
    produto7_nf = document.getElementById('produto7_nf').value
    produto8_nf = document.getElementById('produto8_nf').value
    produto9_nf = document.getElementById('produto9_nf').value
    produto10_nf = document.getElementById('produto10_nf').value
    produto11_nf = document.getElementById('produto11_nf').value
    produto12_nf = document.getElementById('produto12_nf').value
    soma_servico_operacional =  parseFloat(realDolar(produto6_nf)) + parseFloat(realDolar(produto7_nf)) + parseFloat(realDolar(produto8_nf)) + parseFloat(realDolar(produto9_nf)) + parseFloat(realDolar(produto10_nf)) + parseFloat(realDolar(produto11_nf)) + parseFloat(realDolar(produto12_nf))
    console.log(produto12_nf)
    return soma_servico_operacional.toFixed(2)
}

function somaEquipamentos() {
    produto1_nf =  document.getElementById('produto1_nf').value
    produto2_nf = document.getElementById('produto2_nf').value
    produto3_nf = document.getElementById('produto3_nf').value
    produto4_nf = document.getElementById('produto4_nf').value
    produto5_nf = document.getElementById('produto5_nf').value
    desconto_equipamentos = document.getElementById('desconto_equipamentos').value
    //console.log(produto1_nf)

    soma_equipamentos =  parseFloat(realDolar(produto1_nf)) + parseFloat(realDolar(produto2_nf)) + parseFloat(realDolar(produto3_nf)) + parseFloat(realDolar(produto4_nf)) + parseFloat(realDolar(produto5_nf)) - parseFloat(realDolar(desconto_equipamentos))

    return soma_equipamentos.toFixed(2)
}

function calculaDescontos(){
    var somaEquipamentos = this.somaEquipamentos()
    var valor_descontos = document.getElementById('valor_descontos').value
    if(valor_descontos == "") valor_descontos = 0

    total = parseFloat(somaEquipamentos) - parseFloat(realDolar(valor_descontos))
    document.getElementById('preco_medio_instalado').value = formatMoney(total)

    $('.total_equipamentos span').text( 'R$ ' + formatMoney(total) )

   /* var preco_medio_instalado = document.getElementById('preco_medio_instalado').value
    $('.total_equipamentos span').text( 'R$ ' + formatMoney(realDolar(preco_medio_instalado) - realDolar(valor_descontos))  )
    document.getElementById('preco_medio_instalado').value = formatMoney(realDolar(preco_medio_instalado) - realDolar(valor_descontos))*/
}

function calculaServicosEquipamentosDescontos() {
    (
        parseFloat(this.somaServicos()) +
        parseFloat(this.somaEquipamentos()) -
        parseFloat(realDolar(valor_descontos))
    ).toFixed(2)

}
function atualizaValores(){
    var valor_descontos = document.getElementById('valor_descontos').value
    var valor_franqueadora = document.getElementById('valor_franqueadora').value
    var desconto_equipamentos = document.getElementById('desconto_equipamentos').value
    var total_equipamentos = document.getElementById('total_equipamentos').value

   // console.log( parseFloat(valor_franqueadora) - parseFloat(realDolar(desconto_equipamentos)) )

   // console.log(  parseFloat(realDolar(valor_franqueadora)), parseFloat(realDolar(valor_franqueadora)) - parseFloat(realDolar(desconto_equipamentos)) )
    var produto7_nf = document.getElementById('produto7_nf').value
    //this.calculaDescontos()
    if(valor_descontos == "") valor_descontos = 0

    var valor_proposta = (parseFloat(this.somaServicos()) + parseFloat(this.somaEquipamentos()) - parseFloat(realDolar(valor_descontos))).toFixed(2)

    //console.log(parseFloat(valor_proposta) - parseFloat(valor_franqueadora) - parseFloat(realDolar(produto7_nf)))

    document.getElementsByClassName('total_servico_operacional')[0].children[0].innerHTML = 'R$ ' + formatMoney(this.somaServicos())
    document.getElementById('total_servico_operacional').value = this.somaServicos()
    document.getElementsByClassName('total_equipamentos')[0].children[0].innerHTML = 'R$ ' + formatMoney(this.somaEquipamentos())
    document.getElementById('total_equipamentos').value = formatMoney(this.somaEquipamentos())

    document.getElementsByClassName('span_preco_medio_instalado')[0]
        .children[0].innerHTML = 'R$ ' + formatMoney(valor_proposta)
    document.getElementById('preco_medio_instalado').value = formatMoney(valor_proposta)

    document.getElementsByClassName('span_valor_franqueadora')[0].children[0].innerHTML = 'R$ ' + formatMoney(parseFloat(valor_franqueadora) - parseFloat(realDolar(desconto_equipamentos)))

    var totalServicos = this.somaServicos()

    document.getElementsByClassName('equipe_tecnica')[0].children[0].innerHTML = 'R$ ' + formatMoney(totalServicos)

    //console.log(parseFloat(this.somaEquipamentos()) - parseFloat(valor_franqueadora))

    //var total_equipamentos2 = document.getElementById('total_equipamentos').value

    //console.log(valor_proposta, valor_franqueadora, totalServicos, desconto_equipamentos, realDolar(desconto_equipamentos))
    //console.log(parseFloat(valor_proposta) , parseFloat(valor_franqueadora) , parseFloat(totalServicos) , parseFloat(realDolar(desconto_equipamentos)))


    document.getElementsByClassName('participacao')[0].children[0].innerHTML = 'R$ ' + formatMoney(parseFloat(valor_proposta) - parseFloat(valor_franqueadora) - parseFloat(totalServicos) + parseFloat(realDolar(desconto_equipamentos)))


}

$("#produto1_preco, #qtd_paineis, #desconto_equipamentos").on('change', function () {
    //console.log("ssssssssss");
    qtd_paineis = $('input[name=qtd_paineis]').val()
    produto1_preco = $('input[name=produto1_preco]').val()
    produto6_nf = qtd_paineis * realDolar(produto1_preco)
    $('input[name=produto1_nf]').val(formatMoney(produto6_nf))
    atualizaValores()
}).change();

/*
/ Serviços Operacionais
 */
$("#produto6_preco, #qtd_homologacao").on('change', function () {
    qtd_homologacao = $('input[name=qtd_homologacao]').val()
    produto6_preco = $('input[name=produto6_preco]').val()
    produto6_nf = qtd_homologacao * realDolar(produto6_preco)
    $('input[name=produto6_nf]').val(formatMoney(produto6_nf))
    atualizaValores()
}).change();

$("#produto7_preco, #qtd_mao_obra").on('change', function () {
    qtd_mao_obra = $('input[name=qtd_mao_obra]').val()
    produto7_preco = $('input[name=produto7_preco]').val()
    produto7_nf = qtd_mao_obra * realDolar(produto7_preco)
    $('input[name=produto7_nf]').val(formatMoney(produto7_nf))
    atualizaValores()
}).change();

$("#produto8_preco, #qtd_inst_pde").on('change', function () {
    qtd_inst_pde = $('input[name=qtd_inst_pde]').val()
    produto8_preco = $('input[name=produto8_preco]').val()
    produto8_nf = qtd_inst_pde * realDolar(produto8_preco)
    $('input[name=produto8_nf]').val(formatMoney(produto8_nf))
    atualizaValores()
}).change();

$("#produto9_preco, #qtd_mud_pde").on('change', function () {
    qtd_mud_pde = $('input[name=qtd_mud_pde]').val()
    produto9_preco = $('input[name=produto9_preco]').val()
    produto9_nf = qtd_mud_pde * realDolar(produto9_preco)
    $('input[name=produto9_nf]').val(formatMoney(produto9_nf))
    atualizaValores()
}).change();

$("#produto10_preco, #qtd_substacao").on('change', function () {
    qtd_substacao = $('input[name=qtd_substacao]').val()
    produto10_preco = $('input[name=produto10_preco]').val()
    produto10_nf = qtd_substacao * realDolar(produto10_preco)
    $('input[name=produto10_nf]').val(formatMoney(produto10_nf))
    atualizaValores()
}).change();

$("#produto11_preco, #qtd_refor_estrutura").on('change', function () {
    qtd_refor_estrutura = $('input[name=qtd_refor_estrutura]').val()
    produto11_preco = $('input[name=produto11_preco]').val()
    produto11_nf = qtd_refor_estrutura * realDolar(produto11_preco)
    $('input[name=produto11_nf]').val(formatMoney(produto11_nf))
    atualizaValores()
}).change();

$("#produto12_preco, #qtd_homologacao_projeto").on('change', function () {
    //console.log("ddddddddd")
    qtd_homologacao_projeto = document.getElementById('qtd_homologacao_projeto').value
    produto12_preco = document.getElementById('produto12_preco').value
    produto12_nf = qtd_homologacao_projeto * parseFloat(realDolar(produto12_preco))
    $('input[name=produto12_nf]').val(formatMoney(produto12_nf))
    atualizaValores()
}).change();

window.addEventListener('load', function() {
    var valor_descontos = document.getElementById('valor_descontos').value
    this.atualizaValores()
   /* document.getElementsByClassName('total_servico_operacional')[0].children[0].innerHTML = 'R$ ' + formatMoney(this.somaServicos())
    document.getElementsByClassName('span_preco_medio_instalado')[0]
        .children[0].innerHTML = 'R$ ' + (  parseFloat(this.somaServicos()) + parseFloat(this.somaEquipamentos()) - parseFloat(realDolar(valor_descontos))).toFixed(2)*/

})





