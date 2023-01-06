	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar  ">
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div " >
				
				<div class="">
					<div class="main-menu-header">
						@if(auth()->user()->load('student')->student)
                            <img src="{{ url("uploads/profiles/". auth()->user()->load('student')->student->photo) }}" alt="{{ auth()->user()->load('student')->name }}" class="img-radius profile-img cust-img">
                        @else
                            <img src="{{ url("assets/images/user/avatar-4.jpg") }}" alt="user image" class="img-radius profile-img cust-img">
                        @endif
						<a href="{{ route('profile.index') }}">
							<div class="user-details">
								<span>{{ auth()->user()->name }}</span>
								<div id="more-details">{{ auth()->user()->username }}</div>
							</div>
						</a>
					</div>
				</div>
				
				<ul class="nav pcoded-inner-navbar ">
					<li class="nav-item pcoded-menu-caption">
						<label>Navigation</label>
					</li>
					<li class="nav-item">
						<a href="{{ route('home') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>
					
					@if(in_array($user->level, [1, 2, 3, 4]))
						<li class="nav-item pcoded-menu-caption">
							<label>Activities</label>
						</li>
						<li class="nav-item {{ $active == 'student-activities' ? 'active' : '' }}">
							<a href="{{ route('student.activity.index') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Activities</span></a>
						</li>
						@if(in_array($user->level, [1, 4]))
							<li class="nav-item pcoded-menu-caption">
								<label>Administration</label>
							</li>
							@if(in_array($user->level, [1]))
								<li class="nav-item {{ $active == 'users' ? 'active' : '' }}">
									<a href="{{ route('user.index') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Users</span></a>
								</li>
							@endif

							<li class="nav-item {{ $active == 'students' ? 'active' : '' }}">
								<a href="{{ route('student.index') }}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-users"></i></span><span class="pcoded-mtext">Mahasiswa</span></a>
							</li>
							@if(in_array($user->level, [1]))
								<li class="nav-item pcoded-hasmenu {{ $active == 'activities' ? 'active pcoded-trigger' : '' }}">
									<a href="javascript:void(0)" class="nav-link "><span class="pcoded-micon"><i class="feather icon-file-text"></i></span><span class="pcoded-mtext">Activities</span></a>
									<ul class="pcoded-submenu">
										<li class="{{ $sub_active == 'activities' ? 'active' : '' }}"><a href="{{ route('activity.index') }}">Activities</a></li>
									</ul>
								</li>
								<li class="nav-item {{ $active == 'informations' ? 'active' : '' }}">
									<a href="{{ route('information.index') }}" class="nav-link"><span class="pcoded-micon"><i class="feather icon-info"></i></span><span class="pcoded-mtext">Informations</span></a>
								</li>
							@endif
						@endif
					@endif
				</ul>
				
				<!-- <div class="card text-center">
					<div class="card-block">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="feather icon-sunset f-40"></i>
						<h6 class="mt-3">Flat Able</h6>
						<p>Please contact us on our email for need any support</p>
					</div>
				</div> -->
				
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->