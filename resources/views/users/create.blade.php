@extends('layouts.menu')

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
            <div>{{ $error_message }}</div>
        @endforeach
    </div>
@endif

@section('content')

    <!-- BEGIN HORIZONTAL FORM -->
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="{{ route('users.user.store') }}" accept-charset="UTF-8" id="create_user_form" name="create_user_form" class="form-horizontal">
                <div class="card">
                    <div class="card-head style-primary">
                        <header>Novo usuário</header>
                        <div class="tools">
                            <div class="btn-group">
                                <a href="{{ route('users.user.index') }}" class="btn btn-primary" title="Todds">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    @include ('users.form', [ 'router' => null,   ])

                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <a href="{{ route('users.user.index') }}" type="button" class="btn btn-flat btn-primary ink-reaction">Voltar</a>
                            <button type="submit" class="btn btn-flat btn-primary ink-reaction">Salvar</button>
                        </div>
                    </div>
                </div><!--end .card -->

            </form>
        </div><!--end .col -->
    </div><!--end .row -->
    <!-- END HORIZONTAL FORM -->

@endsection


