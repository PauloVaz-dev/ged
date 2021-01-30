<!DOCTYPE html>
<html lang="en">
<head>
	<title>GED - GESTÃO ELETRÔNICA DE DOCUMENTO</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="">
	<meta name="description" content="GED - GESTÃO ELETRÔNICA DE DOCUMENTO">
	<link rel="shortcut icon" href="/images/icone-2-100x100.png" type="image/x-icon"/>

	<!-- BEGIN STYLESHEETS -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
	<link href="{{ asset('/assets/css/theme-default/bootstrap.css')}}" rel="stylesheet">
	<link href="{{ asset('/assets/css/theme-default/materialadmin.css')}}" rel="stylesheet">
	<link href="{{ asset('/assets/css/theme-default/font-awesome.min.css')}}" rel="stylesheet">

	<link href="{{ asset('/assets/css/theme-default/material-design-iconic-font.min.css')}}" rel="stylesheet">
	<link href="{{ asset('/assets/css/theme-default/libs/DataTables/jquery.dataTables.css')}}" rel="stylesheet">
	<link href="{{ asset('/assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css')}}" rel="stylesheet">
	<link href="{{ asset('/assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css')}}" rel="stylesheet">
	<link href="{{ asset('/assets/css/theme-default/libs/bootstrap-multiselect/bootstrap-multiselect.css')}}" rel="stylesheet">

	<link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' rel='stylesheet' type='text/css'>
	{{--<link href="{{ asset('/assets/css/theme-default/libs/select2/select2.css')}}" rel="stylesheet">--}}


	<link href="{{ asset('/assets/css/theme-default/libs/bootstrap-datepicker/datepicker3.css')}}" rel="stylesheet">

	<link href="{{ asset('/assets/css/theme-default/libs/sweetalert/sweetalert.css')}}" rel="stylesheet">
	<link href="{{ asset('/assets/css/theme-default/libs/toastr/toastr.css')}}" rel="stylesheet">

	<link href="{{ asset('/assets/css/theme-default/libs/wizard/wizard.css')}}" rel="stylesheet">

	<link href="{{ asset('/css/bootstrap_custon.css')}}" rel="stylesheet">

	<!-- END STYLESHEETS -->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>

	<script src="{{ asset('/assets/js/libs/utils/html5shiv.js')}}" type="text/javascript"></script>
	<script src="{{ asset('/assets/js/libs/utils/respond.min.js')}}" type="text/javascript"></script>

	<![endif]-->

	@yield('css')
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">
@if(Auth::check())

	<!-- BEGIN HEADER-->
	<header id="header" >
		<div class="headerbar">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="headerbar-left">
				<ul class="header-nav header-nav-options">
					<li class="header-nav-brand" >
						<div class="brand-holder">
							<a href="../../html/dashboards/dashboard.html">
								<span class="text-lg color2 text-bold text-primary">E-PRIMESOFT</span>
							</a>
						</div>
					</li>
					<li>
						<a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</li>
				</ul>
			</div>

			<!-- DropDown Menu superior direito -->
			<div class="headerbar-right">
				<ul  class="header-nav header-nav-profile">
					<li id="" class=" hidden-sm">
						<a href="javascript:void(0);" class="" data-toggle="dropdown">

							@if(auth()->user()->can('view participacao'))
								<i class="">{{ "PREFEITURA" }}</i>
							@endif


						</a>
					</li><!--end .dropdown -->


					<li id="alert-solar" class="dropdown hidden-sm">
						<a href="javascript:void(0);" class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
							<i class="fa fa-bell"></i>
							<sup id="lert-count" class="badge style-danger"></sup>
						</a>
						<ul class="dropdown-menu dropdown-menu-solar animation-expand">
							<li><a href="#">Todoas as notificações <span class="pull-right"><i class="fa fa-arrow-right"></i></span></a></li>
						</ul><!--end .dropdown-menu -->
					</li><!--end .dropdown -->
					<li class="dropdown">
						<a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
							{{--<img src="" alt="" />--}}
							<span class="profile-info">
									{{ Auth::user()->name }}
								@role('super-admin')
                                        <small> - Super Adm</small>
								@else
									<small> - Integrador</small>
									@endrole

							</span>
						</a>
						<ul class="dropdown-menu animation-dock">
							<li class="dropdown-header">Config</li>
							<li><a href="#">Meus Dados</a></li>
							<li class="divider"></li>
							<li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off text-danger"></i> Sair</a></li>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</ul><!--end .dropdown-menu -->
					</li><!--end .dropdown -->
				</ul><!--end .header-nav-profile -->

			</div><!--end #header-navbar-collapse -->
		</div>
	</header>
	<!-- END HEADER-->
@endif

<!-- BEGIN BASE-->
<div id="base">

	<!-- BEGIN OFFCANVAS LEFT -->
	<div class="offcanvas">
	</div><!--end .offcanvas-->
	<!-- END OFFCANVAS LEFT -->

	<!-- BEGIN CONTENT-->
	<div id="content">

		<!-- BEGIN BLANK SECTION -->
		<section>
			<div class="section-body contain-lg">

				@yield('content')


			</div><!--end .section-body -->
		</section>
		<!-- BEGIN BLANK SECTION -->


	</div><!--end #content-->
	<!-- END CONTENT -->
@if(Auth::check())
	<!-- BEGIN MENUBAR-->
		<div id="menubar" class="menubar-inverse ">
			<div class="menubar-fixed-panel">
				<div>
					<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
						<i class="fa fa-bars"></i>
					</a>
				</div>
			</div>



			<div class="menubar-scroll-panel">



				<!-- BEGIN MAIN MENU -->
				<ul id="main-menu" class="gui-controls">




					<!-- BEGIN DASHBOARD -->
					<!-- END DASHBOARD -->


					<!-- BEGIN PAGES -->
					<li class="gui-folder">
						<a>
							<div class="gui-icon"><i class="md md-computer"></i></div>
							<span class="title">Controle</span>
						</a>
						<!--start submenu -->

						<ul>
							<li><a href="{{ route('digitalizacao.index') }}" class="active"><span class="title">Documentos</span></a></li>



							<li class="gui-folder">
								<a href="javascript:void(0);">
									<span class="title">Criar Tipos de Despesas</span>
								</a>
								<!--start submenu -->
								<ul>
									<li><a href="/digitalizacao/create/despesa" class="active"><span class="title">Despesas</span></a></li>
									<li><a href="/digitalizacao/create/licitacao" class="active"><span class="title">Licitação</span></a></li>
									<li><a href="/digitalizacao/create/folha" class="active"><span class="title">Folha</span></a></li>
									<li><a href="/digitalizacao/create/lei" class="active"><span class="title">Lei</span></a></li>
									<li><a href="/digitalizacao/create/outros" class="active"><span class="title">Outros</span></a></li>

								</ul><!--end /submenu -->

							</li><!--end /menu-li -->

							<li class="gui-folder">
								<a href="javascript:void(0);">
									<span class="title">Cadastro</span>
								</a>
								<!--start submenu -->
								<ul>
									<li><a href="{{ route('franquia.franquia.index') }}" class="active"><span class="title">Instituição</span></a></li>
									<li><a href="{{ route('secretaria.index') }}" class="active"><span class="title">Secretarias</span></a></li>
									<li><a href="{{ route('users.user.index') }}" class="active"><span class="title">Usuários</span></a></li>
                                    <li><a href="{{ route('modalidade.index') }}" class="active"><span class="title">Modalidade</span></a></li>

								</ul><!--end /submenu -->

							</li><!--end /menu-li -->



						</ul><!--end /submenu -->


					</li><!--end /menu-li -->
					<!-- END FORMS -->


				</ul><!--end .main-menu -->
				<!-- END MAIN MENU -->

			</div><!--end .menubar-scroll-panel-->

		</div><!--end #menubar-->
		<!-- END MENUBAR -->
	@endif

</div><!--end #base-->
<!-- END BASE -->

<!-- BEGIN JAVASCRIPT -->


<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
{{--<script src="{{ asset('/assets/js/libs/jquery/jquery-1.11.2.min.js')}}" type="text/javascript"></script>--}}
<script src="{{ asset('/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/libs/bootstrap/bootstrap.min.js')}}" type="text/javascript"></script>


<script src="{{ asset('/assets/js/libs/spin.js/spin.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/libs/autosize/jquery.autosize.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/core/source/App.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/core/source/AppNavigation.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/core/source/AppOffcanvas.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/core/source/AppCard.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/core/source/AppForm.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/core/source/AppNavSearch.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/core/source/AppVendor.js')}}" type="text/javascript"></script>


<script src="{{ asset('/assets/js/libs/toastr/toastr.js')}}" type="text/javascript"></script>


<!-- Teste -->
<script src="{{ asset('/assets/js/libs/DataTables/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js')}}" type="text/javascript"></script>
<!-- FIM Datatables -->

<script src="{{ asset('/assets/js/libs/wizard/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('/assets/js/libs/bootstrap-multiselect/bootstrap-multiselect.js')}}" type="text/javascript"></script>


<script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js'></script>
{{--<script src="{{ asset('/assets/js/libs/select2/select2.js')}}" type="text/javascript"></script>--}}

<script src="{{ asset('/assets/js/libs/jquery-knob/jquery.knob.min.js')}}" type="text/javascript"></script>


<script src="{{ asset('/assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js')}}" type="text/javascript"></script>

<script src="{{ asset('/assets/js/libs/sweetalert/sweetalert.js')}}" type="text/javascript"></script>
<script src="{{ asset('/assets/js/libs/jquery-mask-plugin/dist/jquery.mask.js')}}" type="text/javascript"></script>
<script src="{{ asset('/js/ajaxError.js')}}" type="text/javascript"></script>



<!-- END JAVASCRIPT -->
@yield('javascript')
</body>
</html>
