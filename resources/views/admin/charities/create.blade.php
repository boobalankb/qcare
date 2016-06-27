@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Create Charity</div>
				<div class="panel-body">
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

					{!! Form::open(array('url' => 'admin/charities', 'files' => true, 'class' => 'form-horizontal')) !!}
						{!! Form::token() !!}

						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Name</label>
								<div class="col-md-6">
									{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Category</label>
								<div class="col-md-6">
									{{ Form::select('charity_category_id', $categories, null, ['placeholder' => 'Choose Category']) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Description</label>
								<div class="col-md-6">
									{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Address</label>
								<div class="col-md-6">
									{{ Form::textarea('address', Input::old('address'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">State</label>
								<div class="col-md-6">
									{{ Form::text('state', Input::old('state'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Country</label>
								<div class="col-md-6">
									{{ Form::text('country', Input::old('country'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Zip</label>
								<div class="col-md-6">
									{{ Form::text('zip', Input::old('zip'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Phone</label>
								<div class="col-md-6">
									{{ Form::text('phone', Input::old('phone'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Email</label>
								<div class="col-md-6">
									{{ Form::text('email', Input::old('email'), array('class' => 'form-control')) }}
								</div>
							</div>
						</div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-md-4 control-label">Latitude</label>
								<div class="col-md-6">
									{{ Form::text('latitude', Input::old('latitude'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Longitude</label>
								<div class="col-md-6">
									{{ Form::text('longitude', Input::old('longitude'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Contact Person</label>
								<div class="col-md-6">
									{{ Form::text('contact_person', Input::old('contact_person'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Size</label>
								<div class="col-md-6">
									{{ Form::text('size', Input::old('size'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Certification</label>
								<div class="col-md-6">
									{{ Form::textarea('certification', Input::old('certification'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Authentication</label>
								<div class="col-md-6">
									{{ Form::textarea('authentication', Input::old('authentication'), array('class' => 'form-control')) }}
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Images</label>
								<div class="col-md-6">
									{{ Form::file('images') }}
								</div>
							</div>
						</div>

						

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Add Charity
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
