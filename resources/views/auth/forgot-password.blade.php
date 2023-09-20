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
    <style>
        body {
            background: #d3d3d3;
        }
        .main {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items:center;
        }
        .form {
            background: #fff;
            padding: 50px 30px;
        }
    </style>
    <body>
    <div class="main">
            <div class="form">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(session()->has('status'))
                <div class="alert alert-success">
                    {{session()->get('status')}}
                </div>
                @endif
                <h2>Forgot Your Password</h2>
                <p>please enter your mail to password reset request</p>
                <form action="{{route('password.email')}}" method="post">
                @csrf
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
                <input type="submit" value="Request Password Reset" class="btn btn-primary w-100 mt-3">
                </form>
            </div>
        </div>
		
        <!-- <div style="top:27px; right:27px; position: fixed; z-index: 999;">
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
            <h2>Forgot Your Password</h2>
                <p>please enter your mail to password reset request</p>
                <form action="{{route('password.email')}}" method="post">
                @csrf
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email">
                <input type="submit" value="Request Password Reset" class="btn btn-primary w-100 mt-3">
                </form>
		</div> -->
		<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
		<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
		<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
    </body>
</html>