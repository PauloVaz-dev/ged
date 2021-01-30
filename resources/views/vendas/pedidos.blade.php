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
                        <header>Lista de Pedidos</header>
                        <div class="tools">
                            <div class="btn-group">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-body panel-body-with-table">
                                <div class="table-responsive">
                                    <table id="pedidos" class="table order-column hover">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Id</th>
                                            <th>Integrador</th>
                                            <th>Cliente</th>
                                            <th>Data</th>
                                            <th>Faturado Por</th>
                                            <th>Total</th>
                                            <th>Desconto</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Acao</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div><!--end .table-responsive -->
                            </div>
                        </div><!--end .col -->
                    </div><!--end .row -->
                    <!-- END DATATABLE 1 -->
                </div><!--end .card -->

            </form>
        </div><!--end .col -->
    </div><!--end .row -->
    <!-- END HORIZONTAL FORM -->

    @include ('vendas.modalStatus')

@endsection

@section('javascript')
    <script src="{{ asset('/js/vendas/pedidos.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/js/mascaras.js')}}" type="text/javascript"></script>
@stop