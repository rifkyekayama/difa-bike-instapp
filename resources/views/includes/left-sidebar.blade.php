<aside id="left-sidebar-nav">
	<ul id="slide-out" class="side-nav fixed leftside-navigation">
		<li class="user-details cyan darken-2">
			<div class="row">
				<div class="col col s4 m4 l4">
						<img src="{{ asset('images/avatar.jpg', config('app.asset')) }}" alt="" class="circle responsive-img valign profile-image">
				</div>
				<div class="col col s8 m8 l8">
					<ul id="profile-dropdown" class="dropdown-content">
						<li><a href="#"><i class="mdi-action-face-unlock"></i> Profile</a>
						</li>
						<li><a href="#"><i class="mdi-action-settings"></i> Settings</a>
						</li>
						<li><a href="#"><i class="mdi-communication-live-help"></i> Help</a>
						</li>
						<li class="divider"></li>
						<li><a href="{{ route('logout') }}"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
						</li>
					</ul>
					<a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">{{ auth()->user()->name }}<i class="mdi-navigation-arrow-drop-down right"></i></a>
					<p class="user-roal">Administrator</p>
				</div>
			</div>
		</li>
		<li class="bold"><a href="{{ route('index') }}" class="waves-effect waves-cyan"><i class="mdi-action-dashboard"></i> {{ 'Dashboard' }}</a>
		</li>

		<li class="bold"><a href="{{ route('order.index') }}" class="waves-effect waves-cyan"><i class="mdi-maps-directions-bike"></i> {{ 'Pesanan' }}</a>
		</li>
		
		<li class="bold"><a href="{{ route('user-control.index') }}" class="waves-effect waves-cyan"><i class="mdi-action-accessibility"></i> {{ 'User Control' }}</a>
		</li>
	</ul>
	<a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
</aside>