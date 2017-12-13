@extends('base')

@section('content')
<section class="container">
	<div style="text-align: center;"><br>
		<h2 class="title is-2 is-centered"><i class="fa fa-question-circle-o"></i> Pregunta de seguridad</h2>
		<h3 class="title is-3"><i>{{$question}}</i></h3>
		<form id="question" action="/question" method="post">
			{{csrf_field()}}
			<input type="hidden" name="answer">
			<input type="hidden" name="pregunta" value="{{$question}}">
			<button data-action="1" class="button is-success">Es mi pregunta</button>
			<button data-action="0" class="button is-danger">No es mi pregunta</button>
		</form>
	</div>
</section>
@endsection

@section('js')
<script type="text/javascript">
$(function(){
	$('.button').on('click',function(e){
		e.preventDefault()
		e.stopPropagation()
		$('input[name="answer"]').val($(this).data('action'))
		$('#question').submit()
	})
})
</script>
@endsection