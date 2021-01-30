@extends('layouts.menu')

@section('content')

<!-- BEGIN HORIZONTAL FORM -->
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="" accept-charset="UTF-8" id="edit_franquia_form" name="edit_franquia_form" class="form-horizontal">
                <input name="_method" type="hidden" value="PUT">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-head style-primary">
                        <header>Editar account</header>
                        <div class="tools">
                            <div class="btn-group">
                                <a href="{{ route('franquia.franquia.index') }}" class="btn btn-primary" title="Show All Franquia">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Nome</dt>
            <dd>{{ $franquia->nome }}</dd>
            <dt>Cpf Cnpj</dt>
            <dd>{{ $franquia->cpf_cnpj }}</dd>
            <dt>Contato</dt>
            <dd>{{ $franquia->contato }}</dd>
            <dt>Telefone</dt>
            <dd>{{ $franquia->telefone }}</dd>
            <dt>Email</dt>
            <dd>{{ $franquia->email }}</dd>
            <dt>Cidade</dt>
            <dd>{{ $franquia->cidade }}</dd>
            <dt>Estado</dt>
            <dd>{{ $franquia->estado }}</dd>
            <dt>Endereco</dt>
            <dd>{{ $franquia->endereco }}</dd>
            <dt>Cep</dt>
            <dd>{{ $franquia->cep }}</dd>
            <dt>Bairro</dt>
            <dd>{{ $franquia->bairro }}</dd>
            <dt>Numero</dt>
            <dd>{{ $franquia->numero }}</dd>
            <dt>Complemento</dt>
            <dd>{{ $franquia->complemento }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $franquia->updated_at }}</dd>
            <dt>Created At</dt>
            <dd>{{ $franquia->created_at }}</dd>
            <dt>Is Active</dt>
            <dd>{{ ($franquia->is_active) ? 'Yes' : 'No' }}</dd>

                            </dl>

                        </div>


                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <a href="{{ route('franquia.franquia.index') }}" type="button" class="btn btn-flat btn-primary ink-reaction">Voltar</a>
                        </div>
                    </div>
                </div><!--end .card -->

            </form>
        </div><!--end .col -->
    </div><!--end .row -->
    <!-- END HORIZONTAL FORM -->

@endsection