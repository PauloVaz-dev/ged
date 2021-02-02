<!DOCTYPE html>
<html lang="en">
<head>
    <title>GED - GESTÃO ELETRÔNICA DE DOCUMENTO</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GED - GESTÃO ELETRÔNICA DE DOCUMENTOS">
    <link rel="shortcut icon" href="/images/ICON.png" type="image/x-icon"/>

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="css/login.css">

    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <title>E-Primesoft - Soluções em software</title>
</head>
<body>
<div class="login">
    <div class="login__content">
        <div class="login__img">
            <img src="img/img-login.svg" alt="" class="src">
        </div>

        @if(Session::has('success_message'))
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok"></span>
                {!! session('success_message') !!}

                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        @endif
        @if(Session::has('error_message'))
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok"></span>
                {!! session('error_message') !!}

                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
        @endif

        @if(Session::has('errors'))
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="login__forms">

            <form id="login-up"  class="login__create" action="{{ route('login') }}" accept-charset="utf-8" method="POST">
                {{ csrf_field() }}
                <h1 class="login__title">GED - GESTÃO ELETRÔNICA DE DOCUMENTOS</h1>

                <div class="login__box">
                    <i class="bx bx-user login__icon"></i>

                    <input type="text" placeholder="Email" class="login__input" name="email" placeholder="Usuário">
                </div>

                <div class="login__box">
                    <i class="bx bx-lock login__icon"></i>
                    <input type="password" class="login__input" id="password" name="password" placeholder="Senha">
                </div>

                <button class="login__button" type="submit">Login</button>

                <dv class="login__social">
                    <img  src="img/eprime.png" alt="" class="src">
                </dv>

            </form>
        </div>
    </div>

</div>

<!--===== MAIN JS =====-->
<script src="js/login.js"></script>
</body>
</html>
