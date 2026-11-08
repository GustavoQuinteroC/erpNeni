
<!doctype html>
<html lang="es">
  <head>
  	<title>ERP Neni | Iniciar sesión</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="{{ asset('assets/styles/login.css') }}">

	</head>
	<body class="img js-fullheight" style="background-image: url({{ asset('assets/src/banner_login.jpg') }});">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">ERP Neni</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Ingresa a tu cuenta</h3>
				@if ($errors->any())
					<div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
				@endif
				<div class="alert alert-light" role="note">
					<strong>Demo de solo lectura</strong><br>
					Correo: {{ $demo['correo'] }}<br>
					Contraseña: {{ $demo['clave'] }}
				</div>

		      	<form action="{{route('login')}}" class="signin-form" method="post">
                    @csrf
		      		<div class="form-group">
		      			<input type="email" class="form-control" placeholder="Correo" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
		      		</div>
	            <div class="form-group">
	              <input id="password-field" type="password" class="form-control" placeholder="Contraseña" name="password" autocomplete="current-password" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
	            	<button type="submit" class="form-control btn btn-primary submit px-3">Ingresar</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Recuerdame
									  <input type="checkbox" name="remember" value="1">
									  <span class="checkmark"></span>
									</label>
								</div>
	            </div>
	          </form>
		      </div>
				</div>
			</div>
		</div>
	</section>

  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>

	</body>
</html>
