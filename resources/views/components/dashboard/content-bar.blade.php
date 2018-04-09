<div class='body-part'>
	<div class='content-bar'>
		<ul class='nav nav-pills'>
			<li role='presentation' class='active'><a href='{{$create_url}}'>{{$title}}</a></li>
		</ul>
		<form class="navbar-form" method='GET' action='{{$search_url}}'>
			{{ csrf_field() }}
			<input type="text" class="form-control" name="search-text" placeholder="Search">
			<button type="submit" class="btn btn-default">Search</button>
		</form>
	</div>
</div>