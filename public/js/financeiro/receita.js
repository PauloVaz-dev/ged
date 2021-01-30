$(document).ready(function(){
    $('.lancamentos-note').hide()
    $('.lancamentos-repeat').hide()
});

document.getElementById('btn-receita').addEventListener('click', function (ev) {
    $('#formModalReceita').modal()

    $.ajax({
        url: "/index.php/financeiro/paramsdefault",
        dataType: "json",
        success: function( result ) {
            console.log(result.categories)
            var despesa = result.categories.filter((categoria) => {
                return parseInt(categoria.parent_id) === 11;
        })

            var receita = result.categories.filter((categoria) => {
                return parseInt(categoria.parent_id) === 12;
        })

            console.log(receita, despesa)

            document.getElementById('category-receitas').innerHTML = ''
            receita.forEach(function (param) {
                $('#category-receitas').append('<option value=' + param.id + ">"+ param.name + '</option>')
            })
            result.contas.forEach(function (param) {
                $('#conta').append('<option value=' + param.id + ">"+ param.name + '</option>')
            })
        }
    });
})


document.getElementById('btn-note').addEventListener('click', function (ev) {
    var x = document.getElementById("note");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
})

document.getElementById('btn-repeat').addEventListener('click', function (ev) {
    var x = document.getElementById("repeat");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
})




$('.btn-save-receita').click(function (event) {
    var btn = $(this);
    btn.button('loading');

    var description = $('input[name=description]').val()
    var projeto_id = $('input[name=projeto_id]').val()
    var valor = $('input[name=valor]').val()
    var data_vencimento = $('input[name=data_vencimento]').val()
    var conta = $('select[name=conta] option:selected').val();
    var category = $('select[name=category] option:selected').val();
    var lancamento_obs = $('textarea[name=lancamento_obs]').val()

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value

        }
    });
    data = {
        'description': description,
        'projeto_id': projeto_id,
        'tipo_id': 1,
        'data_vencimento': dateToEN(data_vencimento),
        'valor': realDolar(valor),
        'conta_id': conta,
        'category_id': category,
        'lancamento_obs': lancamento_obs,
        'status_id': 2
    }

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/financeiro',
        datatype: 'json',
        data: data,
    }).done(function (retorno) {
        if(retorno.success) {
            swal('', "Cadastro realizado com sucesso", "success");
            btn.button('reset');
        } else {
            swal("Error", "Click no botão abaixo!", "error");
        }
    });
})

function realDolar(valor) {
    valor = valor.replace(".","");
    if (valor.length > 10) {
        valor = valor.replace(".","");

    }
    valor = valor.replace(",",".");
    //console.log(valor)
    return valor;
}


/*
Despesas
 */

document.getElementById('btn-despesa').addEventListener('click', function (ev) {
    $('#formModalDespesa').modal()

    $.ajax({
        url: "/index.php/financeiro/paramsdefault",
        dataType: "json",
        success: function( result ) {
            console.log(result.categories)
            var despesa = result.categories.filter((categoria) => {
                return parseInt(categoria.parent_id) === 11;
        })

            var receita = result.categories.filter((categoria) => {
                return parseInt(categoria.parent_id) === 12;
        })

            console.log(receita, despesa)

            document.getElementById('category-despesas').innerHTML = ''
            despesa.forEach(function (param) {
                $('#category-despesas').append('<option value=' + param.id + ">"+ param.name + '</option>')
            })
            result.contas.forEach(function (param) {
                $('#conta').append('<option value=' + param.id + ">"+ param.name + '</option>')
            })
        }
    });
})


