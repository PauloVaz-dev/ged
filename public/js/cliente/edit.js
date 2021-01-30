$(document).ready(function () {


    //ao clicar aculta algum campo de cpf ou cnpj
    $('.tipoF').click(function () {
        $('.fisica').show()
        $('.juridico').hide()
    })
    $('.tipoJ').click(function () {
        $('.juridico').show()
        $('.fisica').hide()
    })

    //Ao submeter tirar as mascaras
    $("#edit_cliente_form").submit(function (event) {
        //$('.mascara-cpfcnpj').unmask();
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