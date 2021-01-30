
<!-- BEGIN FORM MODAL MARKUP -->
<div class="modal fade" id="formModalStatus" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="formModalLabel">Novo Status</h4>
            </div>
            <form class="form-horizontal" role="form">
                <div class="modal-body">

                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="ano" class="control-label">Status</label>
                        </div>
                        <div class="col-sm-9">
                            <select id="peditoStatus" name="peditoStatus" class="form-control input-sm">
                                <option value="1">Aguardando Pagamaneto</option>
                                <option value="2">Em separação</option>
                                <option value="3">Em rota</option>
                                <option value="4">Entregue</option>
                                <option value="5">Cancelado</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3">
                            <label for="desconto" class="control-label">Desconto</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="desconto" id="desconto" class="form-control input-sm money" placeholder="Desconto">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" id="BtnPedidoStatus" class="btn btn-primary">Gerar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END FORM MODAL MARKUP -->
