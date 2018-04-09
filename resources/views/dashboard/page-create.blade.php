@extends('layouts.dashboard')
@section('title', 'New page')
@section('js')
<script src='js/dynamic-list.js'></script>
<script>
	window.onload = function() {
		initializeComponentNames(document.getElementById('component-choice').value);
	};
</script>
@endsection
@section('content')
<div class='body-part'>
	<h1>Create page</h1>
	@if($info)
	@component('components.dashboard.alert-context')
	{{ $info }}
	@endcomponent
	@endif
	<form class='content-form' method='POST' action='/create-page'>
		{{ csrf_field() }}
		<div class='form-group'>
			<label class='control-label' for='page-title'>Title</label>
			<input type='text' class='form-control' placeholder="Why communism is the best" name='page-title'>
		</div>
		<div class='form-group'>
			<label class='control-label' for='page-description'>Description</label>
			<input type='text' class='form-control' placeholder='29 essays on why communism is the best' name='page-description'>
		</div>
		<div class='form-group'>
			<label class='control-label' for='is-page-displayed'>Display this page in navigation bar?</label>
			<input type='checkbox' name='is-displayed'>
		</div>
		<div class='form-group'>
			<label class='control-label' for='is-page-home'>Make this your homepage?</label>
			<input type='checkbox' name='is-page-home'>
		</div>
		<h2>Components</h2>
		<div class='form-group'>
			<label class='control-label' for='page-content'>Body</label>
			<ul id='component-list'>
				<label class='control-label' for='pages'>Pages</label>
				<ul id='page-list' name='page-list'>
				</ul>
				<label class='control-label' for='categories'>Categories</label>
				<ul id='category-list' name='category-list'>
				</ul>
				<label class='control-label' for='articles'>Articles</label>
				<ul id='article-list' name='article-list'>
				</ul>
			</ul>
		</div>
		<div class='form-group add-component'>
			<label class='control-label' for='component-type'>New component</label>
			<select id='component-choice' onchange='retrieveComponentsId(event)'>
				<option value='page'>Page</option>
				<option value='category'>Category</option>
				<option value='article'>Article</option>
			</select>
			<label class='control-label' for='component-name'>Title</label>
			<select id='component-names'>
			</select>
			<button type='button' onclick="addComponentToList([])">Add component</button>
		</div>	
		<button type='submit'>Create new page</button>
	</form>
</div>
@endsection