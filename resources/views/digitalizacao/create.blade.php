@extends('layouts.menu')



@section('content')

   {{-- @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times&times;</span>
            </button>

        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times&times;</a>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif--}}

    <!-- BEGIN HORIZONTAL FORM -->
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="{{ route('digitalizacao.store') }}" accept-charset="UTF-8" id="create_user_form" name="create_user_form" class="form-horizontal" enctype="multipart/form-data">
                <div class="card">
                    <div class="card-head style-digi">
                        <header>Novo documento</header>
                        <div class="tools">
                            <div class="btn-group">
                                <a href="{{ route('digitalizacao.index') }}" class="btn btn-primary" title="Todds">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    @include ('digitalizacao.formCreate', [ 'router' => null, 'tipoDocs' => $tipoDocs   ])

                    <div class="card-actionbar">
                        <div class="card-actionbar-row">
                            <a href="{{ route('digitalizacao.index') }}" type="button" class="btn btn-flat ink-reaction">Voltar</a>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </div><!--end .card -->

            </form>
        </div><!--end .col -->
    </div><!--end .row -->
    <!-- END HORIZONTAL FORM -->

@endsection

@section('javascript')
    <script src="{{ asset('/js/digitalizacao/create.js')}}" type="text/javascript"></script>
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
            toastr.success(" {!! session('success_message') !!} ")
        </script>
    @endif
@stop

