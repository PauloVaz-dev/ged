var gridDebitostable;
var fornecedorNome;
var valor_debito;
var numero_cobranca;
var id_debito; //id do debito
function template(d){
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

var table = $('#projeto').DataTable({
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
    order: [[ 0, "desc" ]],
    ajax: {
        url: "/index.php/projeto/grid",
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
        {data: "id",name: 'id' , visible: false },
        {data: 'nome_empresa', name: 'clientes.nome_empresa'},
        {data: 'projeto_codigo', name: 'projetos.projeto_codigo'},
        {data: 'name', name: 'users.name', targets: 0, visible: false},
        {data: 'created_at', name: 'created_at'},
        {data: 'updated_at', name: 'updated_at', targets: 0, visible: false},
        {data: 'kw', name: 'kw'},
        {data: 'prioridade', name: 'prioridade', targets: 0, visible: false},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});

// Add event listener for opening and closing details
$('#cliente tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        // Open this row
        row.child( template(row.data()) ).show();
        tr.addClass('shown');
    }
});

$( "#localizar" ).click(function() {
    table.draw();
});


$( "#limpar" ).click(function() {
    $('input[name=nome]').val("");
    $('input[name=data_ini]').val("");
    $('input[name=data_fim]').val("");
    $('input[name=cod_projeto]').val("");
    $('input[name=integrador]').val("");
});








