<!DOCTYPE html>
<html>
<head>
	<title>Strada School Raport</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{asset('/css/login-v3.css')}}">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="{{asset('/js/login-v2.js')}}"></script>

	
</head>
<body>
	<div class="container">
		<div class="img">
			<img src="{{asset('/image/logo-strada-edit.png')}}" alt="logo-strada-school">
		</div>

		<form method="post" action="/student/StudentLoginPage">
			@csrf
			<div class="login">
				<div id="login-form">
					<input type="email" name="email" maxlength="#maxlength" size="50" id="email-field" class="login-form-field" placeholder="Email">

					<input type="password" name="password" minlength="6"  size="50" id="password-field" class="login-form-field" placeholder="Password">
				</div>

		
		<button type="submit" id="login-button">
			Login
		</button>
	</form>

	<label class="forgot-password">
		<button id="fp-button"><img src="{{asset('/image/lock.png')}}">
			Forgot your password?
		</button>
	</label>
</div>
</div>

@if(Session::has('error'))
    <script type="text/javascript">
		alert("{{ Session::get('error') }}");
    </script>
@endif
</body>
</html>