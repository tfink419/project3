@extends('master')
<!--Extension to the master template-->


<!--Corresponds to the content section in master.blade.php-->
@section('content')

<div class="row" align="center">
	<div class="span4 offset1">
		<div class="well">
			<legend>Please Register</legend>
			<!--Sets the url where we will post form data-->
			{{ Form::open(array('url' => 'register')) }}
			@if($errors->any())
			<div class="alert alert-dismissable alert-danger">
				<!--<a href="#" class="close" data-dismiss="alert">&times;</a>-->
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				{{ implode('', $errors->all('<li class="error">:message</li>')) }}
			</div>
			@endif

			{{ Form:: text('username', '', array('placeholder' => 'Username')) }} </br> </br>
			{{ Form:: password('password',  array('placeholder' => 'Password')) }} </br> </br>
			{{ Form::label('admin', 'Are you an Admin?')						}}
			{{ Form::checkbox('isAdmin', 1, false) }} </br> </br>
			{{ Form:: submit('Register',  array('class' => 'btn btn-success')) }} 
			{{ HTML:: link('/', 'Cancel',  array('class' => 'btn btn-danger')) }} 
			{{ Form:: close() }}

		</div>
	</div>
</div>



@stop