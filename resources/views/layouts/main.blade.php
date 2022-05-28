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
		
		@yield('contents')
		
		@include('components.footer-link')
		@include('components.footer')
	</body>
</html>