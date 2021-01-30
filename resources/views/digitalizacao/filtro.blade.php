<!--Accordion -->
<div class="col-md-12">
    <div class="panel-group" id="accordion8">
        <div class="card panel">
            <div class="card-head card-head-xs collapsed" data-toggle="collapse" data-parent="#accordion8" data-target="#accordion8-1">
                <header>Filtro</header>
                <div class="tools">
                    <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                </div>
            </div>
            <div id="accordion8-1" class="collapse">
                <div class="card">
                    <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="descricao">
                                        <label class="card-body__lable" for="Firstname2">Descrição</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select id="despesa_id" class="form-control input-sm" name="despesa_id" class="form-control input-sm">
                                            <option value="">Todos</option>
                                            <option value="4">Despesa</option>
                                            <option value="2">Folha</option>
                                            <option value="1">Licitação</option>
                                            <option value="3">Lei</option>
                                            <option value="5">Outros</option>
                                        </select>
                                        <label class="card-body__lable" for="Lastname2">Tipo</label>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="numero_processo">
                                        <label class="card-body__lable" for="Lastname2">N Processo</label>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" id="competencia">
                                        <label class="card-body__lable" for="Lastname2">Conpetência</label>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm" id="convenio">
                                    <label  class="card-body__lable" for="Firstname2">Convênio</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm" id="conta">
                                    <label class="card-body__lable" for="Lastname2">Conta</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm" id="numero_licitacao">
                                    <label  class="card-body__lable" for="Lastname2">N Licitação</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <a href="#" type="button" id="localizar" class="btn btn-sm btn-flat btn-primary ink-reaction">Localizar</a>
                                        <input class="btn btn-sm btn-primary"  id="limpar" type="button" value="Limpar">
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div><!--end .card-body -->
                </div><!--end .card -->
            </div>
        </div><!--end .panel -->
    </div><!--end .panel-group -->
</div>