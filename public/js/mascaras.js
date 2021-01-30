$('.phone').mask('(00)000000000');
$('.cpf').mask('000.000.000-00', {reverse: true});
$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
$('.date').mask('00/00/0000');
$('.money').mask('###.###.###.##0,00',  {reverse: true});
$('.number').mask('###.###.###.###',  {reverse: true});
$('.numberWithoutDot').mask('###############',  {reverse: true});
$('.kwh').mask('0,0000',  {reverse: true});
$('.kwp').mask('####0,00',  {reverse: true});
$('.contrato').mask('###0000',  {reverse: true});

$('.date').datepicker({autoclose: true, todayHighlight: true, format: "dd/mm/yyyy"});
$('.datepicker').datepicker({autoclose: true, todayHighlight: true});

var cpfMascara = function (val) {
        return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-009';
    },
    cpfOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(cpfMascara.apply({}, arguments), options);
        }
    };
$('.mascara-cpfcnpj').mask(cpfMascara, cpfOptions);

function dateToEN(date)
{
    return date.split('/').reverse().join('-');
}




