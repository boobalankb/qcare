@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Category</div>
				<div class="panel-body">
					@if(Session::has('message'))
				    	<p class="alert {{ Session::get('message-class', 'alert-info') }}">{{ Session::get('message') }}</p>
				    @endif
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					{!! Form::model($category, array('route' => array('admin.category.update', $category->id), 'class' => 'form-horizontal', 'method' => 'put')) !!}
						{!! Form::token() !!}

						<div class="col-md-10">
							<div class="form-group">
								<label class="col-md-4 control-label">Name</label>
								<div class="col-md-6">
									{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
								</div>
							</div>
						</div>						

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Update
								</button>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
