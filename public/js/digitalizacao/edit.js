$(document).ready(function () {
    console.log("edit");
    $('.phone').mask('(00)000000000');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.date').mask('00/00/0000');
    $('.ip').mask('099.099.099.099');
    $('.dns').mask('099.099.099.099');
    //Ao submeter tirar as mascaras
    $("#pool").submit(function (event) {
        $('.phone').unmask();
    });

    $(".select2-list").select2({
        allowClear: true
    });

    $(".add-more-documento").click(function(){


        var html = '<div class="row copy">'
        html += '<div class="col-sm-5">'
        html += '   <div class="form-group">'
        html += '       <label for="image" class="col-sm-3 control-label text-bold">Link Arquivo</label>'
        html += '       <div class="col-md-9">'
        html += '           <input readonly class="form-control input-sm" name="arquivo[]" type="file" id="arquivo[]" value="">'
        html += '       </div>'
        html += '   </div>'
        html += '</div>'
        html += '<div class="col-sm-1">'
        html +=     '<div class="form-group">'
        html +=         '<div class="col-md-2">'
        html +=             '<button class="btn btn-danger remove btn-sm" type="button"><i class="glyphicon glyphicon-remove"></i></button>'
        html +=         '</div>'
        html +=     '</div>'
        html += '</div>'


        $(".after-add-more-documento").before(html);
    });


});

function toastError(){
    toastr.options.progressBar = true;
    toastr.options.positionClass = 'toast-top-center';
    toastr.success('Senha ou login estão errados')
}
