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

<div class="form-group {{ $errors->has('tipodoc_id') ? 'has-error' : '' }}">
    <label for="tipodoc_id" class="col-md-2 control-label text-bold">Tipo Documento.:</label>
    <div class="col-md-10">
        <select class="form-control input-sm" id="tipodoc_id" name="tipodoc_id">
            <option value="" style="display: block;" disabled selected>Selecione uma Tipo</option>
            @foreach ($tipoDocs as $key => $tipodoc)
                <option value="{{ $key }}" {{ old('tipodoc_id', isset($digi->tipodoc_id) ? $digi->tipodoc_id : null) == $key ? 'selected' : '' }}>
                    {{ $tipodoc }}
                </option>
            @endforeach
        </select>
    </div>
</div>

