<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>HSTW</title>
	<link rel="stylesheet" type="text/css" href="/css/bulma.css">
	<link rel="stylesheet" type="text/css" href="/css/icons/css/font-awesome.min.css">
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
        /**{
            border-radius: 0 !important;
        }*/
	</style>
	@yield('css')
</head>
<body>
	<nav class="navbar is-fixed">
        <div class="navbar-brand">
            <a href="/" class="navbar-item">
                <span class="title is-6">HSTW</span>
            </a>
            <div class="button navbar-burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="navbar-menu">
            <div class="navbar-start">
                @if(Auth::check() and Auth::user()->tipo == 1)
            	   <a href="/register" class="navbar-item">Registrar</a>
                @endif
            </div>
            <div class="navbar-end">
                @if(Auth::check())
                    <!-- <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            <span class="icon">
                                <img src="/default/user.png">
                            </span>
                        </a>
                        <div class="navbar-dropdown is-right">
                            <hr class="navbar-divider">
                            <a class="navbar-item">
                                Components
                            </a>
                            <a href="/logout" class="navbar-item">Logout</a>
                        </div>
                    </div> -->
                    <a href="/logout" class="navbar-item"><i class="fa fa-sign-out"></i> Salir</a>
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