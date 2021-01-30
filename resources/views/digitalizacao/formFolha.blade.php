<div class="form-group {{ $errors->has('funcionario') ? 'has-error' : '' }}">
    <label for="funcionario" class="col-md-2 control-label text-bold">Funcionario.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="funcionario" type="text" id="funcionario" value="{{ old('funcionario', isset($digi->funcionario) ? $digi->funcionario : null) }}" maxlength="100">
        {!! $errors->first('funcionario', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('cpf') ? 'has-error' : '' }}">
    <label for="cpf" class="col-md-2 control-label text-bold">CPF.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="cpf" type="text" id="cpf" value="{{ old('cpf', isset($digi->cpf) ? $digi->cpf : null) }}" maxlength="100">
        {!! $errors->first('cpf', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group {{ $errors->has('matricula') ? 'has-error' : '' }}">
    <label for="matricula" class="col-md-2 control-label text-bold">Matricula.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="matricula" type="text" id="data_homologa" value="{{ old('matricula', isset($digi->matricula) ? $digi->matricula : null) }}" maxlength="100">
        {!! $errors->first('matricula', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('portaria') ? 'has-error' : '' }}">
    <label for="portaria" class="col-md-2 control-label text-bold">Portaria.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="portaria" type="text" id="portaria" value="{{ old('portaria', isset($digi->portaria) ? $digi->portaria : null) }}" maxlength="100">
        {!! $errors->first('portaria', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('data_admissao') ? 'has-error' : '' }}">
    <label for="data_admissao" class="col-md-2 control-label text-bold">Data Admissão.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm date" name="data_admissao" type="text" id="data_admissao" value="{{ old('data_admissao', isset($digi->data_admissao) ? $digi->data_admissao : null) }}" maxlength="100">
        {!! $errors->first('lotacao', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('lotacao') ? 'has-error' : '' }}">
    <label for="lotacao" class="col-md-2 control-label text-bold">Lotação.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="lotacao" type="text" id="lotacao" value="{{ old('lotacao', isset($digi->lotacao) ? $digi->lotacao : null) }}" maxlength="100">
        {!! $errors->first('lotacao', '<p class="help-block">:message</p>') !!}
    </div>
</div>