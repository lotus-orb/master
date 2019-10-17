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
						<form action="{{route('permissions.store')}}" method="POST">
				          {{csrf_field()}}

				          <div class="block">
				                <b-radio v-model="permissionType" name="permission_type" native-value="basic">Basic Permission</b-radio>
				                <b-radio v-model="permissionType" name="permission_type" native-value="crud" class="m-l-30">CRUD Permission</b-radio>
				          </div>

				          <div class="form-group form-floating-label m-t-30" v-if="permissionType == 'basic'">
				            <input type="text" class="form-control input-border-bottom" name="display_name" id="display_name">
				            <label for="display_name" class="placeholder">Name (Display Name)</label>
				          </div>

				          <div class="form-group form-floating-label" v-if="permissionType == 'basic'">
				            <input type="text" class="form-control input-border-bottom" name="name" id="name">
				            <label for="name" class="placeholder">Slug</label>
				          </div>

				          <div class="form-group form-floating-label m-b-30" v-if="permissionType == 'basic'">
				            <input type="text" class="form-control input-border-bottom" name="description" id="description">
				            <label for="description" class="placeholder">Description</label>
				          </div>

				          <div class="form-group form-floating-label m-t-30" v-if="permissionType == 'crud'">
				            <input type="text" class="form-control input-border-bottom" name="resource" id="resource" v-model="resource">
				            <label for="resource" class="placeholder">Resource</label>
				          </div>

				          <div class="columns" v-if="permissionType == 'crud'">
				            <div class="column is-one-quarter">
				                <div class="field m-b-10">
				                  <b-checkbox v-model="crudSelected" native-value="create">Create</b-checkbox>
				                </div>
				                <div class="field m-b-10">
				                  <b-checkbox v-model="crudSelected" v-model="crudSelected" native-value="read">Read</b-checkbox>
				                </div>
				                <div class="field m-b-10">
				                  <b-checkbox v-model="crudSelected" native-value="update">Update</b-checkbox>
				                </div>
				                <div class="field">
				                  <b-checkbox v-model="crudSelected" native-value="delete">Delete</b-checkbox>
				                </div>
				            </div> <!-- end of .column -->

				            <input type="hidden" name="crud_selected" :value="crudSelected">

				            <div class="column m-b-30">
				              <table class="table" v-if="resource.length >= 3 && crudSelected.length > 0">
				                <thead>
				                  <th>Name</th>
				                  <th>Slug</th>
				                  <th>Description</th>
				                </thead>
				                <tbody>
				                  <tr v-for="item in crudSelected">
				                    <td v-text="crudName(item)"></td>
				                    <td v-text="crudSlug(item)"></td>
				                    <td v-text="crudDescription(item)"></td>
				                  </tr>
				                </tbody>
				              </table>
				            </div>
				          </div>

				          <button class="btn btn-primary">Create Permission</button>
				        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
  <script>
    var app = new Vue({
      el: '#app',
      data: {
        permissionType: 'basic',
        resource: '',
        crudSelected: ['create', 'read', 'update', 'delete']
      },
      methods: {
        crudName: function(item) {
          return item.substr(0,1).toUpperCase() + item.substr(1) + " " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
        },
        crudSlug: function(item) {
          return item.toLowerCase() + "-" + app.resource.toLowerCase();
        },
        crudDescription: function(item) {
          return "Allow a User to " + item.toUpperCase() + " a " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
        }
      }
    });
  </script>
@endsection
