@extends('base')

@section('content')
<section class="container">
	<h1 class="title is-1">Registrar usuario</h1>
	<form autocomplete="off" action="/register" method="post">
		{{csrf_field()}}
		<div class="columns">
			<div class="column is-one-third">
				<div class="field">
					<label for="nombre_completo" class="label">Nombre completo</label>
					<input autofocus value="{{ old('nombre_completo') }}" name="nombre_completo" type="text" class="input">
				</div>
				@if($errors->has('nombre_completo'))
					<article class="message is-small is-danger">
						<div class="message-body">
							{{ $errors->first('nombre_completo') }}
						</div>
					</article>
				@endif

				<div class="field">
					<label for="ocupacion" class="label">Ocupacion</label>
					<input value="{{ old('ocupacion') }}" name="ocupacion" type="text" class="input">
				</div>
				@if($errors->has('ocupacion'))
					<article class="message is-small is-danger">
						<div class="message-body">
							{{ $errors->first('ocupacion') }}
						</div>
					</article>
				@endif

				<div class="field">
					<label for="email" class="label">Email</label>
					<input value="{{ old('email') }}" name="email" type="text" class="input">
				</div>
				@if($errors->has('email'))
					<article class="message is-small is-danger">
						<div class="message-body">
							{{ $errors->first('email') }}
						</div>
					</article>
				@endif

			</div>
			<div class="column is-one-third">
				<div class="field">
					<label for="password" class="label">Password</label>
					<input value="{{ old('password') }}" name="password" type="password" class="input">
				</div>
				@if($errors->has('password'))
					<article class="message is-small is-danger">
						<div class="message-body">
							{{ $errors->first('password') }}
						</div>
					</article>
				@endif

				<div class="field">
					<label for="password_confirmation" class="label">Confirme password</label>
					<input value="{{ old('password_confirmation') }}" name="password_confirmation" type="password" class="input">
				</div>
				@if($errors->has('password_confirmation'))
					<article class="message is-small is-danger">
						<div class="message-body">
							{{ $errors->first('password_confirmation') }}
						</div>
					</article>
				@endif

			</div>
			<div class="column is-one-third">
				<div class="field">
					<label class="label" for="marca_tarjeta">Tipo</label>
					<div class="select">
						<select name="marca_tarjeta">
							<option value="1">VISA</option>
							<option value="2">Master Card</option>
						</select>
					</div>
				</div>

				<div class="field">
					<label class="label" for="tipo_tarjeta">Tarjetas</label>
					<div class="select">
						<select name="tipo_tarjeta">
							<option value="1">Tarjeta de crédito</option>
							<option value="2">Tarjeta de débito</option>
							<option value="3">Débito y Crédito</option>
						</select>
					</div>
				</div>

				<div style="display: none;" id="saldo_field" class="field">
					<label class="label" for="monto">Saldo</label>
					<input class="input" type="number" name="monto" value="16000">
				</div>

				<button class="button is-success is-fullwidth">Registrar</button>
			</div>
		</div>
	</form>
</section>
@endsection

@section('js')
<script type="text/javascript">
$(function(){
	$('select[name="tipo_tarjeta"]').on('change',function(){
		console.log($(this).val())
		if ($(this).val() == 1)
			$('#saldo_field').hide()
		else
			$('#saldo_field').slideDown()
	})
})
</script>
@endsection