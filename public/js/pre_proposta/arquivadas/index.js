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



const table = $('#prePropostaArquivadas').DataTable({
    "stateSave": true,
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
                arquivarProposta(target)
            })
        }
    },
    processing: true,
    serverSide: true,
    bFilter: true,
    order: [[ 0, "desc" ]],
    ajax: {
        url: "/index.php/preProposta/arquivadas/grid",
        data: function (d) {
            d.prioridade = document.getElementById("prioridade_id").value;
            d.projetos = document.getElementById("projetos").value;
            d.nome = $('input[name=nome]').val();
            d.codigo = $('input[name=codigo]').val();
            d.integrador = $('input[name=integrador]').val();
            d.data_ini = dateToEN($('input[name=data_ini]').val());
            d.data_fim = dateToEN($('input[name=data_fim]').val())  + " 23:59:59";
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
        {data: 'id', name: 'id',  targets: 0, visible: false},
        {data: 'nome_empresa', name: 'nome_empresa',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if(oData.projeto != null){
                    $(nTd).html(oData.nome_empresa  + "    <span class=\"badge badge-primary\">"+ "Projeto Gerado</span>")
                }else{
                    $(nTd).html(oData.nome_empresa  + "    <span class=\"badge badge-warning\">" + "Sem Projeto</span>");
                }
            }
        },
        {data: 'codigo', name: 'codigo'},
        //{data: 'preco_medio_instalado', name: 'pre_propostas.preco_medio_instalado'},
        {data: 'preco_medio_instalado', name: 'pre_propostas.preco_medio_instalado', "render": function (data) { return formatMoney(data) }},
        {data: 'data_validade', name: 'pre_propostas.data_validade'},
        {data: 'name', name: 'users.name', targets: 0, visible: false},
        {data: 'created_at', name: 'pre_propostas.created_at', visible: false},
        {data: 'updated_at', name: 'pre_propostas.updated_at',  targets: 0, visible: false},
        {data: 'prioridade', name: 'prioridades.name', visible: false},
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
            title: "Desarquivar Proposta?",
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








