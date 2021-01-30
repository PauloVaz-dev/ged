@extends('layouts.menu')

@section('content')

<!-- BEGIN HORIZONTAL FORM -->
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="" accept-charset="UTF-8" id="edit_cliente_form" name="edit_cliente_form" class="form-horizontal">
                <input name="_method" type="hidden" value="PUT">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-head style-primary">
                        <header>Editar account</header>
                        <div class="tools">
                            <div class="btn-group">
                                <a href="{{ route('cliente.cliente.index') }}" class="btn btn-primary" title="Show All Cliente">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Nome</dt>
            <dd>{{ $cliente->nome }}</dd>
            <dt>Celular</dt>
            <dd>{{ $cliente->celular }}</dd>
            <dt>Email</dt>
            <dd>{{ $cliente->email }}</dd>
            <dt>Nome Empresa</dt>
            <dd>{{ $cliente->nome_empresa }}</dd>
            <dt>Cep</dt>
            <dd>{{ $cliente->cep }}</dd>
            <dt>Numero</dt>
            <dd>{{ $cliente->numero }}</dd>
            <dt>Endereco</dt>
            <dd>{{ $cliente->endereco }}</dd>
            <dt>Complemento</dt>
            <dd>{{ $cliente->complemento }}</dd>
            <dt>Estado</dt>
            <dd>{{ $cliente->estado }}</dd>
            <dt>Is Whatsapp</dt>
            <dd>{{ ($cliente->is_whatsapp) ? 'Yes' : 'No' }}</dd>
            <dt>Obs</dt>
            <dd>{{ $cliente->obs }}</dd>

                            </dl>

                        </div>


                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <a href="{{ route('cliente.cliente.index') }}" type="button" class="btn btn-flat btn-primary ink-reaction">Voltar</a>
                        </div>
                    </div>
                </div><!--end .card -->

            </form>
        </div><!--end .col -->
    </div><!--end .row -->
    <!-- END HORIZONTAL FORM -->

@endsection