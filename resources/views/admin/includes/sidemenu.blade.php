<div class="sidebar sidebar-style-2">			
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			<div class="user">
				<div class="avatar-sm float-left mr-2">
					<img src="{{ asset('assets/img/avatar.png') }}" alt="..." class="avatar-img rounded-circle">
				</div>
				<div class="info">
					<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
						<span>
							{{ Auth::user()->name ?? ''}} 
							<span class="user-level">{{ Auth::user()->email ?? ''}} </span>
							<span class="caret"></span>
						</span>
					</a>
					<div class="clearfix"></div>

					<div class="collapse in" id="collapseExample">
						<ul class="nav">
							<li>
								<a href="{{ route('users.show', Auth::user()->id ?? '') }}">
									<span class="link-collapse">My Profile</span>
								</a>
							</li>
							<li>
								<a href="{{ route('logout') }}">
									<span class="link-collapse">Logout</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<ul class="nav nav-primary">
				<li class="nav-item active">
					<a href="{{ route('admin.dashboard') }}" class="collapsed" aria-expanded="false">
						<i class="fas fa-home"></i>
						<p>Dashboard</p>
					</a>
				</li>
				<li class="nav-section">
					<span class="sidebar-mini-icon">
						<i class="fa fa-ellipsis-h"></i>
					</span>
					<h4 class="text-section">Content</h4>
				</li>
				<li class="nav-section">
					<span class="sidebar-mini-icon">
						<i class="fa fa-ellipsis-h"></i>
					</span>
					<h4 class="text-section">Settings</h4>
				</li>
				<li class="nav-item">
					<a href="{{route('users.index')}}">
						<i class="fas fa-users"></i>
						<p>Users Management</p>
					</a>
				</li>
				<li class="nav-item">
					<a data-toggle="collapse" href="#roles">
						<i class="fas fa-key"></i>
						<p>Roles &amp; Permissions</p>
						<span class="caret"></span>
					</a>
					<div class="collapse" id="roles">
						<ul class="nav nav-collapse">
							<li>
								<a href="{{route('roles.index')}}">
									<span class="sub-item">Roles</span>
								</a>
							</li>
							<li>
								<a href="{{route('permissions.index')}}">
									<span class="sub-item">Permissions</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>