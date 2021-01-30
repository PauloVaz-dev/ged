$(document).ready(function () {


    //Consulta o CPF?CNPJ
    $("input[name=cpf_cnpj]").blur(function(){

        //Recupera o id do registro
        var cpf_cnpj = document.getElementById("cpf_cnpj");
        cpf_cnpj  = cpf_cnpj.value;

        console.log($('input[name="_token"]').val())

        //Necessario para que o ajax envie o csrf-token
        //Para isso coloquei no form <meta name="csrf-token" content="{{ csrf_token() }}">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });

        var dados = {
            'cpf_cnpj': cpf_cnpj
        }

        jQuery.ajax({
            type: 'POST',
            data: dados,
            url: '/index.php/consultaCpfCnpf'
        }).done(function (retorno) {

            if(retorno.success) {
                swal(retorno.msg, "Click no botão abaixo!", "error");
                //$("input#cpf_cnpj").val( "" );
            }
        });

    });

    $("input[name=cep]").blur(function(){
        var cep_code = $(this).val();
        if( cep_code.length <= 0 ) return;
        $.ajax({
            url: "https://apps.widenet.com.br/busca-cep/api/cep/" + cep_code + ".json",
            dataType: "json",
            success: function( result ) {
                if(result.ok) {
                    $("input#cep").val(result.code);
                    $("input#estado").val(result.state.toUpperCase());
                    $("input#cidade").val(result.city.toUpperCase());
                    $("input#bairro").val(result.district.toUpperCase());
                    $("input#endereco").val(result.address.toUpperCase());
                    $("input#estado").val(result.state.toUpperCase());
                }else {
                    swal(result.message, "Click no botão abaixo!", "error");
                }
            }

        });
    });


});