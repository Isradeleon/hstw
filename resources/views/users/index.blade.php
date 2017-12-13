@extends('base')

@section('content')
<section class="container">
	<div class="columns">
		<div style="text-align: center; padding: 30px;" class="column is-one-third">
			<img style="max-height: 150px;" src="/default/user.png"><br>
			<hr>
			<h5 class="title is-5">{{Auth::user()->nombre_completo}}</h5>
			<p>Email: {{Auth::user()->email}}</p>
			<p>Ocupación: {{Auth::user()->ocupacion}}</p>
		</div>
		<div class="column">
			<div class="tabs is-fullwidth is-centered">
				<ul>
					<li data-section="general" class="is-active">
						<a>
							<span class="icon is-small">
								<i class="fa fa-dashboard"></i> 
							</span>
							<span>
								General
							</span>
						</a>
					</li>
					@foreach(Auth::user()->cards as $card)
						<li data-section="{{$card->numero}}">
							<a>
								<span class="icon is-small">
									<i class="fa fa-credit-card-alt"></i> 
								</span>
								<span>	
									{{ $card->tipo == 1 ? 'Crédito' : 'Débito' }} {{ $card->marca == 1 ? 'VISA' : 'MasterCard' }}
								</span>
							</a>
						</li>
					@endforeach
				</ul>
			</div>
			<section class="dashboard" style="display: block;">
				<section id="general">
					general
				</section>
				@foreach(Auth::user()->cards as $card)
					<section id="{{$card->numero}}" style="display:none;" id="">
						card
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