@extends('layouts.dashboard')

@section('title', 'Categories')

@section('contentBar')
@component('components.dashboard.content-bar', ['title' => 'Create category', 'create_url' => '/create-category', 'search_url' => '/search-category'])
@endcomponent
@endsection

@section('content')
<div class='body-part'>
	<table class='content-table table table-striped'>
		<tr class='table-header'>
			<th>Title</th>
			<th>Description</th>
		</tr>
		@foreach($categories as $category)
		<tr class='table-row'>
			<td>{{$category->title}}</td>
			<td>{{$category->description}}</td>
			<td>
				<form method='GET' action='/edit-category'>
					<input type='hidden' value='{{$category->id}}' name='category-id'>
					<button type='submit'>Edit</button>
				</form>
			</td>
			<td>
				<form method='GET' action='/delete-category'>
					<input type='hidden' value='{{$category->id}}' name='category-id'>
					<button type='submit'>Delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
</div>
@endsection