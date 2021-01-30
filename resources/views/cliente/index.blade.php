@extends('layouts.menu')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <!-- BEGIN HORIZONTAL FORM -->
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="" accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-head style-primary">
                            <header>Lista de Clientes</header>
                            <div class="tools">
                                <div class="btn-group">
                                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!--Accordion -->
                        <div class="col-md-12">
                            <div class="panel-group" id="accordion">
                                <div class="card panel">
                                    <div class="card-head card-head-xs collapsed" data-toggle="collapse" data-parent="#accordion7" data-target="#accordion7-1">
                                        <header>Filtro</header>
                                        <div class="tools">
                                            <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                                        </div>
                                    </div>
                                    <div id="accordion7-1" class="collapse">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="nome" class="col-sm-2 control-label">Nome:</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control input-sm" name="nome" type="text" id="nome" maxlength="20" placeholder="Nome">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="nome" class="col-sm-4 control-label">Rasão Social:</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control input-sm" name="nome_empresa" type="text" id="nome_empresa" maxlength="20" placeholder="Rasão Social">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="cpf_cnpj" class="col-sm-4 control-label">CPF/CNPJ:</label>
                                                        <div class="col-md-8">
                                                            <input class="form-control input-sm mascara-cpfcnpj" name="cpf_cnpj" type="text" id="cpf_cnpj" maxlength="20" placeholder="CPF/CNPJ">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="data_ini" class="col-sm-5 control-label">Data Ini.:</label>
                                                        <div class="col-md-7">
                                                            <input class="form-control input-sm date" name="data_ini" type="text" id="data_ini" value="{{ old('data_ini',  null) }}" placeholder="Início">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="data_fim" class="col-sm-5 control-label">Data Fim.:</label>
                                                        <div class="col-md-7">
                                                            <input class="form-control input-sm date" name="data_fim" type="text" id="data_fim" value="{{ old('data_fim',  null) }}" placeholder="Fim">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Filtrar data por:</label>
                                                        <div class="col-sm-9">
                                                            <label class="radio-inline radio-styled">
                                                                <input type="radio" name="filtro_por" checked value="created_at"><span>Cadastro</span>
                                                            </label>
                                                            <label class="radio-inline radio-styled">
                                                                <input type="radio" name="filtro_por" value="updated_at"><span>Atualização</span>
                                                            </label>
                                                        </div><!--end .col -->
                                                    </div><!--end .form-group -->
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="integrador" class="col-sm-2 control-label">Integrador:</label>
                                                        <div class="col-md-6">
                                                            <input class="form-control input-sm" name="integrador" type="text" id="integrador" maxlength="20" placeholder="Intergrador">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="is_propostas" class="col-md-4 control-label">Status</label>
                                                    <div class="col-md-8">
                                                        <select id="is_propostas" name="is_propostas" class="form-control input-sm">
                                                            <option value="">Todos</option>
                                                            <option value="1">Sem Proposta</option>
                                                            <option value="2">Propostas Geradas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <div class="col-md-8">
                                                            <a href="#" type="button" id="localizar" class="btn btn-sm btn-flat btn-primary ink-reaction">Localizar</a>
                                                            <input class="btn btn-sm btn-primary"  id="limpar" type="button" value="Limpar">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end .panel -->
                            </div><!--end .panel-group -->


                            <div class="row">
                            <div class="col-lg-12">
                                <div class="panel-body panel-body-with-table">
                                    <div class="table-responsive">
                                        <table id="cliente" class="table order-column hover">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Razão Social</th>
                                                    <th>Nome</th>
                                                    <th>CPF/CNPJ</th>
                                                    <th>Email</th>
                                                    <th>Telefone</th>
                                                    <th>Classificação</th>
                                                    <th>Integrador</th>
                                                    <th>Data Cadastro</th>
                                                    <th>Acao</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div><!--end .table-responsive -->
                                </div>
                            </div><!--end .col -->
                        </div><!--end .row -->
                        <!-- END DATATABLE 1 -->




                        <div class="card-actionbar">
                            <div class="card-actionbar-row">
                                 </div>
                        </div>



                    </div><!--end .card -->

                </form>
            </div><!--end .col -->
        </div><!--end .row -->
        <!-- END HORIZONTAL FORM -->
    @include('cliente.modalCliente')


@endsection

@section('javascript')
    <script src="{{ asset('/js/mascaras.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/js/cliente/index.js')}}" type="text/javascript"></script>

@stop