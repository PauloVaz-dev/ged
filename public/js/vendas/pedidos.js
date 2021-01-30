var produto_id
function template(data){
    //Retirar os "&quot" da array aditivos
    //var aditivos = JSON.parse(d.aditivos.replace(/&quot;/g,'"'))


    var html = "<table class='table table-bordered'>";
    html += "<thead>" +
        "<tr><td>Qtd</td><td>Produto</td><td>Valor Unitário</td><td>Valor Total</td></tr>" +
        "</thead>";

    data.map(function (produto) {
        html += "<tr>";
        html += "<td>"  + produto.quantidade + "</td>";
        html += "<td>"  + produto.produto + "</td>";
        html += "<td>"  + produto.valor_unitario + "</td>";
        html += "<td>"  + produto.valor_total + "</td>";

        html += "</tr>"


    })
    html += "</table>";

    return  html;


}

var table = $('#pedidos').DataTable({
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
        url: "/index.php/orcamento/grid",
        data: function (d) {
        }
    },
    columns: [
        {
            "class":          "details-control",
            "orderable":      false,
            "data":           null,
            "defaultContent": ""
        },
        {data: "id",name: 'id', "visible" : false },
        {data: 'name', name: 'users.name'},
        {data: 'cliente', name: 'pedidos.cliente'},
        {data: 'created_at', name: 'pedidos.created_at'},
        {data: 'faturado_por', name: 'faturado_por',
            "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                if(oData.faturado_por == 1){
                    $(nTd).html("    <span class=\"badge badge-primary\">"+ "Pelo  credenciado</span>")
                }else{
                    $(nTd).html("    <span class=\"badge badge-primary\">" + "Pelo  cliente</span>");
                }
            }
        },
        {data: 'total', name: 'total', "render": function (data) { return parseFloat(data).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})} },
        {data: 'desconto', name: 'pedidos.desconto', "render": function (data) { return parseFloat(data).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'})} },
        {data: 'desconto', name: 'pedidos.desconto',
            "fnCreatedCell": function (nTd, sData, oData) {
            console.log(parseFloat(oData.total) - parseFloat(oData.desconto))
                    $(nTd).html("   " + (parseFloat(oData.total) - parseFloat(oData.desconto)).toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}) )
            }
        },
        {data: 'status', name: 'pedido_status.status'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});


// Add event listener for opening and closing details
// Add event listener for opening and closing details
$('#pedidos tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = table.row( tr );

    if ( row.child.isShown() ) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value

            }
        });
        data = {
            'id': row.data().id,
        }

        jQuery.ajax({
            type: 'POST',
            url: '/index.php/orcamento/getPedido',
            datatype: 'json',
            data: data,
        }).done(function (retorno) {
            if(retorno) {
                row.child( template(retorno) ).show();
                tr.addClass('shown');
            }
        });

    }
});

// Modal
$('#pedidos').on( 'click', '.edit', function (event) {
    produto_id = event.target.id;
    document.getElementById('desconto').value = ""
    $('#formModalStatus').modal();

});

var pedido = document.getElementById('BtnPedidoStatus')

pedido.addEventListener('click', function (ev) {
    var t = document.getElementById('peditoStatus')
    var status_id = t.options[t.selectedIndex].value;
    var desconto = document.getElementById('desconto').value
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value

        }
    });
    data = {
        'pedido_status_id': status_id,
        'produto_id': produto_id,
        'desconto': desconto
    }

    jQuery.ajax({
        type: 'POST',
        url: '/index.php/orcamento/updatePedido',
        datatype: 'json',
        data: data,
    }).done(function (retorno) {

        if(retorno.success) {
            console.log("wwwwwwwwww")
            $('#pedidos').DataTable().ajax.reload();
            $('#formModalStatus').modal('hide');

        }
    });
})
