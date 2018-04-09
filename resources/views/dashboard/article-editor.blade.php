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
	<h1>Edit article</h1>
	@if($info)
		@component('components.alert-context')
			{{ $info->message }}
		@endcomponent
	@endif
	<form class='content-form' method='POST' action='/edit-article'>
		{{ csrf_field() }}
		<input type='hidden' value='{{$article->id}}' name='article-id'>
		<div class='form-group'>
			<label for='article-title'>Title</label>
			<input type="text" class='form-control' name="article-title" value='{{$article->title}}'>
		</div>
		<div class='form-group'>
			<label for='article-description'>Description</label>
			<input type='text' class='form-control' name='article-description' value='{{$article->description}}'>
		</div>
		@if(isset($article->category_id))
		<div class='form-group'>
			<label for='article-category'>Category</label>
			<p>{{ $article->category_title }}</p>
		</div>
		@endif
		<br/>
		<div class='form-group'>
			<textarea name='textarea'>{{$article->content}}</textarea>
		</div>
		<button type='submit' class='btn btn-primary'>Submit</button>
	</form>
</div>
@endsection