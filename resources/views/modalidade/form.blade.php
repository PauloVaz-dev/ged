<div class="card-body">

    <div class="form-group {{ $errors->has('descricao') ? 'has-error' : '' }}">
        <label for="descricao" class="col-md-2 control-label">Descricao.: *</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="descricao" type="text" id="descricao" value="{{ old('name', isset($modalidade->descricao) ? $modalidade->descricao : null) }}" maxlength="100" placeholder="Nome">
        </div>
    </div>

    <div class="form-group">
        <label for="is_active" class="col-md-2 control-label text-bold">Ativo?.:</label>
        <div class="col-md-10">
            <div class="checkbox">
                <label for="ativo">
                    <input id="ativo" class="" name="ativo" type="checkbox" value="1" {{ old('ativo', isset($modalidade->ativo) ? $modalidade->ativo : null) == '1' ? 'checked' : '' }}>
                    Sim
                </label>
            </div>
        </div>
    </div>
</div>
