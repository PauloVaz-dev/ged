<div class="form-group {{ $errors->has('descricaolei') ? 'has-error' : '' }}">
    <label for="descricaolei" class="col-md-2 control-label text-bold">Lei.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="descricaolei" type="text" id="descricaolei" value="{{ old('descricaolei', isset($digi->descricaolei) ? $digi->descricaolei : null) }}" maxlength="100">
        {!! $errors->first('descricaolei', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('data_lei') ? 'has-error' : '' }}">
    <label for="data_lei" class="col-md-2 control-label text-bold">Data da Lei.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm date" name="data_lei" type="text" id="data_lei" value="{{ old('data_lei', isset($digi->data_lei) ? $digi->data_lei : null) }}" maxlength="100">
        {!! $errors->first('data_lei', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('data_publica') ? 'has-error' : '' }}">
    <label for="data_publica" class="col-md-2 control-label text-bold">Data Publicação.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm date" name="data_publica" type="text" id="data_publica" value="{{ old('data_publica', isset($digi->data_publica) ? $digi->data_publica : null) }}" maxlength="100">
        {!! $errors->first('data_publica', '<p class="help-block">:message</p>') !!}
    </div>
</div>
