@extends('layouts.admin')

@section('content')
<div class="content">
	<div class="page-inner">
		<div class="page-header">
			<ul class="breadcrumbs" style="margin: 0 !important; padding: 0px !important;">
				<li class="nav-home">
					<a href="#">
						<i class="flaticon-home"></i>
						Dashboard
					</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a href="#">Tables</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a href="#">Datatables</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="d-flex align-items-center">
							<h4 class="card-title">Permission Management</h4>
							<a href="{{route('permissions.create')}}" class="btn btn-primary btn-round ml-auto">
								<i class="fa fa-plus"></i>
								Tambah Permission
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="datatable" class="display table-head-bg-primary table table-striped table-hover" >
								<thead>
									<tr>
										<th>No</th>
							            <th>Name</th>
							            <th>Slug</th>
							            <th>Deskripsi</th>
							            <th></th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
  	<script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
	<script type="text/javascript">
	    $(document).ready(function() {

	      var t = $('#datatable').DataTable({
	      	  $('body').on('click', '.hapus', function( e ) {
		            e.preventDefault();
		            var me = $(this),
		            	url = me.attr('href'),
		            	title = me.attr('title');

		            Swal.fire({
					  title: 'Anda yakin akan menghapus ' + title + ' ?',
					  text: 'Kami tidak bertanggung jawab atas tindakan ini!',
					  type: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#3085d6',
					  cancelButtonColor: '#d33',
					  confirmButtonText: 'Yes, hapus data!'
					}).then((result) => {
				        if (result.value) {
				            $.ajax({
				                url: url,
					            type: 'DELETE',
					            data: {method: '_DELETE'},
					            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				                success: function (response) {
				                    $('#datatable').DataTable().ajax.reload();
				                    Swal.fire({
				                        type: 'success',
				                        title: 'Success!',
				                        text: 'Data berhasil dihapus!'
				                    });
				                },
				                error: function (xhr) {
				                    Swal.fire({
				                        type: 'error',
				                        title: 'Oops...',
				                        text: 'Terjadi Kesalahan!'
				                    });
				                }
				            });
				        }
				    });
		        });
			  },
	          processing: true,
	          serverSide: true,
	          "aaSorting": [[ 0,"desc" ]] ,
	          "searchable": false,
	          "orderable": false,
	          "targets": 0,
	          ajax: '{{ route('api_permissions') }}',
	          columns: [
	              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
	              {data: 'display_name', name: 'display_name'},
	              {data: 'name', name: 'name'},
	              {data: 'description', name: 'description'},
	              {data: 'action', name: 'action', orderable: false, searchable: false, "width" : "30%"}
	          ]
	        });
	      });
	</script>
 @endsection