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
							<h4 class="card-title">Users Management</h4>
							<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
								<i class="fa fa-plus"></i>
								Tambah User
							</button>
						</div>
					</div>
					<div class="card-body">
						<!-- Modal -->
						<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header no-bd">
										<h5 class="modal-title">
											<span class="fw-mediumbold">
											Tambah</span> 
											<span class="fw-light">
												User
											</span>
										</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<form action="{{route('users.store')}}" method="POST" id="frmArtikel">
		      										{{csrf_field()}}
													<div class="row">
														<div class="col-md-6">
															<div class="form-group form-floating-label">
																<input name="name" id="name" type="text" class="form-control input-border-bottom" required>
																<label for="name" class="placeholder">Username</label>
															</div>
															<div class="form-group form-floating-label">
																<input itype="text" name="email" id="email" class="form-control input-border-bottom" required>
																<label for="email" class="placeholder">Email</label>
															</div>			
															<div class="form-group form-floating-label">
																<input type="password" name="password" id="password" class="form-control input-border-bottom" v-if="!auto_password" required>
																<label for="password" class="placeholder">Password</label>
															</div>
															<div class="form-group-default">
																<b-checkbox name="auto_generate" class="m-t-15" v-model="auto_password">Auto Generate Password</b-checkbox>
															</div>
														</div>
														<div class="col-md-6">
															<div class="column">
													          <label for="roles" class="label">Roles:</label>
													          <input type="hidden" name="roles" :value="rolesSelected" />

													            @foreach ($roles as $role)
													              <div class="field">
													                <b-checkbox v-model="rolesSelected" :native-value="{{$role->id}}">{{$role->display_name}}</b-checkbox>
													              </div>
													            @endforeach
													        </div>
												    	</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="modal-footer no-bd">
										<a href="javascript:simpan()" class="btn btn-primary">Add</a>
										<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
									</div>
						    	</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="datatable" class="display table-head-bg-primary table table-striped table-hover" >
								<thead>
									<tr>
										<th>No</th>
							            <th>Name</th>
							            <th>Email</th>
							            <th>Date Created</th>
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
{{--   	<script src="{{ asset('assets/js/setting-demo.js') }}"></script> --}}
	<script type="text/javascript">
	    $(document).ready(function() {

	      var t = $('#datatable').DataTable({
	      	  "drawCallback": function( settings ) {
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
	          "aaSorting": [[ 3,"desc" ]] ,
	          "searchable": false,
	          "orderable": false,
	          "targets": 0,
	          ajax: '{{ route('api_data') }}',
	          columns: [
	              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
	              {data: 'name', name: 'name'},
	              {data: 'email', name: 'email'},
	              {data: 'created_at', name: 'created_at'},
	              {data: 'action', name: 'action', orderable: false, searchable: false, "width" : "30%"}
	          ]
	        });
	      });
	</script>
	<script>
	    var app = new Vue({
	      el: '#app',
	      data: {
	        auto_password: true,
	        rolesSelected: [{!! old('roles') ? old('roles') : '' !!}]
	      }
	    });
    </script>
	<script>
		function simpan() {
	  $('#frmArtikel').submit();
	}
	</script>
 @endsection