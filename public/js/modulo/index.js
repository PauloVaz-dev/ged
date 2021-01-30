var gridDebitostable;
var fornecedorNome;
var valor_debito;
var numero_cobranca;
var id_debito; //id do debito


var table = $('#modulo').DataTable({
    "dom": 'lCfrtip',
    "order": [],
    "colVis": {
        "buttonText": "Colunas",
        "overlayFade": 0,
        "align": "right"
    },
    "searching": true,
    "bLengthChange": false,
    processing: true,
    serverSide: true,
    bFilter: true,
    order: [[ 0, "desc" ]],
    ajax: {
        url: "/index.php/modulo/grid",
        data: function (d) {

        }
    },
    columns: [
        {data: "id",name: 'id' , visible: false },
        {data: 'potencia', name: 'potencia'},
        {data: 'rendimento', name: 'rendimento'},
        {data: 'area_total', name: 'area_total'},
        {data: 'area_geracao', name: 'area_geracao'},
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

formatMoney = (n, c, d, t) => {
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}









