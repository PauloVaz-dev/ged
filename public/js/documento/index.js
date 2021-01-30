$(document).ready(function () {

    function template(d){
        console.log(d);
        //Retirar os "&quot" da array aditivos
        //var aditivos = JSON.parse(d.aditivos.replace(/&quot;/g,'"'))

        var html = "<table class='table table-bordered'>";
        html += "<thead>" +
            "<tr><td></td><td></td></tr>" +
            "</thead>";



        html += "<tr>";
        html += "<td>" + d.obs +"</td>";
        html += "<td>"  +"</td>";

        html += "</tr>"

        html += "</table>";

        return  html;
    }

    var documento_franquia_id;
    var documento_status_id;
    var table = $('#documentos').DataTable({
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
            url: "/index.php/documento/grid",
            data: function (d) {
                d.documento = document.getElementById("documento").value;
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
            {data: 'id', name: 'id', visible: false},
            {data: 'nome', name: 'franquias.nome'},
            {data: 'descricao', name: 'descricao',
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    $(nTd).html(
                        "<a target='_blank' href=/storage/" + oData.image + ">" + oData.descricao + ""
                    );
                }
            },
            {data: 'created_at', name: 'documentos.created_at'},

            {data: 'upload', name: 'documentos_upload.image',
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    if(oData.upload == null){
                        $(nTd).html("<span class=\"badge badge-danger\">"+ "Pendente</span>")
                    }else{
                        $(nTd).html(
                            "<a target='_blank' href=/storage/" + oData.upload + "><span class=\"badge badge-primary\">" + "Dispoível" +" </span></a>"
                        );
                    }

                }
            },

            {data: 'upload_created_at', name: 'documentos_upload.created_at'},
            {data: 'status', name: 'documento_status.descricao'},
            {data: 'status_id', name: 'documento_status.id', visible: false},
            {data: 'action', name: 'action', orderable: false, searchable: false, width: '60px'}
        ]
    });

    $( "#localizar" ).click(function() {
        table.draw();
    });


    $('#documentos tbody').on('click', 'td.details-control', function () {
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

        console.log(documento_franquia_id, documento_status_id, data.obs)

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





