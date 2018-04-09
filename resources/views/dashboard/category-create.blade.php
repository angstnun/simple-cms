@extends('layouts.dashboard')
@section('title', 'New category')
@section('js')
<script src='js/color-hex.js'></script>
<script src='js/dynamic-list.js'></script>
<script>
	window.onload = function() {
		initializeComponentNames('article');
	};
</script>
@endsection
@section('content')
<div class='body-part'>
	<h1>Create category</h1>
	@if($info)
	@component('components.dashboard.alert-context')
	{{ $info }}
	@endcomponent
	@endif
	<form class='content-form' method='POST' action='/create-category'>
		{{ csrf_field() }}
		<div class='form-group'>
			<label class='control-label' for='category-title'>Title</label>
			<input type='text' class='form-control' placeholder="Anarchism" name='category-title'>
		</div>
		<div class='form-group'>
			<label class='control-label' form='category-description'>Description</label>
			<input type='text' class='form-control' placeholder='29 essays on why anarchism is the best' name='category-description'>
		</div>
		<div class='form-group color-picker-container'>
			<label class='control-label' for='category-color'>Label color</label>
			@component('components.dashboard.color-hex')
			@endcomponent
		</div>
		<div class='form-group'>
			<label class='control-label' for='category-articles'>Articles</label>
			<ul id='article-list' name='article-list'>
			</ul>
		</div>
		<div class='form-group'>
			<label class='control-label' for='component-name'>Title</label>
			<select id='component-names'>
			</select>
			<button type='button' onclick="addComponentToList(['article'])">Add article to list</button>
		</div>
		<button type='submit' class='btn btn-primary'>Submit</button>
	</form>
</div>
@endsection