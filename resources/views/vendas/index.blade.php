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
                <div class="card vendas">
                    <div class="card-head style-primary">
                        <header>Orçamento personalizado</header>
                        <header>Valor total dos produtos</header>
                        <div class="col-6 span_total">
                                <span class="badge badge-dark float-right">
                                    R$ 0,0
                                </span>
                        </div>
                    </div>

                    <div class="row">

                        <!-- BEGIN LAYOUT LEFT ALIGNED -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-head">
                                    <ul class="nav nav-tabs" data-toggle="tabs">
                                        <li ><a href="#inversores">INVERSORES</a></li>
                                        <li><a href="#modulos">MÓDULOS</a></li>
                                        <li><a href="#estrutura">ESTRUTURA</a></li>
                                        <li><a href="#eletrica">ELÉTRICA</a></li>
                                        <li class="active"><a href="#finalizar">FINALIZAR</a></li>
                                    </ul>
                                </div><!--end .card-head -->
                                <div class="card-body tab-content">
                                    <div class="tab-pane" id="inversores">
                                        @include('vendas.inversores')
                                    </div>
                                    <div class="tab-pane" id="modulos">
                                        @include('vendas.modulos')
                                    </div>
                                    <div class="tab-pane" id="estrutura">
                                        @include('vendas.estrutura')
                                    </div>
                                    <div class="tab-pane" id="eletrica">
                                        @include('vendas.eletrica')
                                    </div>
                                    <div class="tab-pane active" id="finalizar">
                                        @include('vendas.finalizar')
                                    </div>


                                </div><!--end .card-body -->
                            </div><!--end .card -->

                        </div><!--end .col -->
                        <!-- END LAYOUT LEFT ALIGNED -->




                    </div><!--end .row -->
                    <!-- END DATATABLE 1 -->
                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <button type="button" id="salvar_orcamento" class="btn btn-primary">Salvar orçamento</button>

                        </div>
                    </div>

                </div><!--end .card -->



            </form>
        </div><!--end .col -->
    </div><!--end .row -->
    <!-- END HORIZONTAL FORM -->

@endsection

@section('javascript')
    <script src="{{ asset('/js/vendas/index.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/js/mascaras.js')}}" type="text/javascript"></script>
@stop