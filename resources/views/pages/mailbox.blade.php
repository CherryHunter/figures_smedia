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
  <div class="card-body">

    <nav>
  <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Wyślij wiadomość</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Odebrane</a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Wysłane</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active mx-2" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

            {{ Form::open(array('route' => 'send_message')) }}
              <div class="form-group">
                <label for="recipient-name" class="col-form-label my-4 mx-2">Do:</label>
              {{ Form::text('receiver') }}
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label mx-2">Treść:</label>
              {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 5, 'maxlength'=>"400"]) }}
              </div>
              {{ Form::submit('Wyślij', ['class' => 'btn btn-primary']) }}
              {{ Form::close() }}


          </div>

  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    <ul class="list-group list-group-flush">
    @if(count($received) > 0)

      @foreach($received as $message)

          <li class="media my-4">
            <img class="d-flex mr-3 rounded-circle" src="/images/avatars/{{$message->sender->avatar}}" height="100" width="100" alt="">
            <div class="media-body">
              <h5 class="mt-0 mb-1 fat">Od: {{ $message->sender['name'] }}</h5>
              {{$message['body']}}
              <div class= "d-flex flex-row-reverse smolltext">Wysłano: {{$message['created_at']}}</div>
              @if(Auth::check())
              <div class="d-flex flex-row-reverse smolltext material-icons"><a href="{{route('delete_received', ['id'=>$message->id])}}">delete</a></div>
              @endif
            </div>
          </li>

      @endforeach
    @endif
  </ul></div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

    <ul class="list-group list-group-flush">
    @if(count($sent) > 0)

      @foreach($sent as $message)

    <li class="media my-4">
      <img class="d-flex mr-3 rounded-circle" src="/images/avatars/{{$message->receiver->avatar}}" height="100" width="100" alt="">
      <div class="media-body">
        <h5 class="mt-0 mb-1 fat">Do: {{ $message->receiver['name'] }}</h5>
        {{$message['body']}}
        <div class= "d-flex flex-row-reverse smolltext">Wysłano: {{$message['created_at']}}</div>
        @if(Auth::check())
        <div class="d-flex flex-row-reverse smolltext material-icons"><a href="{{route('delete_sent', ['id'=>$message['id']])}}">delete</a></div>
        @endif
      </div>
    </li>

    @endforeach
  @endif
</ul></div>

  </div>
</div>

  </div>


@endsection
