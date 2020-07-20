<!DOCTYPE html>
<html>
<head>
	<title>Forgot Password</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{asset('/css/login-v3.css')}}">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="{{asset('/js/alert-box.js')}}"></script>
</head>
<body>
	
	<div class="container">

		<h2>Forgot Password ?</h2>
		<form method="post" action="{{url('/forgot_password')}}">
			@csrf
			<div class="login">
				<div id="login-form">
					<input type="email" name="email" maxlength="#maxlength" size="50" id="email-field" class="login-form-field" placeholder="Email">
				</div>

		<button type="submit" id="login-button">
			Submit
		</button>
	</form>

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
    </div>
@endif

@if(Session::has('error'))
    <script type="text/javascript">
		alert("{{ Session::get('error') }}");
    </script>
@endif
</body>
</html>