<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
    <link rel="stylesheet" href="css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    html, body{
    	height: 100%;
    }
    .main {
	    height: 100%;
	    width: 100%;
	    display: table;
	}
	.wrapper {
	    display: table-cell;
	    height: 100%;
	    vertical-align: middle;
	    z-index: 1;
	}
	.main { 
	  background:  @yield('background-url') no-repeat center center fixed; 
	  background-size: cover;
	}
	.shadow{
		text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;
	}
	</style>
</head>
<body>
	<div class="container main">
		<div class='row wrapper'>
			<div class='col-sm-12'>
				<h1 align='center'>@yield('message')</h1>
			</div>
		</div>
	</div>
</body>
</html>