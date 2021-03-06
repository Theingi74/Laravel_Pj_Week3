@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <div class="container">
				<h2>Home Page</h2>
				@if(session("session_message"))
				<div class="alert alert-primary alert-dismissible fade show" role="alert">
				  {{session("session_message")}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
				<a href="/receipe/create">
					<button class="btn btn-success"> Create Receipe </button>
				</a>
				<br><br>
				@foreach($data as $value)
					<a href="/receipe/{{ $value->id }}">
						<li>{{ $value->name}}</li>
					</a>
					<hr>
				@endforeach

				{{$data->links()}}
			</div>
        </div>
    </div>
</div>
@endsection


	
