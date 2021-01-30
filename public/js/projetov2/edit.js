
function removeContaContrato(idContrato) {

    if(event.target.parentElement.parentElement.parentElement.parentElement.id !== ""){
        numeroContrato = event.target.parentElement.parentElement.parentElement.parentElement.id
    }else{
        numeroContrato = event.target.parentElement.parentElement.parentElement.parentElement.parentElement.id
    }
    //Necessario para que o ajax envie o csrf-token
    //Para isso coloquei no form <meta name="csrf-token" content="{{ csrf_token() }}">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value

        }
    });


    data = {
        'idContrato': idContrato,
    }
    jQuery.ajax({
        type: 'POST',
        url: '/index.php/deletaContratoConcercionaria',
        datatype: 'json',
        data: data,
    }).done(function (retorno) {
        if(retorno.success) {
            swal("", "Conta contrato deletado com sucesso", "success");
            var myobj = document.getElementById(numeroContrato);
            myobj.remove();


        } else {
            swal("Error", "Click no botão abaixo!", "error");
        }
    });


}


$(document).ready(function () {
    var projeto_status_id = document.getElementById('projeto_status_id').value
    localStorage.setItem('projeto_status_id', projeto_status_id)
    localStorage.setItem('projeto_acordion', 1)
    localStorage.setItem('projeto_aba', 0)


    var o = this;

    $('#rootwizard1').bootstrapWizard({
        onTabClick: function(tab, navigation, index){
            return true
        },
        onTabShow: function(tab, navigation, index) {
            //handleTabShow(tab, navigation, index, $('#rootwizard1'));

        },

    });


    function isnull(value){
       return typeof value === "object" && !value
    }

    function handleTabShow(tab, navigation, index, wizard){
        var total = navigation.find('li').length;
        var current = index + 0;
        var percent = (current / (total - 1)) * 100;
        var percentWidth = 100 - (100 / total) + '%';
        console.log(percent)
        navigation.find('li').removeClass('done');
        navigation.find('li.active').prevAll().addClass('done');

        wizard.find('.progress-bar').css({width: percent + '%'});
        $('.form-wizard-horizontal').find('.progress').css({'width': percentWidth});
    };

    /* Ativa o último  acordion*/
    var projeto_acordion = localStorage.getItem('projeto_acordion')

    /* Ativa a aba no projeto */

    var projeto_aba = localStorage.getItem('projeto_aba')


    if (projeto_aba) {
        var projeto_aba = 0
        console.log("www")
    }


    document.getElementById('tabs-solar').children[projeto_aba].setAttribute('class', 'tab-pane active')

    document.getElementById('tab_' + projeto_acordion).setAttribute('class', 'collapse in')
    document.getElementById('tab_' + projeto_acordion).parentElement.setAttribute('class', 'card panel expanded')

    var tab_1 = document.getElementById('tab_1').previousElementSibling
    tab_1.addEventListener('click', function () {
        localStorage.setItem('projeto_acordion', 1)
    })

    var tab_2 = document.getElementById('tab_2').previousElementSibling
    tab_2.addEventListener('click', function () {
        localStorage.setItem('projeto_acordion', 2)
    })

    var tab_3 = document.getElementById('tab_3').previousElementSibling
    tab_3.addEventListener('click', function () {
        localStorage.setItem('projeto_acordion', 3)
    })

    var tab_4 = document.getElementById('tab_4').previousElementSibling
    tab_4.addEventListener('click', function () {
        localStorage.setItem('projeto_acordion', 4)
    })

    var tab_5 = document.getElementById('tab_5').previousElementSibling
    tab_5.addEventListener('click', function () {
        localStorage.setItem('projeto_acordion', 5)
    })
    /* FIM Ativa o último  acordion*/





    /* Wizard */
    var projetos_wizard_lis =  document.getElementById('projetos_wizard').children

    for(projetos_wizard_li of projetos_wizard_lis){
        projetos_wizard_li.addEventListener('click', function(ev){
            //console.log(ev.target.getAttribute('data-tab_li'))
            localStorage.setItem('projeto_aba', ev.target.getAttribute('data-tab_li'))
        })
    }

    for(projetos_wizard_li of projetos_wizard_lis) {
        projetos_wizard_li.setAttribute('class', '')
    }

    var projetos_status = ["0", "0", "0", "0", "1", "2", "3"];
    console.log(projetos_status[localStorage.getItem('projeto_status_id')])
    console.log(localStorage.getItem('projeto_status_id'))
    var current = projetos_status[localStorage.getItem('projeto_status_id')]
    //projetos_wizard_lis[current].setAttribute('class', 'active')


    for(i=0; i<=current; i++){
        projetos_wizard_lis[i].setAttribute('class', 'done')
    }
    var percent = (current / (4 - 1)) * 100;
    document.getElementsByClassName('progress')[0].style.width = 75 + "%"
    document.getElementsByClassName('progress-bar')[0].style.width = percent + "%"

    /* Fim Wizard */


    $(".add-more").click(function(){


        var html = '<div class="row copy">'
        html += '<div class="col-sm-3">'
        html +=     '<div class="form-group">'
        html +=         '<label for="num_contacontrato" class="col-sm-6 control-label text-bold">C/Contrato.:</label>'
        html +=         '<div class="col-md-6">'
        html += '           <div class="">'
        html +=                     '<input class="form-control input-sm" name="num_contacontratoN[]" type="text" id="num_contacontrato[]" value="">'
        html +=             '</div>'
        html +=         '</div>'
        html +=     '</div>'
        html += '</div>'
        html += '<div class="col-sm-1">'
        html += '   <div class="form-group">'
        html += '       <div class="col-md-4">'
        html += '           <div class="checkbox checkbox-styled">'
        html += '               <label>'
        html += '                   <input id="contrato_titularidadeN[]" class="" name="contrato_titularidadeN[]" type="checkbox" value="1" checked>'
        html += '               </label>'
        html += '           </div>'
        html += '       </div>'
        html += '   </div>'
        html += '</div>'
        html += '<div class="col-sm-2">'
        html +=     '<div class="form-group">'
        html +=         '<label for="percentual" class="col-sm-6 control-label text-bold">Percentual.:</label>'
        html +=         '<div class="col-md-6">'
        html +=             '<input class="form-control input-sm" name="percentualN[]" type="text" id="percentual[]" value="" placeholder="%">'
        html +=         '</div>'
        html +=     '</div>'
        html += '</div>'
        html += '<div class="col-sm-5">'
        html += '   <div class="form-group">'
        html += '       <label for="image" class="col-sm-3 control-label text-bold">Link Arquivo</label>'
        html += '       <div class="col-md-9">'
        html += '           <input readonly class="form-control input-sm" name="imageN[]" type="file" id="image[]" value="">'
        html += '       </div>'
        html += '   </div>'
        html += '</div>'
        html += '<div class="col-sm-1">'
        html +=     '<div class="form-group">'
        html +=         '<div class="col-md-2">'
        html +=             '<button class="btn btn-danger remove btn-sm" type="button"><i class="glyphicon glyphicon-remove"></i></button>'
        html +=         '</div>'
        html +=     '</div>'
        html += '</div>'
        html += '</div>'


        $(".after-add-more").before(html);



    });

    $(".add-more-documento").click(function(){


        var html = '<div class="row copy">'
        html += '<div class="col-sm-6">'
        html +=     '<div class="form-group">'
        html +=         '<label for="descricao" class="col-sm-4 control-label text-bold">Descrição.:</label>'
        html +=         '<div class="col-md-8">'
        html +=               '<input class="form-control input-sm" name="descricaoN[]" type="text" id="descricaoN[]" value="">'
        html +=         '</div>'
        html +=     '</div>'
        html += '</div>'
        html += '<div class="col-sm-5">'
        html += '   <div class="form-group">'
        html += '       <label for="image" class="col-sm-3 control-label text-bold">Link Arquivo</label>'
        html += '       <div class="col-md-9">'
        html += '           <input readonly class="form-control input-sm" name="descricao_imageN[]" type="file" id="descricao_imageN[]" value="">'
        html += '       </div>'
        html += '   </div>'
        html += '</div>'
        html += '<div class="col-sm-1">'
        html +=     '<div class="form-group">'
        html +=         '<div class="col-md-2">'
        html +=             '<button class="btn btn-danger remove btn-sm" type="button"><i class="glyphicon glyphicon-remove"></i></button>'
        html +=         '</div>'
        html +=     '</div>'
        html += '</div>'


        $(".after-add-more-documento").before(html);
    });

    $("body").on("click",".remove",function(){
        //console.log($(this).parentElement);
       // $(this).parents(".copy").remove();
    });

    $("#modalContrato").on('click', function () {
        $('#formModal').modal();
        //var projeto_id =  document.getElementById("id").value
        //criarContrato(projeto_id)
    })

    $("#novoContrato").on('click', function () {

        criarContrato()
    })



    function criarContrato(projeto_id)
    {

        //Necessario para que o ajax envie o csrf-token
        //Para isso coloquei no form <meta name="csrf-token" content="{{ csrf_token() }}">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value

            }
        });
        var projeto_id =  document.getElementById("id").value;

        var ano =  document.getElementById("ano").value;

        var selector = document.getElementById('minuta_contrato');
        var minuta_contrato = selector[selector.selectedIndex].value;

        data = {
            'ano': ano,
            'projeto_id': projeto_id,
            'minuta_contrato': minuta_contrato
        }

        jQuery.ajax({
            type: 'POST',
            url: '/index.php/criarContrato',
            datatype: 'json',
            data: data,
        }).done(function (retorno) {
            if(retorno.success) {
                swal("", "Contrato Cadastrado com sucesso", "success");
                $('#formModal').modal('toggle');

            } else {
                swal("Error", "Click no botão abaixo!", "error");
            }
        });
    }

});