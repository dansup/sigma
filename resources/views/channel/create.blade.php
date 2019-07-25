@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-12 col-md-8 offset-md-2 pt-5">
			<div>
				<h2>Create Channel</h2>
			</div>
			<hr>
			<div class="card shadow-sm">
				<div class="card-body">
					<form method="post">
						@csrf
						<div class="form-group">
							<label>Channel Name</label>
							<input type="text" class="form-control" placeholder="Yeet" name="name">
						</div>
						<div class="form-group">
							<label>Channel Description</label>
							<textarea class="form-control" name="description" cols="3"></textarea>
						</div>
						<hr>
						<div class="text-right">
							<button type="submit" class="btn btn-primary font-weight-bold py-1 px-4">Create</button>
						</div>
					</form>
				</div>	
			</div>
		</div>
	</div>
</div>

@endsection