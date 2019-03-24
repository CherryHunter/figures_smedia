@extends('layouts.app')

@section('content')

<div class="card my-4">
  <h5 class="card-header">Szukaj: </h5>
  <div class="card-body">
      {{ Form::open(array('route' => 'search_users')) }}
    <div class="input-group">
      {{ Form::text('keyword', null, ['class' => 'form-control', 'maxlength'=>"20", 'placeholder'=>"Wpisz nazwę użytkownika..."]) }}
      <span class="input-group-btn">
      {{ Form::submit('Szukaj', ['class' => 'btn btn-secondary']) }}
      {{ Form::close() }}
      </span>
    </div>
  </div>
</div>

<div class="card my-4">
<h3 class="card-header"> Użytkownicy </h3>
<div class="card-body my-4">

  @php
    $i = 0
  @endphp
  @foreach($users as $user)
  @if($i == 0)
    <div class="row">
  @endif
  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card h-100">
    <div class="d-flex justify-content-center my-2"><a href="{{route('profile', ['name'=>$user->name])}}" onclick="#"><img src="/images/avatars/{{$user->avatar}}" height="100" width="100" style="border-radius:50%;" ></a></div>
      <div class="card-footer">
        <div class="text-muted d-flex justify-content-center"><a href="{{route('profile', ['name'=>$user->name])}}" onclick="#">{{$user->name}}</a></div>
      </div>
    </div>
  </div>
  @php
    $i++
  @endphp
  @if($i == 3)
    </div>
    @php
      $i = 0
    @endphp
    @endif
  @endforeach
  @if($i != 0)
    </div>
  @endif
</div>
</div>



@endsection
