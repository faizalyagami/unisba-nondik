	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">
		<div class="m-header">
			<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
			<a href="#!" class="b-brand">
				<!-- ========   change your logo hear   ============ -->
				{{-- <img src="assets/images/icon-unisba.png" alt="" class="logo">
				<img src="assets/images/icon-unisba.png" alt="" class="logo-thumb"> --}}
				<span style="font-size: 27px; font-weight: bold;">SKSNONDIK</span>
			</a>
			<a href="#!" class="mob-toggler">
				<i class="feather icon-more-vertical"></i>
			</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="navbar-nav ml-auto">
				<li>
					@if(auth()->user()->load('student')->student)
						<div class="dropdown">
							@php($now = time())
							@php($your_date = strtotime(auth()->user()->load('student')->student->period))
							@php($datediff = $your_date - $now)
							<div class="blink_me" style="color: #1abc9c">Peridode pengisian sisa {{ round($datediff / (60 * 60 * 24)) }} hari lagi.</div>
						</div>
					@endif
				</li>
				<li>
					<div class="dropdown drp-user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="feather icon-user"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right profile-notification">
							<div class="pro-head">
								@if(auth()->user()->load('student')->student)
									<img src="{{ url("uploads/profiles/". auth()->user()->load('student')->student->photo) }}" alt="{{ auth()->user()->load('student')->name }}" class="img-radius profile-img cust-img">
								@else
									<img src="{{ url("assets/images/user/avatar-4.jpg") }}" alt="user image" class="img-radius profile-img cust-img">
								@endif

								@php($abbreviation = explode(' ', trim(auth()->user()->name))[0])
								<span title="{{ auth()->user()->name }}">{{ $abbreviation }}</span>
								<a href="{{ route('logout') }}" class="dud-logout" title="Logout">
									<i class="feather icon-log-out"></i>
								</a>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</header>
	<!-- [ Header ] end -->