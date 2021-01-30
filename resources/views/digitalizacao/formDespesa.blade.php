<div class="form-group {{ $errors->has('id_secretaria') ? 'has-error' : '' }}">
    <label for="id_secretaria" class="col-md-2 control-label text-bold">Unidade Gestora.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="id_secretaria" type="text" id="id_secretaria" value="{{ old('id_secretaria', isset($digi->id_secretaria) ? $digi->id_secretaria : null) }}" maxlength="100">
        {!! $errors->first('funcionario', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('unidade_orcamento') ? 'has-error' : '' }}">
    <label for="unidade_orcamento" class="col-md-2 control-label text-bold">Unidade Orçamentaria.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="unidade_orcamento" type="text" id="unidade_orcamento" value="{{ old('unidade_orcamento', isset($digi->unidade_orcamento) ? $digi->unidade_orcamento : null) }}" maxlength="100">
        {!! $errors->first('cpf', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('fornecedor') ? 'has-error' : '' }}">
    <label for="fornecedor" class="col-md-2 control-label text-bold">Fornecedor.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="fornecedor" type="text" id="fornecedor" value="{{ old('fornecedor', isset($digi->fornecedor) ? $digi->fornecedor : null) }}" maxlength="100">
        {!! $errors->first('fornecedor', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('cpf_fornecedor') ? 'has-error' : '' }}">
    <label for="cpf_fornecedor" class="col-md-2 control-label text-bold">Cnpj/Cpf Fornecedor.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="cpf_fornecedor" type="text" id="cpf_fornecedor" value="{{ old('cpf_fornecedor', isset($digi->cpf_fornecedor) ? $digi->cpf_fornecedor : null) }}" maxlength="100">
        {!! $errors->first('cpf_fornecedor', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('id_empenho') ? 'has-error' : '' }}">
    <label for="y" class="col-md-2 control-label text-bold">Tipo Empenho.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="y" type="text" id="data_empenho" value="{{ old('data_empenho', isset($digi->id_empenho) ? $digi->data_empenho : null) }}" maxlength="100">
        {!! $errors->first('lotacao', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('data_empenho') ? 'has-error' : '' }}">
    <label for="data_empenho" class="col-md-2 control-label text-bold">Data Empenho.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm date" name="data_empenho" type="text" id="data_empenho" value="{{ old('data_empenho', isset($digi->data_empenho) ? $digi->data_empenho : null) }}" maxlength="100">
        {!! $errors->first('lotacao', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('numero_empenho') ? 'has-error' : '' }}">
    <label for="numero_empenho" class="col-md-2 control-label text-bold">Numero Empenho.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="numero_empenho" type="text" id="numero_empenho" value="{{ old('numero_empenho', isset($digi->numero_empenho) ? $digi->numero_empenho : null) }}" maxlength="100">
        {!! $errors->first('numero_empenho', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('data_pagto') ? 'has-error' : '' }}">
    <label for="data_pagto" class="col-md-2 control-label text-bold">Data Pagamento.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm date" name="data_pagto" type="text" id="data_pagto" value="{{ old('data_pagto', isset($digi->data_pagto) ? $digi->data_pagto : null) }}" maxlength="100">
        {!! $errors->first('data_pagto', '<p class="help-block">:message</p>') !!}
    </div>
</div>