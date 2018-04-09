@extends('layouts.dashboard')

@section('title', 'Pages')

@section('contentBar')
@component('components.dashboard.content-bar', ['title' => 'Create page', 'create_url' => '/create-page', 'search_url' => '/search-page'])
@endcomponent
@endsection

@section('content')
<div class='body-part'>
	<table class='content-table table table-striped'>
		<tr class='table-header'>
			<th>Title</th>
			<th>Description</th>
		</tr>
		@foreach($pages as $page)
		<tr class='table-row'>
			<td>{{$page->title}}</td>
			<td>{{$page->description}}</td>
			<td>
				<form method='GET' action='edit-page'>
					<input type='hidden' value='{{$page->id}}' name='page-id'>
					<button type='submit'>Edit</button>
				</form>
			</td>
			<td>
				<form method='GET' action='delete-page'>
					<input type='hidden' value='{{$page->id}}' name='page-id'>
					<button type='submit'>Delete</button>
				</form>
			</td>
		</tr>
		@endforeach
	</table>
	<div class='pagination-control'>
		{{ $pages->links() }}
	</div>
</div>
@endsection