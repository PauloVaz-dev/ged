var gridDebitostable;
var fornecedorNome;
var valor_debito;
var numero_cobranca;
var id_debito; //id do debito

function template(d){
    console.log(d);
    //Retirar os "&quot" da array aditivos
    //var aditivos = JSON.parse(d.aditivos.replace(/&quot;/g,'"'))

    var html = "<table class='table table-bordered'>";
    html += "<thead>" +
        "<tr><td>Profile</td><td>Grupo</td></tr>" +
        "</thead>";



    html += "<tr>";
    html += "<td>"  + d.profile + "</td>";
    html += "<td>"  + d.grupo + "</td>";

    html += "</tr>"

    html += "</table>";

    return  html;
}

var table = $('#franquia').DataTable({
    "dom": 'lCfrtip',
    "order": [],
    "colVis": {
        "buttonText": "Colunas",
        "overlayFade": 0,
        "align": "right"
    },
    "searching": false,
    "bLengthChange": false,
    processing: true,
    serverSide: true,
    bFilter: true,
    order: [[ 1, "asc" ]],
    ajax: {
        url: "/index.php/franquia/grid",
        data: function (d) {
        }
    },
    columns: [
        {data: 'id', name: 'id', targets: 0, visible: false},
        {data: 'nome', name: 'nome'},
        {data: 'contato', name: 'contato'},
        {data: 'cpf_cnpj', "render": function ( data, type, row ) {
                return '<span id="'+"WW"+'">'+data+'</span>';
            }
        },
        {data: 'estado', name: 'estado'},
        {data: 'is_active', name: 'is_active', visible: true,
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if(oData.is_active == 1){
                    $(nTd).html("    <span class=\"badge badge-primary\">"+ "Ativo</span>")
                }else{
                    $(nTd).html("    <span class=\"badge badge-danger\">"+ "Desativado</span>")
                }
            }

        },
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});

var mascara = function (val) {
    return $('val.cpf_cnpj').mask('00.000.000/0000-00')
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






