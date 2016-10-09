@extends('layouts/master')

@section('title', $title)

@section('content')
	<!--breadcrumbs start-->
	<div id="breadcrumbs-wrapper">
		<!-- Search for small screen -->
		<div class="header-search-wrapper grey hide-on-large-only">
			<i class="mdi-action-search active"></i>
			<input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
		</div>
		<div class="container">
			<div class="row">
				<div class="col s12 m12 l12">
					<h5 class="breadcrumbs-title">{{ $title }}</h5>
					<ol class="breadcrumbs">
						<li><a href="index.html">Dashboard</a></li>
						<li><a href="#">Pages</a></li>
						<li class="active">Blank Page</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!--breadcrumbs end-->
	

	<!--start container-->
	<div class="container">
		<div class="section">
			<div class="divider"></div>

			@if(count($errors) > 0)
				<div id="card-alert" class="card red">
					<div class="card-content white-text">
						<p>
							<i class="mdi-alert-error"></i> DANGER : Terjadi kesalahan dalam pengisian form!
							<ul>
								<?php $no=1; ?>
								@foreach($errors->all() as $message)
									<li>{{ $no++.". ".$message }}</li>
								@endforeach
							</ul>
						</p>
					</div>
					<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			@endif

			<!--Input fields-->
			<div id="input-fields">
				<h4 class="header">Input fields</h4>
				<div class="row">
					<div class="col s12 m12 l12">
						<div class="row">
							{!! Form::open(['route' => ['user-control.store'], 'class' => 'col s12', 'id' => 'user_form']) !!}
								<div class="row">
									<div class="input-field col s12">
										{!! Form::text('name', old('name'), ['id' => 'name', 'class' => 'validate', 'placeholder' => 'Nama Lengkap']) !!}
										<label for="name">Nama Lengkap</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										{!! Form::email('email', old('email'), ['id' => 'email', 'class' => 'validate', 'placeholder' => 'Email']) !!}
										<label for="email">Email</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										{!! Form::password('password', ['id' => 'password', 'class' => 'validate', 'placeholder' => 'Password']) !!}
										<label for="password">Password</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										{!! Form::password('confirm_password', ['id' => 'confirm_password', 'class' => 'validate', 'placeholder' => 'Confirm Password']) !!}
										<label for="confirm_password">Confirm Password</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12">
										<button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
									</div>
								</div>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end container-->
@endsection