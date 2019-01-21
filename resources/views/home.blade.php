@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row timeline">
		<div class="col-md-3">
			<div class="col-md-12 profile followUser">
			<div class="profile-img text-center">
				<a href="{{ route('profile.view', ['id' => Auth::user()->id]) }}">
					<p>{{ Auth::user()->getFullName() }}</p>
				</a>
			</div>
				<ul class="nav nav-pills nav-stacked links">
					<li role="presentation"><a href="{{ route('friends', ['id' => Auth::user()->id]) }}"><i class="fa fa-fw fa-users" aria-hidden="true"></i> Friends</a></li>
				</ul>
			</div>
		</div>
		
		<div class="col-md-6 feed"> </div>

		<div class="col-md-3 sidebar">

			<div class="panel panel-default">
				<div class="panel-heading">
					Search for Friends
				</div>
				<div class="panel-body">
					<div class="input-group">
						{!! Form::text('q', null, ['class' => 'form-control', 'placeholder' => 'Search for friends..', 'id' => 'q']) !!}
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" id="SearchForFriendsButton"><i class="fa fa-search" aria-hidden="true"></i></button>
						</span>
					</div><!-- /input-group -->
					<div id="SearchResults">
						
					</div>
				</div>
			</div>

			@if (Auth::user()->HasAnyFriendRequestsPending()->count())
				<div class="panel panel-default">
					<div class="panel-heading">
						Friend Requests Pending
					</div>
					<div class="panel-body">
						@include('layouts.search_results', array('users' => Auth::user()->HasAnyFriendRequestsPending()))
					</div>
				</div>
			@endif

		</div>		
	</div>
</div>
@endsection


@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {

		function submitSearch(){
			var q = $("#q").val();
			var url = "{{ route('search.post') }}";
			var token = "{{ Session::token() }}";

			$.ajax({
				type: "POST",
				url: url,
				data: {_token: token, q: q},
				success: function(response){
					$("#SearchResults").html("<hr>");
					$("#SearchResults").append(response);
					friendEvents();
				}
			});
		}

		$("#SearchForFriendsButton").click(function(){
			submitSearch();
		});

		$("#q").keypress(function (e) {
			if (e.which == 13) {
				submitSearch();
				return false;
			}
		});

		function friendEvents(){
			$('.addFriend').click(function(){
				var id = $(this).attr('data-id');

				$.ajax({
					type: "POST",
					url: "{{ route('friend.add') }}",
					data: {id: id, _token: '{{ Session::token() }}'},
					success: function(response){
						$("#friendStatusDiv" + id).html(response);
						friendEvents();
					}
				});
			});

			$('.cancelFriend').click(function(){
				var id = $(this).attr('data-id');

				$.ajax({
					type: "POST",
					url: "{{ route('friend.cancel') }}",
					data: {id: id, _token: '{{ Session::token() }}'},
					success: function(response){
						$("#friendStatusDiv" + id).html(response);
						friendEvents();
					}
				});
			});

			$('.removeFriend').click(function(){
				var id = $(this).attr('data-id');

				$.ajax({
					type: "POST",
					url: "{{ route('friend.remove') }}",
					data: {id: id, _token: '{{ Session::token() }}'},
					success: function(response){
						$("#friendStatusDiv" + id).html(response);
						friendEvents();
					}
				});
			});

			$('.acceptFriend').click(function(){
				var id = $(this).attr('data-id');

				$.ajax({
					type: "POST",
					url: "{{ route('friend.accept') }}",
					data: {id: id, _token: '{{ Session::token() }}'},
					success: function(response){
						$("#friendStatusDiv" + id).html(response);
						friendEvents();
					}
				});
			});
		}

		friendEvents();
	});
</script>
@append