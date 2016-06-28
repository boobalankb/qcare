@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Charities <div class="pull-right"><a href="{{url('/admin/charities/create')}}">Add New</a></div></div>
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
	                        <th>Category</th>
	                        <th>Email</th>
	                        <th>Phone</th>
	                        <th>Contact</th>
	                        <th>Action</th>
	                    </thead>

	                    <!-- Table Body -->
	                    <tbody>
	                        @foreach ($charities as $charity)
	                            <tr>
	                                <!-- Task Name -->
	                                <td class="table-text">
	                                    <div>{{ $charity->id }}</div>
	                                </td>

	                                <td class="table-text">
	                                    <div>{{ $charity->name }}</div>
	                                </td>

	                                <td class="table-text">
	                                    <div>{{ $charity->category['name'] }}</div>
	                                </td>

	                                <td class="table-text">
	                                    <div>{{ $charity->email }}</div>
	                                </td>

	                                <td class="table-text">
	                                    <div>{{ $charity->phone }}</div>
	                                </td>

	                                <td class="table-text">
	                                    <div>{{ $charity->contact_person }}</div>
	                                </td>

	                                <td>
	                                    <!-- TODO: Delete Button -->
	                                </td>
	                            </tr>
	                        @endforeach
	                    </tbody>
	                </table>
	                {{ $charities->links() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
