$(document).ready(function () {



    $.ajax({
        url: "/index.php/alert/lastForAlerts",
        dataType: "json",
        success: function( alerts ) {
            document.getElementById('lert-count').innerHTML = alerts.length;
            alerts.forEach(function (alert) {
                var meses = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul","Ago","Set","Out","Nov","Dez"];
                var data = new Date(alert.created_at);
                var dataFormatada = ((data.getDate() + " " + meses[(data.getMonth())] + " " + data.getFullYear()));

                var html = '<li class=\"alerts\">'
                html += '<a class="alert alert-callout alert-warning" href="javascript:void(0);">'
                html +=     '<strong>' + alert.title  + '</strong>'
                html +=     '<small>' + alert.description + '</small>'
                html +=     '<small class="alert-date">' +dataFormatada + '</small>'
                html += '</a>'
                html += '</li>'

                $("#alert-solar ul").append(html);
            })

            var elements = document.getElementsByClassName("alerts");

            var myFunction = function() {
                console.log(this.children[0].children[1])
               document.getElementById('alert-title').innerText = this.children[0].children[0].innerText
                document.getElementById('alert-description').innerText = this.children[0].children[1].innerText
                document.getElementById('alert-date').innerText = this.children[0].children[2].innerText
                $('#formModalAlert').modal()
            };

            for (var i = 0; i < elements.length; i++) {
                elements[i].addEventListener('click', myFunction, false);
            }

        }
    });



});








