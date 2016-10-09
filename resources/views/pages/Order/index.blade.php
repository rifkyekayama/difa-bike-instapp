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

		@include('flash::custom')
		
		<div id="striped-table">
			<h4 class="header">Striped Table</h4>
			<div class="row">
				<div class="col s12">
					<div id="table-container">
						@include('pages.Order._table-order')
					</div>
				</div>
			</div>
		</div>
		
		<!-- Floating Action Button -->
		<div class="fixed-action-btn" style="bottom: 50px; right: 19px;">
			<a href="{{ route('user-control.create') }}" class="btn-floating btn-large">
				<i class="mdi-content-add-circle"></i>
			</a>
		</div>
		<!-- Floating Action Button -->
	</div>
	<!--end container-->

	<div id="modal1" class="modal">
		<div class="modal-content">
			
		</div>
		<div class="modal-footer">
			<button class="waves-effect waves-red btn-flat" id="closeModal">Close</button>
		</div>
	</div>
@endsection

@section('js')
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '#btnLocation', function(){
				$.ajax({
					type: "GET",
					url: "{{ url('order') }}"+"/"+this.getAttribute('data-id'),
					success: function(data){
						$('.modal-content').html(data);
						$('#modal1').openModal();
					}
				});
			});

			$('#closeModal').on("click", function(){
				$('#modal1').closeModal();
			});
		});
	</script>
@endsection