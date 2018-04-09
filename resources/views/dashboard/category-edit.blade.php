@extends('layouts.dashboard')
@section('title', 'Edit category')
@section('js')
<script src='js/color-hex.js'></script>
<script src='js/dynamic-list.js'></script>
<script>
	window.onload = function() {
		displayColor('{{ $category->color }}');
		initializeComponentNames('article');
	}
</script>
@endsection
@section('content')
<div class='body-part'>
	<h1>Edit category</h1>
	@if($info)
		@component('components.alert-context')
			{{ $info->message }}
		@endcomponent
	@endif
	<form class='content-form' method='POST' action='/edit-category'>
		{{ csrf_field() }}
		<div class='form-group'>
			<label class='control-label' for='category-title'>Title</label>
			<input type='hidden' value='{{ $category->id }}' name='category-id'>
			<input type='text' class='form-control' value='{{ $category->title }}' name='category-title'>
		</div>
		<div class='form-group'>
			<label class='control-label' for='category-description'>Description</label>
			<input type='text' class='form-control' value='{{ $category->description }}'
			name='category-description'>
		</div>
		<div class='form-group'>
			<label class='control-label' for='category-color'>Label color</label>
			@component('components.dashboard.color-hex')
			@endcomponent
		</div>
		<h2>Components</h2>
		<div class='form-group'>
			<label class='control-label' for='category-content'>Content</label>
			<ul id='component-list'>
				<label class='control-label' for='category-articles'>Articles</label>
				<ul id='article-list'>
				@if(!$components['articles']->isEmpty())
					@foreach($components['articles'] as $article)
					<li>{{$article->title}}<input type='hidden' name='article-list[][id]' value='{{$article->id}}'><button onclick='removeListItem(event)'>Delete item</button></li>
					@endforeach
				@endif
				</ul>
			</ul>
		</div>
		<div class='form-group'>
			<label class='control-label' for='component-name'>Title</label>
			<select id='component-names'></select>
			<button type='button' onclick="addComponentToList(['article'])">Add article to list</button>
		</div>
		<button type='submit' class='btn btn-primary'>Submit</button>
	</form>
</div>
@endsection