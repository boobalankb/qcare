@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Categories <div class="pull-right"><a href="{{url('/admin/category/create')}}">Add New</a></div></div>
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

					<table class="table table-striped task-table">

	                    <!-- Table Headings -->
	                    <thead>
	                        <th>ID</th>
	                        <th>Name</th>
	                        <th>Action</th>
	                    </thead>

	                    <!-- Table Body -->
	                    <tbody>
	                        @foreach ($categories as $category)
	                            <tr>
	                                <!-- Task Name -->
	                                <td class="table-text">
	                                    <div>{{ $category->id }}</div>
	                                </td>

	                                <td class="table-text">
	                                    <div>{{ $category->name }}</div>
	                                </td>

	                                <td>
	                                    <!-- TODO: Delete Button -->
	                                </td>
	                            </tr>
	                        @endforeach
	                    </tbody>
	                </table>
	                {{ $categories->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
