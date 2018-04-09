@extends('layouts.dashboard')

@section('title', 'localhost.acid')

@section('content')
<div class='body-part'>
	<h1>Settings</h1>
	@if($info)
		@component('components.dashboard.alert-context')
			{!! $info !!}
		@endcomponent
	@endif
	<form class='content-form' method='POST' action='/edit-settings'>
		{{ csrf_field() }}
		<input type='hidden' value='{{$settings->id}}' name='settings-id'>
		<div class='form-group'>
			<label for='website-logo'>Logo</label>
			<input type="text" class='form-control' name="logo-url" value='{{$settings->logo}}'>
		</div>
		<div class='form-group'>
			<label for='contact-email-address'>Contact email</label>
			<input type='text' class='form-control' name='contact-email-address' value='{{$settings->email}}'>
		</div>
		<div class='form-group'>
			<label for='facebook-url'>Facebook name</label>
			<input type='text' class='form-control' name='fb-url' value='{{$settings->facebook}}'>
			<label for='disqus-url'>Disqus url</label>
			<input type='text' class='form-control' name='disqus-url' value='{{$settings->disqus}}'>
			<label for='twitter-url'>Twitter handle</label>
			<input type='text' class='form-control' name='twitter-url' value='{{$settings->twitter}}'>
			<label for='analytics-id'>Analytics id</label>
			<input type='text' class='form-control' name='analytics-id' value='{{$settings->analytics_id}}'>
		</div>
		<br/>
		<button type='submit' class='btn btn-primary'>Submit</button>
	</form>
</div>
@endsection