//http://morrisjs.github.io/morris.js/index.html
$.ajax({
    url: "/dashboard/getProjetos",
    type: "GET",
    dataType: "json",
    success: function (data) {
       ShowGrpah(data);
    },
});

/*
function ShowGrpah(data) {
    Morris.Bar({
        element: 'IcecastGraph',
        data: data,
        xkey: 'MONTH',
        ykeys: ['Total'],
        labels: ['Total'],
        barRatio: 0.4,
        xLabelAngle: 35,
        hideHover: 'auto'
    });
}*/

/*Morris.Donut({
    element: 'graph',
    data: [
        {value: 70, label: 'Aguardando intalação do cliente'},
        {value: 15, label: 'Concluido'},
        {value: 10, label: 'baz'},
        {value: 5, label: 'A really really long label'}
    ],
    formatter: function (x) { return x + "%"}
}).on('click', function(i, row){
    console.log(i, row);
});*/

function ShowGrpah(data) {

    var donut = new Morris.Donut({
        element: 'graph',
        hoverCallback: function(index, options, content) {
           console.log(index);
        },
        data: [
            {value: data[0].soma, label: data[0].status_nome},
            {value: data[1].soma, label: data[1].status_nome},
            {value: data[2].soma, label: data[2].status_nome},
            {value: data[3].soma, label: data[3].status_nome},
            {value: data[4].soma, label: data[4].status_nome},
            {value: data[5].soma, label: data[5].status_nome},
            {value: data[5].soma, label: data[5].status_nome},
            {value: data[6].soma, label: data[6].status_nome},

        ],
        formatter: function (x) { return x }
    }).on('click', function(i, row){
        console.log(i, row);
    })
    for(i = 0; i < donut.segments.length; i++) {
        donut.segments[i].handlers['hover'].push( function(i){
            console.log(donut.data[i].label)
            //$('#morrisdetails-item .morris-hover-row-label').text(donut.data[i].label);
            $('.morris-hover-point').text(donut.data[i].label);
        });
    }
}

