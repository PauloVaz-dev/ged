<div class="form-group {{ $errors->has('documento') ? 'has-error' : '' }}">
    <label for="documento" class="col-md-2 control-label text-bold">Documento.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="documento" type="text" id="documento" value="{{ old('documento', isset($digi->documento) ? $digi->documento : null) }}" maxlength="100">
        {!! $errors->first('documento', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('data_docto') ? 'has-error' : '' }}">
    <label for="data_docto" class="col-md-2 control-label text-bold">Data Documento.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm date" name="data_docto" type="text" id="data_docto" value="{{ old('data_docto', isset($digi->data_docto) ? $digi->data_docto : null) }}" maxlength="100">
        {!! $errors->first('data_lei', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('objeto_docto') ? 'has-error' : '' }}">
    <label for="objeto_docto" class="col-md-2 control-label text-bold">Objeto.:</label>
    <div class="col-md-10">
        <textarea class="form-control input-sm" name="objeto_docto" cols="50" rows="5" id="objeto_docto">{{ old('objeto_docto', isset($digi->objeto_docto) ? $digi->objeto_docto : null) }}</textarea>
        {!! $errors->first('data_publica', '<p class="help-block">:message</p>') !!}
    </div>
</div>


