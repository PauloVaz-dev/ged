$(document).ready(function () {
    //Retona o elemento que foi clicado com a class "delete", uso o "on" pois os elementos
    //sao criados dinamicamente
    $(document).on( 'click', '.delete', function( event ) {
        event.preventDefault();
        var elem = document.getElementsByClassName("delete");
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $( '#'+elem[0].id ).submit();
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
    });

    console.log("index");
    var table = $('#roles').DataTable({
        "stateSave": false,
        "dom": 'lCfrtip',
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
            url: "/index.php/roles/grid",
            data: function (d) {

            }
        },
        columns: [
            {data: 'id', name: 'id', visible: false,},
            {data: 'name', name: 'name'},
            {data: 'nome', name: 'franquia,nome'},
            {data: 'is_active', name: 'is_active', visible: true, width: '60px',
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    if(oData.is_active == 1){
                        $(nTd).html("    <span class=\"badge badge-primary\">"+ "Ativo</span>")
                    }else{
                        $(nTd).html("    <span class=\"badge badge-danger\">"+ "Desativado</span>")
                    }
                }

            },
            {data: 'action', name: 'action', orderable: false, width: '60px', searchable: false}
        ]
    });

});