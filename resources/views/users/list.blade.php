@extends('base')

@section('content')
<section class="container">
	<h1 class="title is-1">Lista de usuarios de HSTW</h1>
	@if(count($usuarios) > 0)
	<section class="x-responsive">
		<table class="table is-narrow is-striped is-fullwidth">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Ocupación</th>
					<th>Email</th>
					<th>Tarjetas</th>
				</tr>
			</thead>
			<tbody>
				@foreach($usuarios as $usuario)
				<tr>
					<td style="vertical-align: middle;">{{$usuario['nombre_completo']}}</td>
					<td style="vertical-align: middle;">{{$usuario['ocupacion']}}</td>
					<td style="vertical-align: middle;">{{$usuario['email']}}</td>
					<td>
						<table class="table is-bordered is-fullwidth">
							<thead>
								<tr>
									<th>Tipo de tarjeta</th>
									<th>Número</th>
									<th>CLABE</th>
								</tr>
							</thead>
							<tbody>
								@foreach($usuario['cards'] as $card)
									<tr>
										<td>{{ $card->tipo == 1 ? 'Crédito' : 'Débito' }} {{ $card->marca == 1 ? 'VISA' : 'MasterCard' }}</td>
										<td>{{$card->numero}}</td>
										<td>{{$card->clave_interbancaria}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</section>
	@else
		<h3 class="title is-3"><i>No hay usuarios registrados.</i></h3>
	@endif
</section>
@endsection