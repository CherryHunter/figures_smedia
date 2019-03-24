@extends('layouts.app')

@section('content')

@if(session()->has('message'))
  <div class="alert alert-success fade show">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                      ×</button>
                  <span class="glyphicon glyphicon-record"></span> <strong>Informacja</strong>
                  <hr class="message-inner-separator">
                  <p>
                      {{Session::get('message')}}</p>
  </div>
@endif


<div class="card my-4">
  <h2 class="card-header">{{ $figure['title'] }} </h2>
  <div class="card-body">

          <img src="{{ asset('images/'.$figure['image']) }}" align="left" alt="">
          <h4 class="fat">Informacje:</h4>
            <ul class="list-group list-group-flush">
              <li class="list-group-item"><b>Postać:</b> {{$figure->character['name']}}</li>
              <li class="list-group-item"><b>Seria:</b> {{$figure->character['series']}}</li>
              <li class="list-group-item"><b>Producent:</b> {{$figure['maker']}}</li>
              <li class="list-group-item"><b>Data wydania:</b> {{$figure['date']}}</li>
              <li class="list-group-item"><b>Popularność:</b> {{$figure['popularity']}} <a class="d-flex flex-row-reverse material-icons" href="{{route('add_like', ['id'=>$figure->id])}}">favorite</a></li>
            </ul>

            @guest
            @else
            @if(empty($figure->notification()))
            <h6 class="card-body" > <a class="d-flex flex-row-reverse material-icons" href="{{route('add_notification', ['id'=>$figure->character_id])}}">notifications_active</a> </h6>
            @endif
            @if(empty($figure->collection()))
            <a href="{{route('add_tocollection', ['id'=>$figure->id])}}" class="btn btn-secondary my-4 d-flex flex-row-reverse" type="button" onclick="#" >Dodaj do mojej kolekcji</a>
            @endif
            @endguest

            </br>
            <h4 class="fat">Dostępność:</h4>

            <table class="table">
  <thead>
    <tr>
      <th scope="col">Cena</th>
      <th scope="col">Sklep</th>
    </tr>
  </thead>
  <tbody>
    @foreach($figure->sales as $sale)
    <tr>
      <td scope="row" class="jpy">{{$sale['price']}} jpy</td>
      <?php
      $valueJPY = Currency::conv($from = 'JPY', $to = 'PLN', $value = 1, $decimals = 2);
      if ($valueJPY == 0){
        $valueJPY = 0.04;
      }?>
      <td scope="row" class="pln">{{$sale['price']*$valueJPY}} PLN</td>

      <td><a class="col" href="{{$sale->shop['link']}}" >{{$sale->shop['name']}}</a></td>
    </tr>
    @endforeach
  </tbody>
</table>

  </div>
</div>

@guest
@elseif (Auth::user()->banned == 0)
<!-- Comments Form -->
<div class="card my-4">
  <h5 class="card-header">Skomentuj:</h5>
  <div class="card-body">
    {{ Form::open(array('route' => 'add_comment')) }}
      <div class="form-group">
        {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3, 'maxlength'=>"400"]) }}
      </div>
      {{ Form::hidden('figure_id', $figure['id']) }}
      {{ Form::submit('Wyślij', ['class' => 'btn btn-primary']) }}
    {{ Form::close() }}
  </div>
</div>
@endguest



<ul class="list-unstyled">
@foreach($figure->comments as $comment)
<!-- Single Comment -->
<li class="media my-4">
  <img class="d-flex mr-3 rounded-circle" src="/images/avatars/{{$comment->user->avatar}}" height="100" width="100" alt="">
  <div class="media-body">
    <h5 class="mt-0 mb-1 fat">{{$comment->user['name']}}</h5>
    {{$comment['body']}}
    <div class= "d-flex flex-row-reverse smolltext">Dodano: {{$comment['created_at']}}</div>
    @if(Auth::check())

    @if( $comment->user['name'] == Auth::user()->name)
    <div class="d-flex flex-row-reverse smolltext material-icons" onclick="return confirm('Na pewno chcesz usunąć?')"><a href="{{route('delete_comment', ['id'=>$comment->id])}}">delete</a></div>
    @else
    <div class="d-flex flex-row-reverse" onclick="return confirm('Na pewno?')"><a href="{{route('report_comment', ['id'=>$comment->id])}}">Zgłoś komentarz</a></div>
    @endif
    @endif
  </div>
</li>
@endforeach
</ul>

@endsection
