@extends('layouts.app')

@section('content')

	<div class="container-fluid" id="Profile">
		<div class="row">
			

			<div class="col-md-8 col-md-offset-2" style="padding:0">
			@if ($user->friends()->count())
				@foreach ($user->friends() as $friend)
				<div class="col-md-3">
					<div class="col-md-12 friend">
						<a href="{{ route('profile.view', ['id' => $friend->id]) }}">
						<p>{{ $friend->getFullName() }}</p>
						</a>
					</div>	
				</div>
					
				@endforeach
			@else
				<p class="text-center">{{ $user->getFullName() }} has no friends :(</p>
			@endif
			</div>
		</div>
	</div>
@stop