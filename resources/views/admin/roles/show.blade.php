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
						<div class="card-title">Roles Details for ({{$roles->name}})</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" class="form-control" value="{{$roles->display_name}}" disabled>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Display Name</label>
									<input type="text" class="form-control" value="{{$roles->name}}" disabled>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Deskripsi</label>
									<input type="text" class="form-control" value="{{$roles->description}}" disabled>	
								</div>
							</div>
							<div class="col-sm-12">
								<h2 class="title">Permissions:</h1>
				                <ul>
				                  @foreach ($roles->permissions as $r)
				                    <li style="list-style: inside; padding: 5px;">{{$r->display_name}} <em class="m-l-15">({{$r->description}})</em></li>
				                  @endforeach
				                </ul>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								{{-- @if (Auth::user()->hasRole(['superadministrator','administrator'])) --}}
								<a href="{{route('roles.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Back to Roles</a>
								{{-- @else --}}
{{-- 								<a href="{{route('roles.edit', $roles->id)}}" class="button is-primary"><i class="fa fa-user m-r-10"></i> Edit My Profil</a> --}}
								{{-- @endif --}}
{{-- 								@if (Auth::user()->hasRole(['superadministrator','administrator'])) --}}
								<a href="{{route('roles.edit', $roles->id)}}" class="btn btn-primary"><i class="fa fa-user m-r-10"></i> Edit Roles</a>
								{{-- @endif --}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection