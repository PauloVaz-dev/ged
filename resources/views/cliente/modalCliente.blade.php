
<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="formModalClientes" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="formModalLabel">Relatório de Acesso</h4>
            </div>
            <form class="form-horizontal" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="ano" class="control-label">Ordenar Por</label>
                        </div>
                        <div class="col-sm-9">
                            <select id="ordenarPor" name="ordenarPor" class="form-control input-sm">
                                <option value="">Selecionar</option>
                                <option value="c.nome_empresa">Nome do Cliente</option>
                                <option value="pp.preco_medio_instalado">Valor Proposta</option>
                                <option value="u.name,">Integrador</option>
                                <option value="pe.obter_protocolo_data_prevista">Data da Cadastro</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="ano" class="control-label">Ordenar</label>
                        </div>
                        <div class="col-sm-9">
                            <select id="order" name="order" class="form-control input-sm">
                                <option value="">Selecione</option>
                                <option value="asc">Crescente</option>
                                <option value="desc">Decrescente</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" id="reportAcessod" class="btn btn-primary">Gerar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->
