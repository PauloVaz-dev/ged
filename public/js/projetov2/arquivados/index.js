var gridDebitostable;
var fornecedorNome;
var valor_debito;
var numero_cobranca;
var id_debito; //id do debito
var modalName;
function format ( d ) {
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
        '<td>Obs:</td>'+
        '<td>'+d.obs+'</td>'+
        '</tr>'+
        '</table>';
}

var table = $('#projetov2').DataTable({
    "stateSave": true,
    "autoWidth": true,
    "dom": 'lCfrtip',
    "order": [],
    "colVis": {
        "buttonText": "Colunas",
        "overlayFade": 0,
        "align": "right"
    },
    "searching": false,
    "bLengthChange": false,
    "drawCallback": function( settings ) {
        var inputs = document.getElementsByClassName('desarquivar')

        for(input of inputs) {
            input.addEventListener('click', function(e) {
                if(e.target.parentElement.parentElement.id){
                    var target = e.target.parentElement.parentElement.id
                }else{
                    var target = e.target.parentElement.parentElement.parentElement.id
                }
                arquivarProjeto(target)
            })
        }
    },
    processing: true,
    serverSide: true,
    bFilter: true,
    order: [[ 0, "asc" ]],
    ajax: {
        url: "/index.php/projetov2/arquivadas/grid",
        data: function (d) {
            d.nome = $('input[name=nome]').val();
            d.data_ini = dateToEN($('input[name=data_ini]').val());
            d.data_fim = dateToEN($('input[name=data_fim]').val())  + " 23:59:59";
            d.prioridade = $('select[name=prioridade] option:selected').val();
            d.cod_projeto = $('input[name=cod_projeto]').val();
            d.integrador = $('input[name=integrador]').val();
            d.projeto_status = $('select[name=projeto_status] option:selected').val();
            d.filtro_por = $("input[name='filtro_por']:checked").val();
        }
    },
    columns: [
        {
            "class":          "details-control",
            "orderable":      false,
            "data":           null,
            "defaultContent": ""
        },
        {data: "id",name: 'id' , visible: false },
        {data: 'nome_empresa', name: 'nome_empresa'},
        {data: 'codigo', name: 'codigo', visible: false},
        {data: 'preco_medio_instalado', name: 'preco_medio_instalado', "render": function (data) { return formatMoney(data) }},
        {data: 'potencia_instalada', name: 'potencia_instalada'},

        {data: 'data_financiamento_bancario', name: 'data_financiamento_bancario', visible: false},
        {data: 'data_prevista_parcela', name: 'data_prevista_parcela', visible: false},

        {data: 'data_prevista', name: 'data_prevista'},
        {data: 'data_conexao', name: 'data_conexao', visible: false},
        {data: 'prioridade_nome', name: 'prioridade_nome', visible: false},
        {data: 'integrador', name: 'integrador'},
        {data: 'franquaia', name: 'franquaia', visible: false},
        {data: 'status_nome', name: 'status_nome', visible: false},
        {data: 'atualizado', name: 'atualizado', visible: false},
        {data: 'pendencia', name: 'pendencia', visible: false,
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
$('#projetov2 tbody').on('click', 'td.details-control', function () {
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

function arquivarProjeto(arquivar_id){
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
                    'arquivar': ""
                }

                jQuery.ajax({
                    type: 'POST',
                    url: '/index.php/arquivarProjeto',
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


$( "#localizar" ).click(function() {
    table.draw();
});

$('#status').multiselect();


$( "#limpar" ).click(function() {
    $('input[name=nome]').val("");
    $('input[name=data_ini]').val("");
    $('input[name=data_fim]').val("");
    $('input[name=cod_projeto]').val("");
    $('input[name=integrador]').val("");
});

function formatMoney(n, c, d, t) {
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}



/* Modal Projeto */
var reportProjeto = document.getElementById('reportProjeto');

reportProjeto.addEventListener('click', function (ev) {
    var e = document.getElementById('ProjetoOrdenarPor')
    var ordenarPor = e.options[e.selectedIndex].value;


    //var t = document.getElementById('vistoriaOrder')
    //var order = t.options[t.selectedIndex].value;

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

    console.log(dados);

    var url = '/index.php/report/reportPdf?modalName=' + modalName + "&status=" + status + "&ordenar1=" +  ordenarPor;
    window.open(url, '_blank');
})

/* Modal Vistoria */
var reportVistoria = document.getElementById('reportVistoria');

reportVistoria.addEventListener('click', function (ev) {
    var e = document.getElementById('vistoriaOrdenarPor')
    var ordenarPor = e.options[e.selectedIndex].value;


    var t = document.getElementById('vistoriaOrder')
    var order = t.options[t.selectedIndex].value;
    reportAjax(ordenarPor, order);
})

/* Modal Acesso */
var reportAcesso = document.getElementById('reportAcesso');

reportAcesso.addEventListener('click', function (ev) {
    var e = document.getElementById('vistoriaOrdenarPor')
    var ordenarPor = e.options[e.selectedIndex].value;


    var t = document.getElementById('vistoriaOrder')
    var order = t.options[t.selectedIndex].value;
    reportAjax(ordenarPor, order);
})

/* Modal de Relatório */
var report = document.getElementById('report_id');

report.addEventListener('change', function (ev) {
    modalName = this.options[this.selectedIndex].value;
    $('#' + modalName).modal();
})

function formModalRelatorio() {
    console.log("www");
    $('#formModalRelatorio').modal();
}

function reportAjax(ordenarPor, order) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value
        }
    });
    var dados = {
        'order': order,
        'ordenarPor': ordenarPor
    }

    console.log(dados);

    var url = '/index.php/report/reportPdf?modalName=' + modalName + "&order=" + order + "&ordenarPor=" +  ordenarPor;
    window.open(url, '_blank');
}



function report() {
    var e = document.getElementById('ordenar')
    var ordenar = e.options[e.selectedIndex].value;
    console.log(ordenar);

    var t = document.getElementById('status')
    var statusText = t.options[t.selectedIndex].text;

   // var s = document.getElementById('status')
    //var status = s.options[s.selectedIndex].value;

    const selected = document.querySelectorAll('#status option:checked');
    const status = Array.from(selected).map(el => el.value);


    //alert(status);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        }
    });

    var dados = {
        'status': status,
        'ordenar1': ordenar
    }
    var url = '/index.php/report/reportProjetos?status=' + status + "&ordenar1=" +  ordenar + "&titulo=" + statusText;
    window.open(url, '_blank');


}













