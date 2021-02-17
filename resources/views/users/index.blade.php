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
                    <div class="card-head style-digi">
                        <header>Lista de Usuários</header>
                        <div class="tools">
                            <div class="btn-group">
                                <a href="{{ route('users.user.create') }}" class="btn btn-primary" title="Novo Fornecedor">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body panel-body-with-table">
                                <div class="table-responsive">
                                    <table id="users" class="table order-column hover">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>Secretaria</th>
                                            <th>Instituição</th>
                                            <th>Ativo</th>
                                            <th>Ação</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div><!--end .table-responsive -->
                            </div>
                        </div><!--end .col -->
                    </div><!--end .row -->
                    <!-- END DATATABLE 1 -->

                    @can('create.users')
                        <div class="card-actionbar">
                            <div class="card-actionbar-row">
                                <a href="{{ route('users.user.create') }}" type="button" class="btn btn-flat ink-reaction">Novo Usuário</a>
                            </div>
                        </div>
                    @endcan

                </div><!--end .card -->

            </form>
        </div><!--end .col -->
    </div><!--end .row -->
    <!-- END HORIZONTAL FORM -->

@endsection

@section('javascript')
    <script src="{{ asset('/js/users/index.js')}}" type="text/javascript"></script>
@stop