<div class="card-body">

    <div class="col-lg-12">
        <h4 class="text-bold">Dados Pessoais</h4>
        <hr class="ruler-lg"/>
    </div>
    <br> <br><br>


    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
        <label for="name" class="col-md-2 control-label">Nome.: *</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="name" type="text" id="name" value="{{ old('name', isset($user->name) ? $user->name : null) }}" maxlength="100" placeholder="Nome">
            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email" class="col-md-2 control-label">email.: *</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="email" type="text" id="email" value="{{ old('email', isset($user->email) ? $user->email : null) }}" maxlength="100" placeholder="Email">
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>


    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <label for="password" class="col-md-2 control-label">Senha.: *</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="password" type="password" id="password" value="" maxlength="100" placeholder="Senha">
            {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <label for="password" class="col-md-2 control-label">Grupo.: *</label>
        <div class="col-md-10">
            @foreach ($roles as $key => $role)

                <input id="permissions" class="" name="roles[]" type="checkbox" value="{{ $key  }}"  {{ in_array($key, $userRole) ? 'checked' : '' }}>
                {{ Form::label($role, ucfirst($role)) }}<br>
            @endforeach
        </div>
    </div>

    <div class="form-group {{ $errors->has('secretaria_id') ? 'has-error' : '' }}">
        <label for="franquia_id" class="col-md-2 control-label">Secretaria.: *</label>
        <div class="col-md-10">
            <select class="form-control input-sm" id="franquia_id" name="secretaria_id">
                <option value="" style="display: none;" {{ old('$secretaria_id', null) }} disabled selected>Selecione uma Secretaria</option>
                @foreach ($secretarias as $key => $secretaria)
                    <option value="{{ $key }}" {{ old('$secretaria_id', isset($user->secretaria->id) ? $user->secretaria->id : null) == $key ? 'selected' : '' }}>
                        {{ $secretaria }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{ $errors->has('franquia_id') ? 'has-error' : '' }}">
        <label for="franquia_id" class="col-md-2 control-label">Instituição.: *</label>
        <div class="col-md-10">
            <select class="form-control input-sm" id="franquia_id" name="franquia_id">
                <option value="" style="display: none;" {{ old('$user->roles[0]->id', null) }} disabled selected>Selecione uma Prefeitura</option>
                @foreach ($franquias as $key => $franquia)
                    <option value="{{ $key }}" {{ old('franquia_id', isset($user->franquia->id) ? $user->franquia->id : null) == $key ? 'selected' : '' }}>
                        {{ $franquia }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
        <label for="is_active" class="col-md-2 control-label text-bold">Ativo?.:</label>
        <div class="col-md-10">
            <div class="checkbox">
                <label for="is_active_1">
                    <input id="is_active" class="" name="is_active" type="checkbox" value="1" {{ old('is_active', isset($user->is_active) ? $user->is_active : null) == '1' ? 'checked' : '' }}>
                    Sim
                </label>
            </div>

            {!! $errors->first('is_active', '<p class="help-block">:message</p>') !!}
        </div>
    </div>


</div>
