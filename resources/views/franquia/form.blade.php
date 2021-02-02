<div class="card-body">
    <div class="col-lg-12">
        <h4 class="text-bold">Dados da Empresa</h4>
        <hr class="ruler-lg"/>
    </div>
<div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
    <label for="nome" class="col-md-2 control-label text-bold">Nome/Razão Social.:</label>
    <div class="col-md-10">

        @role('super-admin')
            <input class="form-control input-sm" name="nome" type="text" id="nome" value="{{ old('nome', isset($franquia->nome) ? $franquia->nome : null) }}" minlength="1" maxlength="200"  placeholder="Enter nome here...">
        @else
            <input  readonly class="form-control  input-sm" name="nome" type="text" id="nome" value="{{ old('nome', isset($franquia->nome) ? $franquia->nome : null) }}" minlength="1" maxlength="200"  placeholder="Enter nome here...">
            @endrole
    </div>
</div>

<div class="form-group {{ $errors->has('cpf_cnpj') ? 'has-error' : '' }}">
    <label for="cpf_cnpj" class="col-md-2 control-label text-bold">CPF/CNPJ.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm mascara-cpfcnpj" name="cpf_cnpj" type="text" id="cpf_cnpj" value="{{ old('cpf_cnpj', isset($franquia->cpf_cnpj) ? $franquia->cpf_cnpj : null) }}" minlength="1" maxlength="20" placeholder="Enter cpf cnpj here...">
        {!! $errors->first('cpf_cnpj', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('contato') ? 'has-error' : '' }}">
    <label for="contato" class="col-md-2 control-label text-bold">Contato.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="contato" type="text" id="contato" value="{{ old('contato', isset($franquia->contato) ? $franquia->contato : null) }}" minlength="1" maxlength="200" placeholder="Enter contato here...">
        {!! $errors->first('contato', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('telefone') ? 'has-error' : '' }}">
    <label for="telefone" class="col-md-2 control-label text-bold">Telefone.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm phone" name="telefone" type="text" id="telefone" value="{{ old('telefone', isset($franquia->telefone) ? $franquia->telefone : null) }}" maxlength="20" placeholder="Enter telefone here...">
        {!! $errors->first('telefone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label text-bold">Email.:</label>
    <div class="col-md-10">
        <input class="form-control input-sm" name="email" type="text" id="email" value="{{ old('email', isset($franquia->email) ? $franquia->email : null) }}" maxlength="100" placeholder="Enter email here...">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

    <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
        <label for="slug" class="col-md-2 control-label text-bold">Url.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="slug" type="text" id="slug" value="{{ old('slug', isset($franquia->slug) ? $franquia->slug : null) }}" maxlength="100" placeholder="Url do subdomínio">
        </div>
    </div>


    <div class="col-lg-12">
        <h4 class="text-bold">Endereço</h4>
        <hr class="ruler-lg"/>
    </div>

    <div class="form-group {{ $errors->has('cep') ? 'has-error' : '' }}">
        <label for="cep" class="col-md-2 control-label text-bold">Cep.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="cep" type="text" id="cep" value="{{ old('cep', isset($franquia->cep) ? $franquia->cep : null) }}" maxlength="10" placeholder="Enter cep here...">
            {!! $errors->first('cep', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('endereco') ? 'has-error' : '' }}">
        <label for="endereco" class="col-md-2 control-label text-bold">Endereco.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="endereco" type="text" id="endereco" value="{{ old('endereco', isset($franquia->endereco) ? $franquia->endereco : null) }}" maxlength="200" placeholder="Enter endereco here...">
            {!! $errors->first('endereco', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group {{ $errors->has('numero') ? 'has-error' : '' }}">
                <label for="numero" class="col-sm-4 control-label text-bold">Numero.:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" name="numero" type="text" id="numero" value="{{ old('numero', isset($franquia->numero) ? $franquia->numero : null) }}" maxlength="10" placeholder="Enter numero here...">
                    {!! $errors->first('numero', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group {{ $errors->has('complemento') ? 'has-error' : '' }}">
                <label for="complemento" class="col-sm-4 control-label text-bold">Complemento.:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" name="complemento" type="text" id="complemento" value="{{ old('complemento', isset($franquia->complemento) ? $franquia->complemento : null) }}" maxlength="200" placeholder="Enter complemento here...">
                    {!! $errors->first('complemento', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="estado" class="col-sm-4 control-label text-bold">Estado.:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" name="estado" type="text" id="estado" value="{{ old('estado', isset($franquia->estado) ? $franquia->estado : null) }}" maxlength="2" placeholder="Enter estado here...">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="cidade" class="col-sm-4 control-label text-bold">Cidade.:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" name="cidade" type="text" id="cidade" value="{{ old('cidade', isset($franquia->cidade) ? $franquia->cidade : null) }}" placeholder="Cidade">
                </div>
            </div>
        </div>
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

