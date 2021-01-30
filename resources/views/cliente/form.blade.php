<div class="card-body">

    <div class="col-lg-12">
        <h4 class="text-bold">Dados da Empresa</h4>
        <hr class="ruler-lg"/>
    </div>

    <div class="form-group {{ $errors->has('tipo') ? 'has-error' : '' }}">
        <label class="col-sm-2 control-label text-bold">Tipo Pessoa.: *</label>
        <div class="col-sm-10">
            <label class="radio-inline radio-styled radio-primary tipo_fisica">
                <input {{ isset($cliente->tipo) ? 'readonly=true' : '' }} id="tipo_fisica" class="tipoF" name="tipo" type="radio" value="Fisica" {{ old('tipo', isset($cliente->tipo) ? $cliente->tipo : null) == 'Fisica' ? 'checked' : '' }}>
                Fisica
            </label>
            <label class="radio-inline radio-styled radio-success tipo_juridico">
                <input {{ isset($cliente->tipo) ? 'readonly' : '' }} id="tipo_juridico" class="tipoJ" name="tipo" type="radio" value="Juridico"  {{ old('tipo', isset($cliente->tipo) ? $cliente->tipo : null) == 'Juridico' ? 'checked' : '' }}>
                Juridico
            </label>
        </div><!--end .col -->

    </div><!--end .form-group -->
    <div class="form-group {{ $errors->has('cpf_cnpj') ? 'has-error' : '' }}">
        <label for="cpf_cnpj" class="col-md-2 control-label text-bold">CPF/CNPJ.:</label>
        <div class="col-md-10">
            <input class="form-control mascara-cpfcnpj input-sm" name="cpf_cnpj" type="text" id="cpf_cnpj" value="{{ old('cpf_cnpj', isset($cliente->cpf_cnpj) ? $cliente->cpf_cnpj : null) }}" maxlength="255" placeholder="CPF/CNPJ...">
            {!! $errors->first('cpf_cnpj', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('nome_empresa') ? 'has-error' : '' }}">
        <label for="nome_empresa" class="col-md-2 control-label text-bold">Razão Social.: *</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="nome_empresa" type="text" id="nome_empresa" value="{{ old('nome_empresa', isset($cliente->nome_empresa) ? $cliente->nome_empresa : null) }}" maxlength="255" placeholder="Razão Social">
            {!! $errors->first('nome_empresa', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group {{ $errors->has('telefone') ? 'has-error' : '' }}">
                <label for="telefone" class="col-sm-6 control-label text-bold">Telefone.:</label>
                <div class="col-md-6">
                    <input class="form-control input-sm phone" name="telefone" type="text" id="telefone" value="{{ old('telefone', isset($cliente->telefone) ? $cliente->telefone : null) }}" maxlength="20">
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group {{ $errors->has('celular') ? 'has-error' : '' }}">
                <label for="celular" class="col-sm-4 control-label text-bold">Celular.:</label>
                <div class="col-md-6">
                    <input class="form-control input-sm phone" name="celular" type="text" id="celular" value="{{ old('celular', isset($cliente->celular) ? $cliente->celular : null) }}" maxlength="20">
                    {!! $errors->first('celular', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group {{ $errors->has('is_whatsapp') ? 'has-error' : '' }}">
                <label for="login" class="col-sm-4 control-label text-bold">É Whatsapp?.:</label>
                <div class="col-md-8">
                    <div class="checkbox checkbox-styled">
                        <label for="is_whatsapp">
                            <input id="is_whatsapp" class="input-sm" name="is_whatsapp" type="checkbox" value="1" {{ old('is_whatsapp', isset($cliente->is_whatsapp) ? $cliente->is_whatsapp : null) == '1' ? 'checked' : '' }}>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
        <label for="email" class="col-md-2 control-label text-bold">Email.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="email" type="text" id="email" value="{{ old('email', isset($cliente->email) ? $cliente->email : null) }}" maxlength="100">
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
        </div>
    </div>



    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="meio_captacao_id" class="col-md-4 text-bold control-label">Como conheceu nossa empresa?</label>
                <div class="col-md-8">
                    <select   class="form-control input-sm" id="meio_captacao_id" name="meio_captacao_id">
                        <option value="" style="display: none;" {{ old('meio_captacao_id', isset($cliente->meio_captacao_id) ? $cliente->meio_captacao_id : '') == '' ? 'selected' : '' }} disabled selected>Meios de captação</option>
                        @foreach ($meiosCaptacao as $key => $meioCaptacao)
                            <option value="{{ $key }}" {{ old('meio_captacao_id', isset($cliente->meio_captacao_id) ? $cliente->meio_captacao_id : null) == $key ? 'selected' : '' }}>
                                {{ $meioCaptacao }}
                            </option>
                        @endforeach
                    </select>
                    {!! $errors->first('meio_captacao_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="meio_captacao_id" class="col-md-4 text-bold control-label">Classificação.:</label>
                <div class="col-md-8">
                    <select   class="form-control input-sm" id="cliente_tipo_id" name="cliente_tipo_id">
                        <option value="" style="display: none;" {{ old('cliente_tipo_id', isset($cliente->cliente_tipo_id) ? $cliente->cliente_tipo_id : '') == '' ? 'selected' : '' }} disabled selected>Meios de captação</option>
                        @foreach ($clienteTipos as $key => $clienteTipo)
                            <option value="{{ $key }}" {{ old('cliente_tipo_id', isset($cliente->cliente_tipo_id) ? $cliente->cliente_tipo_id : null) == $key ? 'selected' : '' }}>
                                {{ $clienteTipo }}
                            </option>
                        @endforeach
                    </select>
                    {!! $errors->first('meio_captacao_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    @role('super-admin')
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="user_id" class="col-md-4 text-bold control-label">Integrador.:</label>
                    <div class="col-md-8">
                        <select   class="form-control input-sm" id="user_id" name="user_id">
                            <option value="" style="display: none;" {{ old('user_id', isset($cliente->user_id) ? $cliente->user_id : '') == '' ? 'selected' : '' }} disabled selected>Meios de captação</option>
                            @foreach ($users as $key => $user)
                                <option value="{{ $key }}" {{ old('user_id', isset($cliente->user->id) ? $cliente->user->id : null) == $key ? 'selected' : '' }}>
                                    {{ $user }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    @else

        <input style="display: none;" class="form-control input-sm" name="user_id" type="text" id="user_id" value="{{ old('user_id', isset($cliente->user_id) ? $cliente->user_id : null) }}" maxlength="100">

    @endrole




    <div class="col-lg-12">
        <h4 class="text-bold">Dados Pessoais</h4>
        <hr class="ruler-lg"/>
    </div>
    <div class="form-group {{ $errors->has('nome') ? 'has-error' : '' }}">
        <label for="nome" class="col-md-2 control-label text-bold">Nome.: *</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="nome" type="text" id="nome" value="{{ old('nome', isset($cliente->nome) ? $cliente->nome : null) }}" maxlength="255" placeholder="Nome">
            {!! $errors->first('nome', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="cpf" class="col-sm-4 control-label text-bold">CPF.:</label>
                <div class="col-sm-6">
                    <input class="form-control input-sm mascara-cpfcnpj" name="cpf" type="text" id="cpf" value="{{ old('cpf', isset($cliente->cpf) ? $cliente->cpf : null) }}" maxlength="11" placeholder="CPF">
                    {!! $errors->first('cpf', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="rg" class="col-md-4 control-label text-bold">RG.:</label>
                <div class="col-sm-6">
                    <input class="form-control input-sm" name="rg" type="text" id="rg" value="{{ old('rg', isset($cliente->rg) ? $cliente->rg : null) }}" maxlength="255" placeholder="RG">
                    {!! $errors->first('rg', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="data_emissao_rg" class="col-md-4 control-label text-bold">Data Emissão.:</label>
                <div class="col-md-6">
                    <input class="form-control input-sm date" name="data_emissao_rg" type="text" id="data_emissao_rg" value="{{ old('data_emissao_rg', isset($cliente->data_emissao_rg) ? $cliente->data_emissao_rg : null) }}" maxlength="255" placeholder="Data Emissão">
                    {!! $errors->first('data_emissao_rg', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="orgao_emissor_rg" class="col-md-4 control-label text-bold">Orgão Emissor.:</label>
                <div class="col-md-6">
                    <input class="form-control input-sm" name="orgao_emissor_rg" type="text" id="orgao_emissor_rg" value="{{ old('orgao_emissor_rg', isset($cliente->orgao_emissor_rg) ? $cliente->orgao_emissor_rg : null) }}" maxlength="255" placeholder="Orgão Emissor">
                    {!! $errors->first('orgao_emissor_rg', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>




    <div class="form-group {{ $errors->has('estado_civil') ? 'has-error' : '' }}">
        <label for="estado_civil" class="col-md-2 control-label text-bold">Estado Civil.:</label>
        <div class="col-md-10">
            <select class="form-control input-sm" id="estado_civil" name="estado_civil">
                <option value="" style="display: none;" {{ old('consumo', isset($projeto->estado_civil) ? $cliente->estado_civil : '') == '' ? 'selected' : '' }} disabled selected>Selecione um estado civil</option>
                @foreach (['Solteiro' => 'Solteiro',
    'Casado' => 'Casado',
    'Separado' => 'Separado',
    'Divorciado' => 'Divorciado',
    'Viúvo' => 'Viúvo'] as $key => $text)
                    <option value="{{ $key }}" {{ old('estado_civil', isset($cliente->estado_civil) ? $cliente->estado_civil : null) == $key ? 'selected' : '' }}>
                        {{ $text }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('estado_civil', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="nacionalidade" class="col-md-4 control-label text-bold">Nacionalidade.:</label>
                <div class="col-md-6">
                    <input class="form-control input-sm" name="nacionalidade" type="text" id="nacionalidade" value="{{ old('nacionalidade', isset($cliente->nacionalidade) ? $cliente->nacionalidade : null) }}" maxlength="255" placeholder="Nacionalidade">
                    {!! $errors->first('nacionalidade', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="naturalidade_uf" class="col-md-4 control-label text-bold">Naturalidade UF.:</label>
                <div class="col-md-6">
                    <input class="form-control input-sm" name="naturalidade_uf" type="text" id="naturalidade_uf" value="{{ old('naturalidade_uf', isset($cliente->naturalidade_uf) ? $cliente->naturalidade_uf : null) }}" maxlength="2" placeholder="Naturalidade UF">
                    {!! $errors->first('naturalidade_uf', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>

    <div class="form-group {{ $errors->has('data_nascimento') ? 'has-error' : '' }}">
        <label for="data_nascimento" class="col-md-2 control-label text-bold">Data Nascimento.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm date" name="data_nascimento" type="text" id="data_nascimento" value="{{ old('data_nascimento', isset($cliente->data_nascimento) ? $cliente->data_nascimento : null) }}" maxlength="255" placeholder="Data Nascimento">
            {!! $errors->first('data_nascimento', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-lg-12">
        <h4 class="text-bold">Conjugue</h4>
        <hr class="ruler-lg"/>
    </div>


    <div class="form-group {{ $errors->has('conjugue') ? 'has-error' : '' }}">
        <label for="conjugue" class="col-md-2 control-label text-bold">Nome Cojugue.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="conjugue" type="text" id="conjugue" value="{{ old('conjugue', isset($cliente->conjugue) ? $cliente->conjugue : null) }}" maxlength="255" placeholder="Nome do Conjugue.">
            {!! $errors->first('conjugue', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('conjugue_cpf') ? 'has-error' : '' }}">
        <label for="conjugue_cpf" class="col-md-2 control-label text-bold">CPF Cojugue.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm cpf" name="conjugue_cpf" type="text" id="conjugue" value="{{ old('conjugue_cpf', isset($cliente->conjugue_cpf) ? $cliente->conjugue_cpf : null) }}" maxlength="255" placeholder="CPF do Conjugue.">
            {!! $errors->first('conjugue_cpf', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-lg-12">
        <h4 class="text-bold">Endereço</h4>
        <hr class="ruler-lg"/>
    </div>

    <div class="form-group {{ $errors->has('cep') ? 'has-error' : '' }}">
        <label for="cep" class="col-md-2 control-label text-bold">Cep.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="cep" type="text" id="cep" value="{{ old('cep', isset($cliente->cep) ? $cliente->cep : null) }}" maxlength="10" placeholder="Enter cep here...">
            {!! $errors->first('cep', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="endereco" class="col-md-4 control-label text-bold">Endereco.:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" name="endereco" type="text" id="endereco" value="{{ old('endereco', isset($cliente->endereco) ? $cliente->endereco : null) }}" maxlength="200" placeholder="Endereço">
                    {!! $errors->first('endereco', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="bairro" class="col-sm-4 control-label text-bold">Bairro.:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" name="bairro" type="text" id="bairro" value="{{ old('bairro', isset($cliente->bairro) ? $cliente->bairro : null) }}" maxlength="100" placeholder="Bairro">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group {{ $errors->has('numero') ? 'has-error' : '' }}">
                <label for="numero" class="col-sm-4 control-label text-bold">Numero.:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" name="numero" type="text" id="numero" value="{{ old('numero', isset($cliente->numero) ? $cliente->numero : null) }}" maxlength="10" placeholder="Enter numero here...">
                    {!! $errors->first('numero', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group {{ $errors->has('complemento') ? 'has-error' : '' }}">
                <label for="complemento" class="col-sm-4 control-label text-bold">Complemento.:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" name="complemento" type="text" id="complemento" value="{{ old('complemento', isset($cliente->complemento) ? $cliente->complemento : null) }}" maxlength="200" placeholder="Enter complemento here...">
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
                    <input class="form-control input-sm" name="estado" type="text" id="estado" value="{{ old('estado', isset($cliente->estado) ? $cliente->estado : null) }}" maxlength="2" placeholder="Enter estado here...">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="cidade" class="col-sm-4 control-label text-bold">Cidade.:</label>
                <div class="col-md-8">
                    <input class="form-control input-sm" name="cidade" type="text" id="cidade" value="{{ old('cidade', isset($cliente->cidade) ? $cliente->cidade : null) }}" placeholder="Cidade">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label for="palavras_chave" class="col-sm-2 control-label text-bold">Palavras Chaves.:</label>
            <div class="col-md-10">
                <input class="form-control input-sm" name="palavras_chave" type="text" id="palavras_chave" value="{{ old('palavras_chave', isset($cliente->palavras_chave) ? $cliente->palavras_chave : null) }}">
            </div>
        </div>
    </div>
    </div>

    <div class="form-group {{ $errors->has('obs') ? 'has-error' : '' }}">
        <label for="obs" class="col-md-2 control-label text-bold">Obs.:</label>
        <div class="col-md-10">
            <textarea class="form-control input-sm" name="obs" cols="50" rows="10" id="obs" placeholder="Enter obs here...">{{ old('obs', isset($cliente->obs) ? $cliente->obs : null) }}</textarea>
            {!! $errors->first('obs', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    {{--<div class="col-xl-6">
        <div class="card">
            <div class="card-body ">
                <p class="ml-1"><strong>Histórico</strong></p>
                <ul class="timeline" id="historico">
                    <li class="timeline-item">
                        <div class="d-flex justify-content-between">
                            <strong>Projeto criado</strong>
                            <span class="float-right text-muted text-sm">24/01/20 às 12:20</span>
                        </div>
                        <span class="text-sm"><i>Josias Junior</i></span>
                        <p>Projeto criado com o título Projeto Casa do Joey (Exemplo)</p>
                    </li>
                    <li class="timeline-item">
                        <div class="d-flex justify-content-between">
                            <strong>Projeto criado</strong>
                            <span class="float-right text-muted text-sm">24/01/20 às 12:20</span>
                        </div>
                        <span class="text-sm"><i>Josias Junior</i></span>
                        <p>Projeto criado com o título Projeto Casa do Joey (Exemplo)</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
--}}

</div>

