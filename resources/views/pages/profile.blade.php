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
<h3 class="card-header"> {{$user['name']}} </h3>
<div class="card-body">

<div class="d-flex flex-row-reverse">
@if(($user['name'] == Auth::user()->name) and (Auth::user()->banned == 0))
<button class="btn btn-secondary option2" type="button" onclick="options()" >Wyświetl opcje</button>
<button class="btn btn-secondary option" type="button" onclick="options()" >Ukryj opcje</button>

@elseif ($user['name'] == Auth::user()->name)
<div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×</button>
                <span class="glyphicon glyphicon-record"></span> <strong>Ostrzeżenie</strong>
                <hr class="message-inner-separator">
                <p>
                    Zostałeś zbanowany. Nie możesz edytować swojego profilu, przeprowadzać interakcji z innymi użytkownikami oraz komentować ogłoszeń.</p>
            </div>

@endif
</div>


<div class="d-flex justify-content-center"><img src="/images/avatars/{{$user->avatar}}" height="100" width="100" style="border-radius:50%;" ></div>
<div class="option">

<div class="d-flex justify-content-center ">
<button type="button" class="d-flex flex-row-reverse btn btn-secondary my-4 mx-2" data-toggle="modal" data-target="#avatarModal" data-whatever="@mdo">Zmień avatar</button>
</div>
</div>

<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="avatarModalLabel">Zmień avatar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form enctype="multipart/form-data" action="/profile/changeav" method="POST">
          <div class="form-group">
            <label for="message-text" class="col-form-label">JPEG (.jpg), GIF (.gif) lub PNG (.png); 1280x1280 (500 kB) maximum; 80x80 minimum.</label>
            <input type="file" name="avatar">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
        <input type="submit" class="btn btn-primary"></form>
      </div>
    </div>
  </div>
</div>

<div class="d-flex justify-content-center">
@if(($user['name'] != Auth::user()->name) and (Auth::user()->banned == 0))

<button type="button" class="btn btn-secondary my-4" data-toggle="modal" data-target="#messageModal" data-whatever="@mdo">Wyślij wiadomość</button>

<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="messageModalLabel">Wyślij wiadomość do {{$user['name']}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        {{ Form::open(array('route' => 'send_message')) }}
          <div class="form-group">
            <label for="message-text" class="col-form-label">Treść:</label>
            {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3, 'maxlength'=>"400"]) }}
            {{ Form::hidden('receiver', $user['name']) }}
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
        {{ Form::submit('Wyślij', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
@if($user['permission_id'] == 2)
@if($requested == 0)
<a href="{{route('add_friend', ['id'=>$user->id])}}" class="btn btn-secondary my-4" type="button" onclick="#" >Dodaj do znajomych</a>
@elseif($requested == 1)
<a href="#" class="btn btn-secondary my-4" type="button" onclick="#" >Zaproszenie wysłane</a>
@elseif($requested == 2)
<a href="{{route('delete_friend', ['id'=>$user->id])}}" class="btn btn-secondary my-4" type="button" onclick="return confirm('Na pewno chcesz usunąć?')" >Usuń ze znajomych</a>
@endif

<button type="button" class="btn btn-secondary my-4" data-toggle="modal" data-target="#reportModal" data-whatever="@mdo">Zgłoś użytkownika</button>

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reportModalLabel">Zgłoś użytkownika {{$user['name']}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        {{ Form::open(array('route' => 'report_user')) }}
          <div class="form-group">
            <label for="message-text" class="col-form-label">Opisz powód zgłoszenia:</label>
            {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3, 'maxlength'=>"400"]) }}
            {{ Form::hidden('id', $user['id']) }}
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
        {{ Form::submit('Wyślij', ['class' => 'btn btn-primary']) }}
        {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
@endif
@endif
</div>

<div class="my-4">
    <div class="card h-100">
      <h5 class="card-header mediumtext">Opis</h5>
      <div class="card-body my-4">{{$user['description']}}
      </div>
    </div>
  <div class="option">
    <div class="d-flex flex-row-reverse ">
    <button type="button" class="d-flex flex-row-reverse btn btn-secondary my-4 mx-2" data-toggle="modal" data-target="#descriptionModal" data-whatever="@mdo">Edytuj opis</button>
    </div>

    <div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="descriptionModalLabel">Edytuj opis</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            {{ Form::open(array('route' => 'edit_description')) }}
              <div class="form-group">
                {{ Form::textarea('description', $user['description'], ['class' => 'form-control', 'rows' => 3, 'maxlength'=>"400"]) }}
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
            {{ Form::submit('Wyślij', ['class' => 'btn btn-primary']) }}
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>

    </div>
  </div>

<div class="my-4">
    <div class="card h-100">
      <h5 class="card-header mediumtext">Kolekcja</h5>
      <div class="card-body my-4">
        @foreach($user->myfigures as $figure)
        <a href="{{route('show_figure', ['id'=>$figure->figure->id])}}" onclick="#"><img src="/images/{{$figure->figure['image']}}" height="20%" width="20%"></a>
        @endforeach
      </div>
    </div>
    <div class="option">

      <div class="d-flex flex-row-reverse ">
      <button type="button" class="d-flex flex-row-reverse btn btn-secondary my-4 mx-2" data-toggle="modal" data-target="#collectionModal" data-whatever="@mdo">Zarządzaj kolekcją</button>
      </div>

      <div class="modal fade" id="collectionModal" tabindex="-1" role="dialog" aria-labelledby="collectionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="collectionModalLabel">Kliknij na przedmioty które chcesz usunąć z kolekcji</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              @foreach($user->myfigures as $figure)
              <a href="{{route('delete_from_collection', ['id'=>$figure->id])}}" - czy na pewno chcesz usunąć onclick="return confirm('Na pewno chcesz usunąć?')"><img src="/images/{{$figure->figure['image']}}" height="20%" width="20%"></a>
              @endforeach

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
            </div>
          </div>
        </div>
      </div>



        </div>
    </div>

<div class="my-4">
        <div class="card h-100">
          <h5 class="card-header mediumtext">Znajomi</h5>
          <div class="card-body my-4">
            @foreach($user->friends() as $friend)
            <a href="{{route('profile', ['name'=>$friend->name])}}" onclick="#"><img src="/images/avatars/{{$friend->avatar}}" height="100" width="100" style="border-radius:50%;" >{{$friend->name}}</a>
            @endforeach
          </div>
        </div>
</div>

  </div>
</div>

@endsection
