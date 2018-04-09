<button class="user-context btn btn-default dropdown-toggle" type="button" data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>
	<img class='img-circle user-avatar' src='{{ $pictureUrl }}'><p>{{ $username }}</p>
	<span class="caret"></span>
</button>
<ul class="dropdown-menu">
	<li>
		<form action='/' method='GET'>
			<button type='submit' class='button-link'>Home</button>
		</form>
	</li>
	<li>
        <form action='/logout' method='POST'>
            {{ csrf_field() }}
            <button type='submit' class='button-link'>Logout</button>
        </form>
	</li>
</ul>