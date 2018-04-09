<div class='search-bar readable-bg'>
	<p>Search this site:</p>
	<form class='search-bar-form' method='GET' action='{{$url}}'>
		{{ csrf_field() }}
		<input type="text" class="form-control" name="search-text" placeholder="Search">
		<button type="submit" class="btn btn-default">Search</button>
	</form>
</div>