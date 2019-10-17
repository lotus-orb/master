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
						<div class="card-title">User Details for ({{$users->name}})</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Username</label>
									<input type="text" class="form-control" value="{{$users->name}}" disabled>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Email</label>
									<input type="text" class="form-control" value="{{$users->email}}" disabled>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Roles</label>
									@forelse ($users->roles as $roles)
			                         	<input name="name" id="name" type="text" class="form-control" value="{{$roles->display_name}} ({{$roles->description}})" disabled>
			                        @empty
			                        	<input name="name" id="name" type="text" class="form-control" value="(User ini belum diberikan role apapun)" disabled>
			                        @endforelse
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<a href="{{route('users.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Cancel</a>
								<a href="{{route('users.edit', $users->id)}}" class="btn btn-primary"><i class="fa fa-user m-r-10"></i> Edit User</a>
							</div>
						</div>
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
        auto_password: true,
        rolesSelected: [{!! old('roles') ? old('roles') : '' !!}]
      }
    });
  </script>
@endsection