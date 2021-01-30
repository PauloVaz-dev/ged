<div class="form-group {{ $errors->has('numero_licitacao') ? 'has-error' : '' }}">
    <label for="modalidade_id" class="col-md-2 control-label text-bold">Unidade Orçamento.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="modalidade_id" type="text" id="modalidade_id" value="{{ old('numero_licitacao', isset($digi->numero_licitacao) ? $digi->modalidade_id : null) }}" maxlength="100">
        {!! $errors->first('unidade_orcamento', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('objeto_licitacao') ? 'has-error' : '' }}">
    <label for="objeto_licitacao" class="col-md-2 control-label text-bold">Objeto Licitação.:</label>
    <div class="col-md-10">
        <textarea class="form-control input-sm" name="objeto_licitacao" cols="50" rows="5" id="objeto_licitacao">{{ old('objeto_licitacao', isset($digi->objeto_licitacao) ? $digi->objeto_licitacao : null) }}</textarea>
        {!! $errors->first('objeto_licitacao', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('data_homologa') ? 'has-error' : '' }}">
    <label for="data_homologa" class="col-md-2 control-label text-bold">Data Homologação.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm date" name="data_homologa" type="text" id="data_homologa" value="{{ old('data_homologa', isset($digi->data_homologa) ? $digi->data_homologa : null) }}" maxlength="100">

    </div>
</div>

<div class="form-group {{ $errors->has('vencedor') ? 'has-error' : '' }}">
    <label for="vencedor" class="col-md-2 control-label text-bold">Vencedor.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="vencedor" type="text" id="vencedor" value="{{ old('vencedor', isset($digi->vencedor) ? $digi->vencedor : null) }}" maxlength="100">
        {!! $errors->first('vencedor', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('valor') ? 'has-error' : '' }}">
    <label for="valor" class="col-md-2 control-label text-bold">Valor.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="valor" type="text" id="valor" value="{{ old('valor', isset($digi->valor) ? $digi->valor : null) }}" maxlength="100">
        {!! $errors->first('valor', '<p class="help-block">:message</p>') !!}
    </div>
</div>