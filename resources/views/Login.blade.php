<!DOCTYPE html>
<html>
<head>
	<title>Kanaan School Raport</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{asset('/css/login-v2.css')}}">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="{{asset('/js/login-v2.js')}}"></script>
</head>
<body>
	<div class="container">
		<div class="tab">
			<button class="btn-active" id="login-tab" onclick="login()">Login</button>
			
		</div>
		<div class="img">
			<img src="{{asset('/image/login-logo.png')}}" alt="logo-kanaan-school">
		</div>

		<form method="post" action="/auth/Login">
			@csrf
			<div class="login">
				<div id="login-form">
					<input type="text" name="email" maxlength="#maxlength" size="50" id="email-field" class="login-form-field" placeholder="Email">

					<input type="password" name="password" maxlength="#maxlength" size="50" id="password-field" class="login-form-field" placeholder="Password">
				</div>

				<label id="remember-box">
			<!-- <input type="checkbox" checked="checked" name="remember-me" id="remember-box"> Remember me
			-->
			<input type="checkbox" name="remember-me" id="box">
			Remember me
		</label>

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
</body>
</html>