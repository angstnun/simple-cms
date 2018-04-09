@extends('layouts.dashboard')

@section('title', 'localhost.acid')

@section('js')
@component('components.dashboard.text-editor')
@slot('image_list')
{!! $image_list !!}
@endslot
@endcomponent
@endsection

@section('content')
<div class='body-part'>
	<h1>Create new article</h1>
	@if($info)
		@component('components.alert-context')
			{{ $info->message }}
		@endcomponent
	@endif
	<form class='content-form' method='POST' action='/create-article'>
		{{ csrf_field() }}
		<div class='form-group'>
			<label for='article-title'>Title</label>
			<input type="text" class='form-control' name="article-title" value='Your title here...'>
		</div>
		<div class='form-group'>
			<label for='article-description'>Description</label>
			<input type='text' class='form-control' name='article-description' value='Description goes here...'>
		</div>
		<br/>
		<div class='form-group'>
			<textarea name='textarea'>Write here</textarea>
		</div>
		<button type='submit' class='btn btn-primary'>Submit</button>
	</form>
</div>
@endsection