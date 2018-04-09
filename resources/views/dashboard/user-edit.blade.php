@extends('layouts.dashboard')

@section('title', 'localhost.acid')

@section('content')
<div class='body-part'>
<h1>User preferences</h1>
@if($info)
	@component('components.dashboard.alert-context')
		{{ $info }}
	@endcomponent
@endif
	<form class='content-form' method='POST' action='/edit-user'>
		{{ csrf_field() }}
		<input type='hidden' value='{{$user->id}}' name='user-id'>
		<div class='form-group'>
			<label for='user-picture-url'>Profile picture</label>
		</div>
		<br/>
		<button type='submit' class='btn btn-primary'>Submit</button>
	</form>
</div>
@endsection