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
									<i class="fa {{ $card->tipo == 1 ? 'fa-credit-card' : 'fa-credit-card-alt' }}"></i> 
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
								<i class="fa {{ $card->marca == 1 ? 'fa-cc-visa' : 'fa-cc-mastercard' }}"></i> {{ $card->marca == 1 ? 'VISA' : 'MasterCard' }} 
							</strong>
						</p>
						<p><strong><i class="fa fa-hashtag"></i> Numero:</strong> {{$card->numero}}</p>
						<p><strong>CLABE:</strong> {{$card->clave_interbancaria}}</p>
					</section>		
				@endforeach
			</section>
		</div>
	</div>
</section>
@endsection

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