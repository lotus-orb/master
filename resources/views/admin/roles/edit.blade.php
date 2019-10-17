@extends('layouts.admin')

@section('content')
<div class="content">
	<div class="page-inner">
		<div class="page-header">
			<ul class="breadcrumbs" style="margin: 0 !important; padding: 0px !important;">
				<li class="nav-home">
					<a href="#">
						<i class="flaticon-home"></i>
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
							<h4 class="card-title">Edit Roles {{$roles->name}}</h4>
						</div>
					</div>
					<div class="card-body">
						<form action="{{route('roles.update', $roles->id)}}" method="POST">
							{{method_field('PUT')}}
							{{csrf_field()}}
							<div class="row">
								<div class="col-6">
									<div class="form-group form-floating-label">
						                <input name="display_name" id="display_name" type="text" class="form-control input-border-bottom" value="{{$roles->display_name}}">
										<label for="display_name" class="placeholder">Name (Human Readable)</label>
						            </div>
									<div class="form-group m-b-10">
										<label for="name">Slug (Can not be edited)</label>
					                	<input itype="text" name="name" class="form-control" value="{{$roles->name}}" disabled id="name">
						            </div>
						            <div class="form-group form-floating-label">
					                	<input itype="text" name="description" id="description" class="form-control input-border-bottom" value="{{$roles->name}}" id="description">
										<label for="description" class="placeholder">Description</label>
						            </div>
						            <input type="hidden" :value="permissionsSelected" name="permissions">
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="roles" class="label">Roles:</label>
							            @foreach ($permissions as $permission)
					                      <div class="field">
					                        <b-checkbox v-model="permissionsSelected" :native-value="{{$permission->id}}">{{$permission->display_name}} <em>({{$permission->description}})</em></b-checkbox>
					                      </div>
					                    @endforeach
									</div>
						        </div>
			                    <div class="col-6">
			                      <a href="{{route('roles.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Back to Roles</a>
					              <button class="btn btn-primary">Save Changes to Role</button>
			                    </div>
							</div>
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
      permissionsSelected: {!!$roles->permissions->pluck('id')!!}
    }
  });
  </script>
@endsection