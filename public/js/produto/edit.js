$(document).ready(function () {

    function logSubmit(event) {
        const preco_revenda = document.getElementById('preco_revenda')
        preco_revenda.value = realDolar(preco_revenda.value)

        const preco_franquia = document.getElementById('preco_franquia')
        preco_franquia.value = realDolar(preco_franquia.value)
    }

    const form = document.getElementById('edit_produto_form');
    form.addEventListener('submit', logSubmit);

})