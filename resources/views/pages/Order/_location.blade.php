<form class="col s12">
	<div class="row">
		<div class="input-field col s12">
			<input type="text" id="title" name="title" value="{{ $location->title }}" placeholder="Title">
			<label for="title">Title</label>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12">
			<textarea name="address" id="address" class="materialize-textarea">{{ $location->address }}</textarea>
			<label for="address">Address</label>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12">
			<input type="text" id="latitude" name="latitude" placeholder="Latitude" value="{{ $location->latitude }}">
			<label for="latitude">Latitude</label>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12">
			<input type="text" id="longitude" name="longitude" pladeholder="Longitude" value="{{ $location->longitude }}">
			<label for="longitude">Longitude</label>
		</div>
	</div>
	<div class="row">
		<div class="input-field col s12">
			<input type="text" id="latlang" name="latlang" placeholder="LatLang" value="{{ $location->latitude.','.$location->longitude }}">
			<label for="latlang">Latlang</label>
		</div>
	</div>
</form>