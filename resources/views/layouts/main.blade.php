<!DOCTYPE html>
<html lang="en">
	<head>
		@include('components.header')
		@include('components.header-link')
	</head>
	<body>
		@include('components.pre-loader')

		@include('components.content-header')

		@include('components.menus')
		
		@include('components.footer-link')

		<div class="pcoded-main-container">
			<div class="pcoded-content">
				@yield('contents')
			</div>
		</div>
		
		@include('components.footer')
	</body>
</html>