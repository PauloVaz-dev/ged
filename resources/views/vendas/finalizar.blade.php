<table  class="table table-hover">
    <thead>
    <tr>
        <th>Quantidade</th>
        <th>Produto</th>
        <th>Valor unitário</th>
        <th>Valor Total</th>
    </tr>
    </thead>
    <tbody id="table_finalizar">
    </tbody>
</table>

<section class="forma-pagamento">
    <div class="sc-cLmFfZ covtfS">
        <div>
            <span class="sc-fEVUGC title">Formas de Pagamento</span>
            <ul>
                <li>
                    <p class="sc-dchYKM gEfkdM">Até 60x financiamento Santander, BV</p>
                </li>
                <li>
                    <p class="sc-dchYKM gEfkdM">12x no cartão de crédito</p>
                </li>
                <li>
                    <p class="sc-dchYKM gEfkdM">Boleto à vista R$ 0,00 (com desconto)</p>
                </li>
            </ul>
        </div>
    </div>

    <div class="sc-cLmFfZ covtfS">
        <div>
            <span class="sc-iNovjJ title">Frete</span>
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" class="svg-inline--fa fa-angle-right fa-w-8 " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg>
            <span>Frete a combinar.</span>
        </div>
    </div>
</section>

<section class="forma-pagamento">
    <div class="sc-cLmFfZ covtfS">
        <div>
            <span class="sc-fEVUGC title">Cliente</span>
            <div class="form-group {{ $errors->has('telefone') ? 'has-error' : '' }}">
                <label for="nome" class="col-sm-1 text-bold">Nome *.:</label>
                <div class="col-md-11">
                    <input class="form-control input-sm" name="nome" type="text" id="nome" value="" maxlength="100">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="forma-produtos">
    <div class="sc-cLmFfZ covtfS">
        <div>
            <span class="sc-fEVUGC title">Produtos</span>
            <label class="radio-inline radio-styled">
                <input checked="checked" type="radio" name="faturamento" value="1"><span>Faturamento para o credenciado (Revenda)</span>
            </label>
            <label class="radio-inline radio-styled">
                <input type="radio" name="faturamento" value="2"><span>Faturamento direto para o cliente</span>
            </label>
        </div>

        <div class="produtos-detalhe">
            <span>Valor total dos produtos</span>
            <span>R$ 0,0</span>
        </div>
    </div>



</section>