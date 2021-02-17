$(document).ready(function () {

    function template(data){
        var html = "<table class='table table-bordered'>";
        data.data.map(function (item) {
            //console.log(item);
            html += "<tr>";
            html += "<td>" + "\n" + "<a target='_blank' href=" + item.file + ">" + 'Link do arquivo'  + "</a></td>";
            html += "</tr>"
        })
        html += "</table>";

        return  html;
    }

    var documento_franquia_id;
    var documento_status_id;
    var table = $('#digitalizacao').DataTable({
        "stateSave": false,
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
            url: "/index.php/digitalizacao/grid",
            data: function (d) {
                d.descricao = document.getElementById('descricao').value,
                d.data_ini = dateToEN(document.getElementById('data_ini').value),
                d.data_fim = dateToEN(document.getElementById('data_fim').value),
                d.filtro_por = $('select[name=filtro_por] option:selected').val();
                d.despesa_id = $('select[name=despesa_id] option:selected').val();
                d.secretaria_id = $('select[name=secretaria_id] option:selected').val();
            }
        },
        columns: [
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
            {data: 'id', name: 'digitalizacao.id', visible: true},
            {data: 'descricao', name: 'digitalizacao.descricao', visible: true},
            {data: 'despesa', name: 'despesas.despesa', visible: true},
            {data: 'numero_processo', name: 'digitalizacao.numero_processo', visible: true},
            {data: 'competencia', name: 'digitalizacao.competencia', visible: true},
            {data: 'convenio', name: 'digitalizacao.convenio', visible: true},
            {data: 'conta', name: 'digitalizacao.conta', visible: true},
            {data: 'numero_licitacao', name: 'digitalizacao.numero_licitacao', visible: true},
            {data: 'secretaria', name: 'secretarias.secretaria', visible: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, width: '60px'}




        ]
    });

    $( "#localizar" ).click(function() {
        table.draw();
    });

    $('#digitalizacao tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
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
                'id': row.data().id
            }
            $.ajax({
                url : '/index.php/digitalizacao-file',
                type : 'POST',
                data : data,
                dataType: 'JSON',
                success : function(data) {
                    row.child( template(data) ).show();
                    tr.addClass('shown');
                }
            })
        }
    } );

    $('#documentos').on( 'click', '.importar-arquivo', function (event) {

        if(event.target.id){
            documento_franquia_id = document.getElementById('documento_franquia_id').value = event.target.id
        }else{
            documento_franquia_id = document.getElementById('documento_franquia_id').value = event.target.children[0].id
        }
        $('#formModalUpload').modal();
    });

    $('#documentos').on( 'click', '.edit', function (event) {

        if(event.target.id){
            documento_franquia_id = document.getElementById('documento_franquia_id').value = event.target.id
        }else{
            documento_franquia_id = document.getElementById('documento_franquia_id').value = event.target.children[0].id
        }
        var row = $(this).closest('tr');
        var data = $('#documentos').dataTable().fnGetData(row);
        documento_status_id = data.status_id;

        //console.log(documento_franquia_id, documento_status_id, data.obs)

        document.getElementById('obs').value = data.obs
        document.getElementById('documento_status_id').value = documento_status_id
        $('#formModalEdit').modal();
    });

    $('#btnModalEdit').on('click', function(e) {
        e.preventDefault();

        var obs = document.getElementById('obs').value
        var documento_status_id = document.getElementById('documento_status_id').value

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value

            }
        });

        data = {
            'obs': obs,
            'documento_status_id': documento_status_id,
            'documento_franquia_id': documento_franquia_id

        }
        $.ajax({
            type: 'POST',
            url : '/index.php/documentoUpload/update',
            datatype: 'json',
            data: data,
            success : function(data) {
                $('#documentos').DataTable().ajax.reload();
                $('#formModalEdit').modal('hide');
            }
        })
    });

    function findAllDigitalizacao(id) {


      // console.log(id)



    };

    $('#formUpload').on('submit', function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.getElementsByName("_token")[0].value
            }
        });
        $.ajax({
            url : '/index.php/documentoUpload/upload',
            type : 'POST',
            data : new FormData(this),
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            dataType: 'JSON',
            cache: false,
            success : function(data) {
                $('#documentos').DataTable().ajax.reload();
                $('#formModalUpload').modal('hide');
                console.log(data)
            }
        })
    });

});





