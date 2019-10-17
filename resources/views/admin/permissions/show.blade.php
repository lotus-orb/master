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
						<div class="card-title">Permissions Details for ({{$permissions->name}})</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" class="form-control" value="{{$permissions->display_name}} ({{$permissions->name}})" disabled>	
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="name">Deskripsi</label>
									<input type="text" class="form-control" value="{{$permissions->description}}" disabled>	
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								{{-- @if (Auth::user()->hasRole(['superadministrator','administrator'])) --}}
								<a href="{{route('permissions.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Back to Permission</a>
								{{-- @else --}}
{{-- 								<a href="{{route('permissions.edit', $permissions->id)}}" class="button is-primary"><i class="fa fa-user m-r-10"></i> Edit My Profil</a> --}}
								{{-- @endif --}}
{{-- 								@if (Auth::user()->hasRole(['superadministrator','administrator'])) --}}
								<a href="{{route('permissions.edit', $permissions->id)}}" class="btn btn-primary"><i class="fa fa-user m-r-10"></i> Edit Permission</a>
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