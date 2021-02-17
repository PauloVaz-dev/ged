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
                                        <input type="text" class="form-control input-sm date" name="data_ini" id="data_ini">
                                        <label class="card-body__lable" for="Lastname2">Data Início</label>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm date" name="data_fim" id="data_fim">
                                        <label class="card-body__lable" for="Lastname2">Data Final</label>
                                    </div>
                                </div>
                            </div>

                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <select id="filtro_por" class="form-control input-sm" name="filtro_por" class="form-control input-sm">
                                        <option value="digitalizacao.descricao">Descricao</option>
                                        <option value="numero_processo">Número Processo</option>
                                        <option value="competencia">Competência</option>
                                        <option value="convenio">Convênio</option>
                                        <option value="conta">Conta</option>
                                        <option value="unidade_orcamento">Unidade Orcamento</option>
                                        <option value="fornecedor">fornecedor</option>
                                        <option value="numero_empenho">Numero Empenho</option>
                                        <option value="numero_licitacao">Número Licitacao</option>
                                        <option value="objeto_licitacao">Objeto Licitacao</option>
                                        <option value="conta">Conta</option>
                                        <option value="data_empenho">Data Empenho</option>
                                        <option value="data_homologa">Data Homologa</option>
                                        <option value="data_docto">Data Documento</option>
                                        <option value="data_publica">Data Publicação</option>
                                        <option value="data_lei">Data Lei</option>
                                        <option value="data_admissao">Data Admissão</option>
                                        <option value="data_pagto">Data Pagamento</option>
                                    </select>
                                    <label class="card-body__lable" for="Lastname2">Filtro Por</label>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select class="form-control input-sm" id="secretaria_id" name="secretaria_id">
                                        <option value="" {{ old('$secretaria_id', null) }}>Todas</option>
                                        @foreach ($secretarias as $key => $secretaria)
                                            <option value="{{ $key }}" {{ old('$secretaria_id', isset($user->secretaria->id) ? $user->secretaria->id : null) == $key ? 'selected' : '' }}>
                                                {{ $secretaria }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label class="card-body__lable" for="Lastname2">Secretaria</label>
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