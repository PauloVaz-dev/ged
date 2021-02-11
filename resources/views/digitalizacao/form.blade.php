<div class="card-body">

    <div class="col-lg-12">
        <h4 class="text-bold">Despesa Tipo: {{ strtoupper($digi->despesa->descricao) }} </h4>
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

    @if($digi->despesa_id == 1)
        @include ('digitalizacao.formLicitacao', ['digis' => $digi, ])
    @endif

    @if($digi->despesa_id == 2)
        @include ('digitalizacao.formFolha', ['digis' => $digi, ])
    @endif

    @if($digi->despesa_id == 3)
        @include ('digitalizacao.formLei', ['digis' => $digi, ])
    @endif

    @if($digi->despesa_id == 4)
        @include ('digitalizacao.formDespesa', ['digis' => $digi])
    @endif

    @if($digi->despesa_id == 5)

        @include ('digitalizacao.formOutros', ['digis' => $digi, 'tipoDocs' => $tipoDocs ])
    @endif

    <div class="form-group {{ $errors->has('localizacao') ? 'has-error' : '' }}">
        <label for="localizacao" class="col-md-2 control-label text-bold">Localização Interna.:</label>
        <div class="col-md-10">
            <input class="form-control input-sm" name="localizacao" type="text" id="localizacao" value="{{ old('localizacao', isset($digi->localizacao) ? $digi->localizacao : null) }}" maxlength="100">
            {!! $errors->first('localizacao', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    @foreach( $digi->files as $file )

        <div class="col-sm-10">
            <div class="form-group">
                <label for="arquivo" class="col-sm-3 control-label text-bold"><a target="_blank" href="{{ url("/{$file->file}") }}" >Link Arquivo</a></label>

            </div>
        </div>

    @endforeach

    <div class="row after-add-more-documento">
        <div class="col-sm-6">
            <div class="form-group">
                <div class="col-md-2">
                    <div class="">
                        <label for="">
                            <button class="btn btn-primary add-more-documento btn-sm" type="button"><i class="glyphicon glyphicon-plus"></i> Documento</button>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
