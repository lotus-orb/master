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
							<h4 class="card-title">Roles Management</h4>
							<button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
								<i class="fa fa-plus"></i>
								Tambah Roles
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
											Roles
											</span>
										</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-md-12">
												<form action="{{route('roles.store')}}" method="POST" id="frmRoles">
		      										{{csrf_field()}}
													<div class="row">
														<div class="col-md-6">
															<div class="form-group form-floating-label">
																<input name="display_name" id="display_name" type="text" class="form-control input-border-bottom" required>
																<label for="display_name" class="placeholder">Name (Human Readable)</label>
															</div>		
															<div class="form-group form-floating-label">
																<input itype="text" name="name" id="name" class="form-control input-border-bottom" required>
																<label for="email" class="placeholder">Slug (Can not be changed)</label>
															</div>
															<div class="form-group form-floating-label">
																<input itype="text" name="description" id="description" class="form-control input-border-bottom" required>
																<label for="description" class="placeholder">Deskripsi</label>
															</div>
															<input type="hidden" :value="permissionsSelected" name="permissions">
														</div>
														<div class="col-md-6">
															<div class="column">
													            <b-checkbox-group>
									                              @foreach ($permissions as $permission)
									                                <div class="field">
									                                	<b-checkbox v-model="permissionsSelected" :native-value="{{$permission->id}}">{{$permission->display_name}} <em>({{$permission->description}})</em>
									                             		</b-checkbox>
									                                </div>
									                              @endforeach
									                            </b-checkbox-group>
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
							            <th>Display Name</th>
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
	          ajax: '{{ route('api_roles') }}',
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
	<script>
	  var app = new Vue({
	    el: '#app',
	    data: {
	      permissionsSelected: []
	    }
	  });
	</script>
    <script>
	  	function simpan() {
	      $('#frmRoles').submit();
	   }
	</script>
 @endsection