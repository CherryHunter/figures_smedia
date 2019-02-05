@extends('layouts.app')

@section('content')

<div class="card my-4">
  <h5 class="card-header mx-2"><img rc="{{ asset('images/notification.png') }}">Twoje powiadomienia </h5>
  <div class="card-body">
    <ul class="list-group list-group-flush">
    @if(count($figures) > 0)

      @foreach($figures as $figure)
          <li class="list-group-item"><img class="card-img-top rounded-circle img-thumbnail smollimg" src="{{ asset('images/'.$figure['image']) }}" align="left" alt=""><h6 class="card-body" > {{ $figure['title'] }}</h6></li>

      @endforeach
    @endif
  </ul>
  </div>
</div>

@endsection
