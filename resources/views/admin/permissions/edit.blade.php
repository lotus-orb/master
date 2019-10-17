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
							<h4 class="card-title">Edit Permissions {{$permissions->name}}</h4>
						</div>
					</div>
					<div class="card-body">
						<form action="{{route('permissions.update', $permissions->id)}}" method="POST">
							{{method_field('PUT')}}
							{{csrf_field()}}
							<div class="row">
								<div class="col-12 m-b-10">
									<div class="form-group form-floating-label">
						                <input name="display_name" id="display_name" type="text" class="form-control input-border-bottom" value="{{$permissions->display_name}}">
										<label for="display_name" class="placeholder">Name (Human Readable)</label>
						            </div>
									<div class="form-group m-b-10">
										<label for="name">Slug (Can not be edited)</label>
					                	<input itype="text" name="name" class="form-control" value="{{$permissions->name}}" disabled id="name">
						            </div>
						            <div class="form-group form-floating-label">
					                	<input itype="text" name="description" id="description" class="form-control input-border-bottom" value="{{$permissions->name}}" id="description">
										<label for="description" class="placeholder">Description</label>
						            </div>
								</div>
			                    <div class="col-12">
			                      <a href="{{route('permissions.index')}}" class="btn btn-info m-r-10"><i class="fa fa-angle-left m-r-10"></i> Back to Permission</a>
					              <button class="btn btn-primary">Save Changes to Permission</button>
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