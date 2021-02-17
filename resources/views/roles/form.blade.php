<div class="card-body">


<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label text-bold">Grupo.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm " name="name" type="text" id="cpf_cnpj" value="{{ old('name', isset($role->name) ? $role->name : null) }}" minlength="1" maxlength="20">
        {!! $errors->first('cpf_cnpj', '<p class="help-block">:message</p>') !!}
    </div>
</div>



    <div class="grid-container">
        @foreach($permissionGroup as $name => $member)
            <div>
                <div for="login" class="text-bold item">{{ $name }}:</div>
                @foreach ($member as $value)
                    <input id="permissions" class="" name="permission[]" type="checkbox" value="{{ $value->id  }}"  {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>

                    {{ Form::label($value->description, ucfirst($value->description)) }}<br>
                @endforeach
            </div>

        @endforeach
    </div>
    @role('super-admin')
<div class="form-group">
    <label for="is_active" class="col-md-2 control-label text-bold">Ativo?.:</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="is_active_1">
            	<input id="is_active_1" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', isset($franquia->is_active) ? $franquia->is_active : null) == '1' ? 'checked' : '' }}>
                Sim
            </label>
        </div>
    </div>
</div>
    @endrole

</div>

