<!doctype html>
<html lang="en">
    <head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		  
		<!-- Custom styles for this template -->
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

		<!-- Font Awesome JS -->
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
		<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

		<title>Unisba</title>
    </head>
    <body>
		<div style="top:27px; right:27px; position: fixed; z-index: 99999;">
			@if (session('success'))
				<div class="alert alert-primary alert-dismissible fade show" role="alert">
						{{ session('success') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
			@endif
	
			@if (session('error') || $errors->has('username') || $errors->has('password'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
						{{ session('error') }}
						{{ $errors->first('username') }}
						{{ $errors->first('password') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
				</div>
			@endif
		</div>

		<div class="auth-wrapper">
			<div class="auth-content text-center">
				<div class="card borderless">
					<div class="row align-items-center ">
						<div class="col-md-12">
							<div class="card-body">
								<h4 class="mb-3 f-w-400">Login</h4>
								<hr>
								<form action="/login" method="post" name="formLogin" id="form-login">
									@csrf
									<div class="form-group mb-3">
										<input type="text" class="form-control" id="username" name="username" placeholder="Username" autofocus>
									</div>
									<div class="form-group mb-4">
										<input type="password" class="form-control" id="password" name="password" placeholder="Password">
									</div>
									<button class="btn btn-block btn-primary mb-4" type="submit">Login</button>
									<p class="mt-5 mb-3 text-muted text-center">© Fakultas Psikologi 2021–2022</p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    </body>
</html>