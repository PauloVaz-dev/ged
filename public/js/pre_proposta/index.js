var gridDebitostable;
var fornecedorNome;
var valor_debito;
var numero_cobranca;
var id_debito; //id do debito

dateToEN = (date) => date.split('/').reverse().join('-');

format = ( d ) =>
{
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
    '<tr>' +
    '<td>Obs:</td>' +
    '<td>' + d.pendencia_obs + '</td>' +
    '</tr>' +
    '</table>';
}

mascara = (val) => $('val.cpf_cnpj').mask('00.000.000/0000-00')



const table = $('#preProposta').DataTable({
    "stateSave": true,
    "dom": 'lCfrtip',
    "order": [],
    "colVis": {
        "buttonText": "Colunas",
        "overlayFade": 0,
        "align": "right"
    },
    "searching": false,
    "bLengthChange": true,
    "drawCallback": function( settings ) {
        var inputs = document.getElementsByClassName('arquivar')
        for(input of inputs) {
            input.addEventListener('click', function(e) {
                if(e.target.parentElement.parentElement.id){
                    var target = e.target.parentElement.parentElement.id
                }else{
                    var target = e.target.parentElement.parentElement.parentElement.id
                }
                arquivarProposta(target)
            })
        }
    },
    processing: true,
    serverSide: true,
    bFilter: true,
    order: [[ 1, "desc" ]],
    ajax: {
        url: "/index.php/preProposta/grid",
        data: function (d) {
            d.prioridade = document.getElementById("prioridade_id").value;
            d.projetos = document.getElementById("projetos").value;
            d.nome = $('input[name=nome]').val();
            d.codigo = $('input[name=codigo]').val();
            d.integrador = $('input[name=integrador]').val();
            d.data_ini = dateToEN($('input[name=data_ini]').val());
            d.data_fim = dateToEN($('input[name=data_fim]').val())  + " 23:59:59";
            d.filtro_por = $("input[name='filtro_por']:checked").val();
            d.franquia_id = $('select[name=franquia_id] option:selected').val();
        }
    },
    columns: [
        {
            "class":          "details-control",
            "orderable":      false,
            "data":           null,
            "defaultContent": ""
        },
        {data: 'id', name: 'id',  targets: 0, visible: false},
        {data: 'nome_empresa', name: 'nome_empresa',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if(oData.projeto != null){
                    var pago = "";
                    oData.status_projeto == 8 || oData.status_projeto == 1 ? pago =  "<i class=\"icon i20d icon-22\"></i>": pago = "<i class=\"icon i20 icon-22\"></i>"
                    $(nTd).html(oData.nome_empresa  + "    <span class=\"badge badge-primary\">"+ "Projeto Gerado</span>" + pago)
                }else{
                    $(nTd).html(oData.nome_empresa  + "    <span class=\"badge badge-warning\">" + "Sem Projeto</span>");
                }
            }
        },
        //{data: 'preco_medio_instalado', name: 'pre_propostas.preco_medio_instalado'},
        {data: 'preco_medio_instalado', name: 'pre_propostas.preco_medio_instalado', "render": function (data) { return formatMoney(data) }},
        {data: 'potencia_instalada', name: 'pre_propostas.potencia_instalada'},
        {data: 'data_validade', name: 'pre_propostas.data_validade', visible: false},
        {data: 'name', name: 'users.name', targets: 0, visible: false},
        {data: 'franquaia', name: 'franquaia', visible: false},
        {data: 'created_at', name: 'pre_propostas.created_at'},
        {data: 'updated_at', name: 'pre_propostas.updated_at',  targets: 0, visible: false},
        {data: 'prioridade', name: 'prioridades.name'},
        {data: 'pendencia', name: 'pendencia', visible: true,
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if(oData.pendencia != null){
                    $(nTd).html("    <span class=\"badge badge-danger\">"+ "Pendente</span>")
                }
            }

        },
        {data: 'action', name: 'action', orderable: false, searchable: false, width: '90px'}
    ]
});

// Add event listener for opening and closing details
var detailRows = [];

// Add event listener for opening and closing details
$('#preProposta tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }
} );

$( "#localizar" ).click(function() {
    table.draw();
});


arquivarProposta = (arquivar_id) => {
    swal({
            title: "Arquivar Proposta?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Sim, Arquivar!",
            cancelButtonText: "Não, cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value

                    }
                });
                data = {
                    'id': arquivar_id,
                    'arquivar': "1"
                }

                jQuery.ajax({
                    type: 'POST',
                    url: '/index.php/arquivarProposta',
                    datatype: 'json',
                    data: data,
                }).done(function (retorno) {
                    if(retorno.success) {
                        swal("", retorno.msg, "success");
                        location.reload();

                    } else {
                        swal("Error", "Click no botão abaixo!", "error");
                    }
                });
            } else {
                swal("Cancelled", "Your imaginary file is safe :)", "error");
            }
        });
}



$( "#limpar" ).click(function() {
    $('input[name=nome]').val("");
    $('input[name=data_ini]').val("");
    $('input[name=data_fim]').val("");
    $('input[name=codigo]').val("");
    $('input[name=integrador]').val("");
});


formatMoney = (n, c, d, t) => {
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}




$('.cpf').mask('000.000.000-00', {reverse: true});
$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
var cpfMascara = function (val) {
        return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-009';
    },
    cpfOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(cpfMascara.apply({}, arguments), options);
        }
    };
$('.mascara-cpfcnpj').mask(cpfMascara, cpfOptions);



/* Abrir Modal de Clientes */
var report = document.getElementById('report_id');

report.addEventListener('change', function (ev) {
    modalName = this.options[this.selectedIndex].value;
    if(modalName){
        console.log(modalName);
        $('#' + modalName).modal();
    }
})

/* Fim Abrir Modal de Clientes */

/* Modal Projeto */
var reportProposta = document.getElementById('reportProposta');

reportProposta.addEventListener('click', function (ev) {
    var e = document.getElementById('ordenarPor')
    var ordenarPor = e.options[e.selectedIndex].value;


    var t = document.getElementById('order')
    var order = t.options[t.selectedIndex].value;

    var date_init = document.getElementById('date_init_prioridade').value
    date_init = date_init.split("/").reverse().join("-");

    var date_end = document.getElementById('date_end_prioridade').value
    date_end = date_end.split("/").reverse().join("-");

    var f = document.getElementById('franquiaPrioridade')
    var franquia_id = f.options[f.selectedIndex].value;


    const selected = document.querySelectorAll('#projetoStatus option:checked');
    const status = Array.from(selected).map(el => el.value);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value
        }
    });
    var dados = {
        'order': order,
        'ordenarPor': ordenarPor
    }

    //console.log(modalName);

    var url = '/index.php/report/reportPdf?modalName=' + modalName + "&inputOrdenaPor=" + ordenarPor + "&InputOrder=" +  order + "&franquia_id=" + franquia_id + "&date_init=" + date_init + "&date_end=" + date_end ;
    window.open(url, '_blank');
})





