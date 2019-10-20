<div class="cms-menu">
	<div class="container">
		<a href="/admin" class="logo">
			<img src="{{ url('backend/locomotif/img/logo.png') }}">
		</a>
		<div class="main-menu">
			<ul class="menu-dashboard">
				<li>
					<a href="/admin/testimonials">Testimonials</a>
				</li>
				<li>
					<a href="{{ route('admin/users') }}">Users</a>
				</li>
				<li>
					<a href="{{ route('admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
					<form id="logout-form" action="{{ route('admin/logout') }}" method="POST" style="display: none;">
					    @csrf
					</form>
				</li>
				<li>
					<a href="/admin/users/" class="menu-user-img">
						<img src="{{ url('backend/locomotif/img/user.png') }}">
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>