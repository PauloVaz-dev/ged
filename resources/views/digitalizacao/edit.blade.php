@extends('layouts.menu')

@section('content')

    <!-- BEGIN HORIZONTAL FORM -->
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="{{ route('digitalizacao.update', $digi->id) }}" accept-charset="UTF-8" id="edit_user_form" name="edit_user_form" class="form-horizontal" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-head style-primary">
                        <header>Editar Documento</header>
                        <div class="tools">
                            <div class="btn-group">
                                <a href="{{ route('digitalizacao.index') }}" class="btn btn-primary" title="Show All Cliente">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </a>
                                <a href="{{ route('users.user.create') }}" class="btn btn-primary" title="Create New Cliente">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    </div>

                    @include ('digitalizacao.form', ['digis' => $digi, 'tipoDocs' => $tipoDocs ])

                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <a href="{{ route('digitalizacao.index') }}" type="button" class="btn btn-flat btn-primary ink-reaction">Voltar</a>
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
    <script src="{{ asset('/js/digitalizacao/edit.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/js/mascaras.js')}}" type="text/javascript"></script>
@stop


@section('toastmessages')

    @if($errors->any())

            @foreach($errors->all() as $error)
                <script>
                    toastr.options.progressBar = true;
                    toastr.options.positionClass = 'toast-top-right';
                    toastr.warning(' {{ $error }} ')
                </script>

            @endforeach

    @endif

    @if(Session::has('success_message'))
        <script>
            toastr.options.progressBar = true;
            toastr.options.positionClass = 'toast-top-right';
            toastr.success('Cadastro realizado com sucesso')
        </script>
    @endif
@stop

