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
                            <header>Lista de Produtos</header>
                            <div class="tools">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-primary" title="Novo Produto">
                                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <ul>
                                @foreach ($categories as $category)
                                    <li>{{ $category->name }}</li>
                                    <ul>
                                        @foreach ($category->childrenCategories as $childCategory)
                                            @include('categories.child_category', ['categories.child_category' => $childCategory])
                                        @endforeach
                                    </ul>
                                @endforeach
                            </ul>
                        </div><!--end .row -->
                        <!-- END DATATABLE 1
                        <div class="card-actionbar">

                        </div>
                    </div><!--end .card -->

                </form>
            </div><!--end .col -->
        </div><!--end .row -->
        <!-- END HORIZONTAL FORM -->

@endsection

@section('javascript')
    <script src="{{ asset('/js/produto/index.js')}}" type="text/javascript"></script>
@stop