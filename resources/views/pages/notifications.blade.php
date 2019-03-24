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
  <h5 class="card-header">Twoje powiadomienia </h5>
  <div class="card-body">

    <div class="my-4">
<div class="card h-100">
  <h5 class="card-header mediumtext">Ogłoszenia</h5>
  <div class="card-body my-4">

        <ul class="list-group list-group-flush">
        @if(count($actual_notifications) > 0)
          @foreach($actual_notifications as $notification)
              <li class="list-group-item">
                <div class="d-flex flex-row-reverse material-icons" align:"right" onclick="return confirm('Na pewno chcesz usunąć?')"><a href="{{route('delete_notification', ['id'=>$notification->id])}}">delete</a></div>
       <h5 class="card-body" ><img class="card-img-top img-thumbnail smollimg2" src="{{ asset('images/'.$notification->sale->figure['image']) }}" align="left" alt="">

       <ul class="list-group list-group-flush">
        <li class="list-group-item"><b>Nazwa: {{ $notification->sale->figure['title'] }}</b> </li>
        <li class="list-group-item jpy"><b>Cena: {{$notification->sale['price']}} jpy</b> </li>
        <?php
        $valueJPY = Currency::conv($from = 'JPY', $to = 'PLN', $value = 1, $decimals = 2);
        if ($valueJPY == 0){
          $valueJPY = 0.04;
        }?>
        <li class="list-group-item pln"><b>Cena: {{$notification->sale['price']*$valueJPY}} PLN</b> </li>
        <li class="list-group-item"><b>Data dodania: {{$notification->sale['created_at']->format('Y-m-d')}}</b> </li>
        <li class="list-group-item"><b>Sklep: <a href="{{$notification->sale->shop['link']}}" >{{$notification->sale->shop['name']}}</a></b> </li>
       </ul>
      </h5></li>
          @endforeach
        @endif
      </ul>
 </div>
 </div>
</div>

  <div class="my-4">
          <div class="card h-100">
            <h5 class="card-header mediumtext">Zaproszenia</h5>
            <div class="card-body my-4">
              @if(count($f_requests) > 0)
              @foreach($f_requests as $request)
              <ul class="list-group list-group-flush">
                  <li class="list-group-item">Użytkownik <a href="{{route('profile', ['name'=>$request->sender['name']])}}">{{$request->sender['name']}}</a> wysłał Ci zaproszenie do grona znajomych.
                  <a href="{{route('accept_friend', ['name'=>$request['id']])}}">Zaakceptuj /</a>
                  <a href="{{route('delete_friend', ['name'=>$request['id']])}}">Odrzuć.</a></h5></li>
              </ul>
              @endforeach
              @endif
            </div>
          </div>
  </div>

  </div>
</div>

@endsection
