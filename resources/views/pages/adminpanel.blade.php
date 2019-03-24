@extends('layouts.app')

@section('content')

<div class="card my-4">
  <div class="card-body">

    <nav>
  <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Zgłoszeni użytkownicy</a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Zgłoszone komentarze</a>
    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Wszystkie komentarze</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active mx-2" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

    <ul class="list-group list-group-flush">
    @if(count($reports) > 0)

      @foreach($reports as $report)

          <li class="media my-4">
            <img class="d-flex mr-3 rounded-circle" src="/images/avatars/{{$report->user->avatar}}" height="100" width="100" alt="">
            <div class="media-body">
              <h5 class="mt-0 mb-1 fat">Użytkownik: {{ $report->user['name'] }}</h5>
              {{$report['body']}}
              <div class= "d-flex flex-row-reverse smolltext">Wysłano: {{$report['created_at']}}</div>
              <a href="{{route('ban_user', ['id'=>$report->user->id])}}" class="btn btn-secondary my-4" type="button" onclick="#" >Zbanuj</a>
              <a href="{{route('delete_report', ['id'=>$report->id])}}" class="btn btn-secondary my-4" type="button" onclick="#" >Usuń zgłoszenie</a>
            </div>

          </li>

      @endforeach
    @endif
    </ul>


          </div>

  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    <ul class="list-group list-group-flush">
    @if(count($reported_comments) > 0)

      @foreach($reported_comments as $comment)

          <li class="media my-4">
            <img class="d-flex mr-3 rounded-circle" src="/images/avatars/{{$comment->user->avatar}}" height="100" width="100" alt="">
            <div class="media-body">
              <h5 class="mt-0 mb-1 fat">Użytkownik: {{ $comment->user['name'] }}</h5>
              {{$comment['body']}}
              <div class= "d-flex flex-row-reverse smolltext">Wysłano: {{$comment['created_at']}}</div>
              <a href="{{route('delete_comment', ['id'=>$comment->id])}}" class="btn btn-secondary my-4" type="button" onclick="#" >Usuń komentarz</a>
              <a href="{{route('delete_report_com', ['id'=>$comment->id])}}" class="btn btn-secondary my-4" type="button" onclick="#" >Usuń zgłoszenie</a>
              <a href="{{route('ban_user', ['id'=>$comment->user->id])}}" class="btn btn-secondary my-4" type="button" onclick="#" >Zbanuj użytkownika</a>
            </div>
          </li>
      @endforeach
    @endif
  </ul></div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

    <ul class="list-group list-group-flush">
    @if(count($comments) > 0)

      @foreach($comments as $comm)

    <li class="media my-4">
      <img class="d-flex mr-3 rounded-circle" src="/images/avatars/{{$comm->user->avatar}}" height="100" width="100" alt="">
      <div class="media-body">
        <h5 class="mt-0 mb-1 fat">Użytkownik: {{ $comm->user['name'] }}</h5>
        {{$comm['body']}}
        <div class= "d-flex flex-row-reverse smolltext">Wysłano: {{$comm['created_at']}}</div>
        <a href="{{route('delete_comment', ['id'=>$comment->id])}}" class="btn btn-secondary my-4" type="button" onclick="#" >Usuń komentarz</a>
        <a href="{{route('ban_user', ['id'=>$comment->user->id])}}" class="btn btn-secondary my-4" type="button" onclick="#" >Zbanuj użytkownika</a>
      </div>
    </li>

    @endforeach
  @endif
</ul></div>

  </div>
</div>

  </div>



@endsection
