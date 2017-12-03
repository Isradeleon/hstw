@extends('base')

@section('content')
<section class="container">
	<h1 class="title is-1">Lista de usuarios de HSTW</h1>
	@if(count($usuarios) > 0)
		<table class="table">
			<thead>
				<tr>
					<th>Nombre</th>
				</tr>
			</thead>
			<tbody>
				@foreach($usuarios as $usuario)
				<tr>
					<td>{{$usuario['nombre_completo']}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	@else
		<h3 class="title is-3"><i>No hay usuarios registrados.</i></h3>
	@endif
</section>
@endsection