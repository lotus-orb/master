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
							<h4 class="card-title">Edit User {{$users->name}}</h4>
						</div>
					</div>
					<div class="card-body">
						<form action="{{route('users.update', $users->id)}}" method="POST">
							{{method_field('PUT')}}
							{{csrf_field()}}
							<div class="row">
								<div class="col-6">
									<div class="form-group form-floating-label">
						                <input name="name" id="name" type="text" class="form-control input-border-bottom" value="{{$users->name}}">
										<label for="name" class="placeholder">Username</label>
						            </div>
									<div class="form-group form-floating-label">
					                	<input itype="text" name="email" id="email" class="form-control input-border-bottom" value="{{$users->email}}">
										<label for="email" class="placeholder">Email</label>
						            </div>
									<div class="form-group">
										<label for="password" class="label">Password</label>
								            <div class="block">
								              <div class="field">
								                <b-radio name="password_options" native-value="keep" v-model="password_options">Tidak Mengganti Password</b-radio>
								              </div>
								              <div class="field">
								                <b-radio name="password_options" native-value="auto" v-model="password_options">Auto-Generate Password Baru</b-radio>
								              </div>
								              <div class="field">
								                <b-radio name="password_options" native-value="manual" v-model="password_options">Buat Password Manual</b-radio>
								                <p class="control m-t-20">
								                  <input type="text" class="form-control" name="password" id="example-text-input" v-if="password_options == 'manual'" placeholder="Masukan Password Baru Anda">
								                </p>
								              </div>
								            </div>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label for="roles" class="label">Roles:</label>
							            <input type="hidden" name="roles" :value="rolesSelected" />
							            @foreach ($roles as $roles)
							              <div class="field">
							                <b-checkbox v-model="rolesSelected" :native-value="{{$roles->id}}">{{$roles->display_name}}</b-checkbox>
							              </div>
							            @endforeach
									</div>
						        </div>
			                    <div class="col-6">
			                      <a href="{{route('users.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Cancel</a>
					              <button class="btn btn-primary">Simpan</button>
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
        password_options: 'keep',
        rolesSelected: {!! $users->roles->pluck('id') !!}
      }
    });
  </script>
@endsection