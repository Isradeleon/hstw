@extends('base')

@section('content')
<section class="container">
	<div class="columns">
		<div style="text-align: center; padding: 30px;" class="column is-one-third">
			<img style="max-height: 150px;" src="/default/user.png"><br><br>
			<h5 class="title is-5">{{Auth::user()->nombre_completo}}</h5>
			<hr>
			<p>Email: {{Auth::user()->email}}</p>
			<p>Ocupación: {{Auth::user()->ocupacion}}</p>
		</div>
		<div class="column">
			<div class="tabs is-fullwidth is-centered">
				<ul>
					<!-- <li data-section="general" class="is-active">
						<a>
							<span class="icon is-small">
								<i class="fa fa-dashboard"></i> 
							</span>
							<span>
								General
							</span>
						</a>
					</li> -->
					@foreach(Auth::user()->cards as $card)
						@if($loop->first)
						<li class="is-active" data-section="{{$card->numero}}">
						@else
						<li data-section="{{$card->numero}}">
						@endif
							<a>
								<span class="icon is-small">
									<i class="fa {{ $card->tipo == 1 ? 'fa-credit-card' : 'fa-bank' }}"></i> 
								</span>
								<span>	
									{{ $card->tipo == 1 ? 'Crédito' : 'Débito' }}
								</span>
							</a>
						</li>
					@endforeach
				</ul>
			</div>
			<section class="dashboard" style="display: block;">
				<!-- <section id="general">
					general
				</section> -->
				@foreach(Auth::user()->cards as $card)
					@if($loop->first)
					<section id="{{$card->numero}}">
					@else
					<section id="{{$card->numero}}" style="display:none;">
					@endif
						<p class="title is-5">
							<strong>
								<i class="fa {{ $card->marca == 1 ? 'fa-cc-visa' : 'fa-cc-mastercard' }}"></i> {{ $card->tipo == 1 ? 'Crédito' : 'Débito' }} {{ $card->marca == 1 ? 'VISA' : 'MasterCard' }} 
							</strong>
						</p>
						<section class="x-responsive">
							<table class="table ">
								<tbody>
									<tr>
										<td><strong><i class="fa fa-hashtag"></i> Numero</strong></td>
										<td>{{$card->numero}}</td>
									</tr>
									<tr>
										<td><strong>CLABE</strong></td>
										<td>{{$card->clave_interbancaria}}</td>
									</tr>
									<tr>
										<td><strong><i class="fa fa-lock"></i> PIN</strong></td>
										<td>{{$card->pin}}</td>
									</tr>
									<tr>
										<td><strong><i class="fa fa-calendar-check-o"></i> Expedición</strong></td>
										<td>{{$card->expedicion}}</td>
									</tr>
									<tr>
										<td><strong><i class="fa fa-money"></i> Saldo actual</strong></td>
										<td>$ {{$card->saldo}} MXN</td>
									</tr>
								</tbody>
							</table>
						</section>
						<br>
						<p class="title is-5"><i class="fa fa-line-chart"></i> Movimientos</p>
						@if( count($card->moves) > 0)
							<p>Pago sin intereses: ${{$data_payments[$card['numero']]}}</p>
							<p>Pago mínimo: %{{$card->pago_minimo}}</p><br>
							<section class="x-responsive">
								<table class="table is-fullwidth is-bordered">
									<thead>
										<tr>
											<th>Compra</th>
											<th>Costo</th>
											<th>Fecha límite</th>
											<th>Realizado</th>
										</tr>
									</thead>
									<tbody>
										@foreach($card->moves as $move)
										<tr>
											<td>{{$move->producto}}</td>
											<td>{{$move->precio}}</td>
											<td>{{$move->fecha_limite}}</td>
											<td>{{$move->created_at}}</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</section>
						@else
							<p class="title is-6">No hay registro de movimientos.</p>
						@endif
					</section>		
				@endforeach
			</section>
		</div>
	</div>
</section>
@endsection

@if(count(Auth::user()->cards) > 1)
	@section('js')
	<script type="text/javascript">
		$(function(){
			$('.tabs>ul>li').on('click',function(){
				$('li.is-active').removeClass('is-active')
				$(this).addClass('is-active')
				$('.dashboard>section').hide()
				$('#'+$(this).data('section')).slideDown()
			})
		})
	</script>
	@endsection
@endif