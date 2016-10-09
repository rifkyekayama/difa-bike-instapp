@if (session()->has('flash_notification.message'))
	<div id="card-alert" class="card {{ session('flash_notification.level') == 'info' ? 'light-blue' : session('flash_notification.level') }}">
		<div class="card-content white-text">
			<p>
				<i class="mdi-alert-error"></i> {!! session('flash_notification.message') !!}
			</p>
		</div>
		<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
	</div>
@endif