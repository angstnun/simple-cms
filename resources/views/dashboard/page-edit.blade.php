@extends('layouts.dashboard')
@section('title', 'Edit page')
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
	<h1>Edit page</h1>
	@if($info)
		@component('components.alert-context')
			{{ $info->message }}
		@endcomponent
	@endif
	<form class='form edit-page' method='POST' action='/edit-page'>
		{{ csrf_field() }}
		<div class='form-group'>
			<label class='control-label' for='page-title'>Title</label>
			<input type='hidden' value='{{ $parentPage->id }}' name='page-id'>
			<input type='text' class='form-control' value='{{ $parentPage->title }}' name='page-title'>
		</div>
		<div class='form-group'>
			<label class='control-label' for='page-description'>Description</label>
			<input type='text' class='form-control' value='{{ $parentPage->description }}' name='page-description'>
		</div>
		<div class='form-group'>
			<label class='control-label' for='is-page-displayed'>Display this page in navigation bar?</label>
			@if($parentPage->isDisplayed)
			<input type='checkbox' name='isDisplayed' checked>
			@else
			<input type='checkbox' name='isDisplayed'>
			@endif
		</div>
		<div class='form-group'>
			<label class='control-label' for='is-page-index'>Make this your home page?</label>
			@if($isHomepage)
			<input type='checkbox' name='isHomepage' checked>
			@else
			<input type='checkbox' name='isHomepage'>
			@endif
		</div>
		<h2>Components</h2>
		<div class='form-group'>
			<ul id='component-list'>
				<label class='control-label' for='pages'>Pages</label>
				<ul id='page-list'>
				@if(!$components['pages']->isEmpty())
					@for($i=0;$i<count($components['pages']);$i++)
					<li>{{$components['pages'][$i]->title}}<input type='hidden' name='page-list[{{$i}}][id]' value="{{$components['pages'][$i]->id}}"><button onclick='removeListItem(event)'>Delete item</button></li>
					@endfor
				@endif
				</ul>
				<label class='control-label' for='categories'>Categories</label>
				@component('components.dashboard.category-list', ['categories' => $components['categories']])
				@endcomponent
				<label class='control-label' for='articles'>Articles</label>
				<ul id='article-list'>
				@if(!$components['articles']->isEmpty())
					@for($i=0;$i<count($components['articles']);$i++)
					<li>{{$components['articles'][$i]->title}}<input type='hidden' name='article-list[{{$i}}][id]' value="{{$components['articles'][$i]->id}}"><button onclick='removeListItem(event)'>Delete item</button></li>
					@endfor
				@endif
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
		<button type='submit' class='btn btn-primary'>Edit changes</button>
	</form>
</div>
@endsection