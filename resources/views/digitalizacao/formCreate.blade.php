<div class="card-body">

    <div class="col-lg-12">
        <h4 class="text-bold">Tipo despesa: {{ strtoupper( $despesa_tipo )}}</h4>
        <hr class="ruler-lg"/>
    </div>
    <br> <br><br>

    <div class="form-group {{ $errors->has('descricao') ? 'has-error' : '' }}">
        <label for="descricao" class="col-md-2 control-label text-bold">Descricao.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="descricao" type="text" id="descricao" value="{{ old('descricao', isset($digi->descricao) ? $digi->descricao : null) }}" maxlength="100">
            {!! $errors->first('descricao', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('numero_processo') ? 'has-error' : '' }}">
        <label for="email" class="col-md-2 control-label text-bold">Número Processo.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="numero_processo" type="text" id="numero_processo" value="{{ old('numero_processo', isset($digi->numero_processo) ? $digi->numero_processo : null) }}" maxlength="100">
            {!! $errors->first('descricao', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('competencia') ? 'has-error' : '' }}">
        <label for="competencia" class="col-md-2 control-label text-bold">Competência.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="competencia" type="text" id="competencia" value="{{ old('competencia', isset($digi->competencia) ? $digi->competencia : null) }}" maxlength="100">
            {!! $errors->first('descricao', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('convenio') ? 'has-error' : '' }}">
        <label for="email" class="col-md-2 control-label text-bold">Convênio.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="convenio" type="text" id="convenio" value="{{ old('convenio', isset($digi->convenio) ? $digi->convenio : null) }}" maxlength="100">
            {!! $errors->first('descricao', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('conta') ? 'has-error' : '' }}">
        <label for="conta" class="col-md-2 control-label text-bold">Conta.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="conta" type="text" id="conta" value="{{ old('conta', isset($digi->conta) ? $digi->conta : null) }}" maxlength="100">
            {!! $errors->first('conta', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('numero_licitacao') ? 'has-error' : '' }}">
        <label for="numero_licitacao" class="col-md-2 control-label text-bold">Número Licitação.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="numero_licitacao" type="text" id="numero_licitacao" value="{{ old('numero_licitacao', isset($digi->numero_licitacao) ? $digi->numero_licitacao : null) }}" maxlength="100">
            {!! $errors->first('numero_licitacao', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('secretaria_id') ? 'has-error' : '' }}">
        <label for="franquia_id" class="col-md-2 control-label">Secretaria.: *</label>
        <div class="col-md-10">
            <select class="form-control input-sm" id="franquia_id" name="secretaria_id">
                <option value="" style="display: none;" {{ old('$secretaria_id', null) }} disabled selected>Selecione uma Secretaria</option>
                @foreach ($secretarias as $key => $secretaria)
                    <option value="{{ $key }}" {{ old('$secretaria_id', isset($digi->secretaria->id) ? $digi->secretaria->id : null) == $key ? 'selected' : '' }}>
                        {{ $secretaria }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    @if($despesa_tipo == 'licitacao')
        <input hidden  name="despesa_id" type="text"  value="1">
        @include ('digitalizacao.formLicitacao', ['digis' => null, ])
    @endif

    @if($despesa_tipo == 'folha')
        <input hidden  name="despesa_id" type="text"  value="2">
        @include ('digitalizacao.formFolha', ['digis' => null, ])
    @endif

    @if($despesa_tipo ==  'lei')
        <input hidden  name="despesa_id" type="text"  value="3">
        @include ('digitalizacao.formLei', ['digis' => null, ])
    @endif

    @if($despesa_tipo ==  'despesa')
        <input hidden  name="despesa_id" type="text"  value="4">
        @include ('digitalizacao.formDespesa', ['digis' => null, ])
    @endif

    @if($despesa_tipo == 'outros')
        <input hidden  name="despesa_id" type="text"  value="5">
        @include ('digitalizacao.formOutros', ['digis' => null, ])
    @endif

    <div class="form-group {{ $errors->has('localizacao') ? 'has-error' : '' }}">
        <label for="localizacao" class="col-md-2 control-label text-bold">Localização Interna.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="localizacao" type="text" id="localizacao" value="{{ old('localizacao', isset($digi->localizacao) ? $digi->localizacao : null) }}" maxlength="100">
            {!! $errors->first('localizacao', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="form-group {{ $errors->has('arquivo') ? 'has-error' : '' }}">
        <label for="arquivo" class="col-md-2 control-label text-bold">Documento.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="arquivo" type="file" id="arquivo" value="{{ old('arquivo', isset($digi->ProjetosDocumento->arquivo) ? $digi->ProjetosDocumento->arquivo : "") }}">
        </div>
    </div>
</div>
