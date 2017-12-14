@extends('base')

@section('content')
<section class="columns">
	<div class="column is-4 is-offset-4">
		<section class="login-form">
			<h4 class="title is-4 has-text-centered">
				<img style="width: auto; max-height: 70px;" src="/default/logo.png">
			</h4>
			<h4 class="title is-4">Inicio de sesión</h4>
			<hr>
			<form id="form_login" method="post" action="/login">
				{{ csrf_field() }}
				<div class="field">
					<label for="email" class="label">Email</label>
					<input value="{{ old('email') }}" autofocus name="email" type="text" class="input">
				</div>
					@if($errors->has('email'))
						<article class="message is-small is-danger">
							<div class="message-body">
								{{ $errors->first('email') }}
							</div>
						</article>
					@endif
				<div class="field">
					<label for="password" class="label">Password</label>
					<input name="password" type="password" class="input">
				</div>
					@if($errors->has('password'))
						<article class="message is-small is-danger">
							<div class="message-body">
								{{ $errors->first('password') }}
							</div>
						</article>
					@endif

					@if($errors->has('loginFailed'))
						<article class="message is-small is-danger">
							<div class="message-body">
								{{ $errors->first('loginFailed') }}
							</div>
						</article>
					@endif
				<button id="btn_enviar" class="button is-success is-fullwidth">Enviar</button>
			</form>
		</section>
	</div>
</section>
@endsection