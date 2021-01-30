$('.select2_clientes').select2({
    minimumInputLength: 4,
    ajax: {
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val()
        },
        url: "/index.php/getclientes",
        type: "post",
        dataType: 'json',
        delay: 500,
        data: function (params) {
            return {
                searchTerm: params.term // search term
            };
        },
        processResults: function (response) {
            return {
                results: response
            };
        },
        cache: true
    }
});