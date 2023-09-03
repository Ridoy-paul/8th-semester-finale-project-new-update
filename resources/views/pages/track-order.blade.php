@extends('layouts.master')

@section('title')
Track Order | {{ env('APP_NAME') }}
@endsection

@section('content')
	<div class="main-content">
		<div class="container">
			<div class="row justify-content-center p-4">
				<div class="col-md-8">
					<form action="{{ route('order.track.result') }}" method="GET" style="padding: 50px 0px;">
						@csrf
						<div class="form-group">
							<input type="text" name="code" placeholder="Code" class="form-control">
						</div>
						<div class="form-group" align="center">
							<button type="submit" class="btn btn-rounded btn-dark">Track Now</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection