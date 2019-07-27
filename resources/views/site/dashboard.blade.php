@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center mb-4">
		<div class="col-12">
			<div class="card">
				<div class="card-header">Dashboard</div>

				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif

					You are logged in!
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<div class="lead">
						My Channels
					</div>
					<div>
						<a class="btn btn-outline-primary btn-sm py-1" href="{{route('channel.create')}}">New</a>
					</div>
				</div>
				<ul class="list-group list-group-flush">
				@if($channels->count() > 0)
					@foreach($channels as $c)
					<li class="list-group-item">
						<a href="{{$c->url()}}">#{{$c->name}}</a>
						<p class="mb-0 small text-muted">ID {{$c->id}}</p>
					</li>
					@endforeach
				@else
					<li class="list-group-item">You have no channels</li>
				@endif
				</ul>
			</div>
		</div>
		<div class="col-md-6"></div>
	</div>
</div>
@endsection
