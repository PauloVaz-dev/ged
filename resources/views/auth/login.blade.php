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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <title>E-Primesoft - Soluções em software</title>
</head>
<body>
<div class="login">
    <div class="login__content">
        <div class="login__img">

            <img src="img/img-login.svg" alt="" class="src">

        </div>

        <div class="login__forms">

            <form id="login-up"  class="login__create" action="{{ route('login') }}" accept-charset="utf-8" method="POST">
                {{ csrf_field() }}
                <dv class="login__prefeitura">
                    <img  src="storage/adm/0210/115052202102106023c89c6510a.jpeg" alt="" class="src">
                </dv>


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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>
<script src="js/login.js"></script>

@if(Session::has('errors'))
    <div class="alert alert-danger">

        <script>
            toastError()
        </script>

    </div>
@endif

</body>
</html>
