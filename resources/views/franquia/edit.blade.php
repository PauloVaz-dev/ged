@extends('layouts.menu')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times&times;</span>
            </button>

        </div>
    @endif

    @if(Session::has('errors'))
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times&times;</a>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- BEGIN HORIZONTAL FORM -->
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="{{ route('franquia.franquia.update', $franquia->id) }}" accept-charset="UTF-8" id="edit_franquia_form" name="edit_franquia_form" class="form-horizontal" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}
                    <div class="card">
                        <div class="card-head style-digi">
                            <header>Editar Instituição</header>
                            <div class="tools">
                                <div class="btn-group">
                                    @role('super-admin')
                                    <a href="{{ route('franquia.franquia.index') }}" class="btn btn-primary" title="Show All Franquia">
                                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                    </a>
                                    <a href="{{ route('franquia.franquia.create') }}" class="btn btn-primary" title="Create New Franquia">
                                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </a>
                                    @endrole
                                </div>
                            </div>
                        </div>

                        @include ('franquia.form', ['franquia' => $franquia, ])

                        <div class="card-actionbar">
                            <div class="card-actionbar-row">
                                <a href="{{ route('franquia.franquia.index') }}" type="button" class="btn btn-flat ink-reaction">Voltar</a>
                                <input class="btn btn-primary" type="submit" value="Atualizar">
                            </div>
                        </div>
                    </div><!--end .card -->

                </form>
            </div><!--end .col -->
        </div><!--end .row -->
        <!-- END HORIZONTAL FORM -->

@endsection

@section('javascript')
    <script src="{{ asset('/js/franquia/edit.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/js/mascaras.js')}}" type="text/javascript"></script>
@stop