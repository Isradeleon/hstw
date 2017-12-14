<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>HSTW</title>
	<link rel="stylesheet" type="text/css" href="/css/bulma.css">
	<link rel="stylesheet" type="text/css" href="/css/icons/css/font-awesome.min.css">
    <link rel="icon" href="/default/icon.png">
	<style type="text/css">
		.is-fixed{
            position: fixed !important;
            width: 100% !important;
            top:0 !important;
            background-color: white;
            z-index: 1;
            border-bottom: 1px solid #eee !important;
        }
        div.navbar-burger{
            border:none !important;
        }
        section.main{
            padding-top:70px;
        }
        *{
            border-radius: 0 !important;
        }
        .column{
            padding: 20px;
        }
        .select, .select>select{
            width: 100%;
        }
        .navbar-item{
            text-align: center;
        }
        .navbar-brand>a:hover, .navbar-brand>a{
            background-color: white;
        }
        .x-responsive{
            overflow-x: auto;
        }
	</style>
	@yield('css')
</head>
<body>
	<nav class="navbar is-fixed">
        <div class="navbar-brand">
            <a href="/" class="navbar-item">
                <img src="/default/logo.png">
                <!-- <span class="title is-6">HSTW</span> -->
            </a>
            @if(Auth::check())
                <div class="button navbar-burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            @endif
        </div>
        <div class="navbar-menu">
            <div class="navbar-start">
                @if(Auth::check() and Auth::user()->tipo == 1)
                <a href="/register" class="navbar-item">
                    <span class="icon"><i class="fa fa-users"></i></span> Registrar usuarios
                </a>
                @endif
            </div>
            <div class="navbar-end">
                @if(Auth::check())
                    <a href="/logout" class="navbar-item">
                        <span class="icon"><i class="fa fa-sign-out"></i></span> Salir
                    </a>
                @endif
            </div>
        </div>
    </nav>
    <section class="main">
		@yield('content')
    </section>
	<script type="text/javascript" src="/js/jquery.min.js"></script>
	<script type="text/javascript">
	$(function(){
		$('.button.navbar-burger').on('click',function(){
			$(this).toggleClass('is-active')
			$('div.navbar-menu').toggleClass('is-active')
		})
	})
	</script>
	@yield('js')
</body>
</html>