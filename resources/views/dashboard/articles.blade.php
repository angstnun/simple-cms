@extends('layouts.dashboard')

@section('title', 'Articles')

@section('contentBar')
@component('components.dashboard.content-bar', ['title' => 'Create article', 'create_url' => '/create-article', 'search_url' => '/search-article'])
@endcomponent
@endsection

@section('content')
<div class='body-part'>
	<table class='content-table table table-striped'>
		<tr class='table-header'>
			<th>Category</th>
			<th>Title</th>
			<th>Description</th>
		</tr>
		@foreach($articles as $article)
		<tr class='table-row'>
			<td>{{$article->category_title}}</td>
			<td>{{$article->title}}</td>
			<td>{{$article->description}}</td>
			<td>
				<form action='/edit-article' method='GET'>
					<input type='hidden' value='{{$article->id}}' name='article-id'>
					<button type='submit'>Edit</button>
				</form>
			</td>
			<td>
				<form action='/delete-article' method='GET'>
					<input type='hidden' value='{{$article->id}}' name='article-id'>
					<button type='submit'>Delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
	<div class='pagination-control'>
		{{ $articles->links() }}
	</div>
</div>
@endsection