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
						@include('pages.UserControl._table-user')
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
@endsection

@section('js')
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '#delete_user', function(){
				var dataId = this.getAttribute('data-id');
				var dataToken = this.getAttribute('data-token');
				swal({
					title: "Are you sure?",
					text: "You will not be able to recover this imaginary file!",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: '#DD6B55',
					confirmButtonText: 'Yes, delete it!',
					cancelButtonText: "No, cancel plx!",
					closeOnConfirm: false,
					closeOnCancel: false
				},
				function(isConfirm){
				if (isConfirm){
					$.ajax({
						url: "{{ url('user-control') }}"+"/"+dataId,
						type: 'DELETE',
						data: { _token: dataToken},
						cache: true,
						success: function(data) {
							$('#table-container').html(data);
							swal("Deleted!", "Your imaginary file has been deleted!", "success");
						}
					});
				} else {
					swal("Cancelled", "Your imaginary file is safe :)", "error");
				}
				});
			});
		});
	</script>
@endsection