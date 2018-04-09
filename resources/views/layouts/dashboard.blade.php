<!DOCTYPE html>
<html>
	<head>
		<title>Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/app.css">
        <link rel='stylesheet' href='css/dashboard.css'>
        @yield('css')
        <script src='js/app.js'></script>
        <script src='js/home.js'></script>
        @yield('js')
	<head>
	<body>
	@component('components.dashboard.navbar')
		@slot('brand')
			@yield('title')
		@endslot
		@slot('userContext')
			@component('components.dashboard.user-context', ['username' => Auth::user()->name, 'pictureUrl' => Auth::user()->picture_url])
			@endcomponent
		@endslot
	@endcomponent
	<div class='body'>
		<div class='body-part'>
			<ul class='dashboard-menu nav nav-pills nav-stacked'>
				<li><h4>Dashboard</h4></li>
				<li><a href='/pages'>Pages</a></li>
				<li><a href='/categories'>Categories</a></li>
				<li><a href='/articles'>Articles</a></li>
				<li><a href='/user'>User</a></li>
				<li><a href='/settings'>Settings</a></li>
			</ul>
		</div>

		@yield('contentBar')
		@yield('content')

		@component('components.dashboard.footer')
		@endcomponent
	</div>
</body>
</html>