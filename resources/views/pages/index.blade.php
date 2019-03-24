@extends('layouts.app',['valueJPY' => $valueJPY])

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
  <h5 class="card-header">Szukaj: </h5>
  <div class="card-body">
      {{ Form::open(array('route' => 'search')) }}
    <div class="input-group">
      {{ Form::text('keyword', null, ['class' => 'form-control', 'maxlength'=>"20", 'placeholder'=>"Wpisz nazwę figurki..."]) }}
      <span class="input-group-btn">
      {{ Form::submit('Szukaj', ['class' => 'btn btn-secondary']) }}
      {{ Form::close() }}
      </span>
    </div>

  </div>
</div>

<div class="card my-4">
  <h5 class="card-header">Sortuj po: </h5>
  <div class="card-body">
      {{ Form::open(array('route' => 'sortby', 'method' => 'POST')) }}
    <div class="input-group">
      {{Form::select('what', array('id' => 'kolejność dodania', 'date' => 'data wydania', 'popularity' => 'popularność', 'title' => 'nazwa', 'price' => 'cena'), 'id', ['class' => 'form-control'])}}
      {{Form::select('how', array('asc' => 'rosnąco', 'desc' => 'malejąco'), 'desc', ['class' => 'form-control'])}}

      <span class="input-group-btn">
      {{ Form::submit('Sortuj', ['class' => 'btn btn-secondary']) }}
      {{ Form::close() }}
      </span>
    </div>

  </div>
</div>

<!-- Post Content -->
<?php
$valueJPY = Currency::conv($from = 'JPY', $to = 'PLN', $value = 1, $decimals = 2);
if ($valueJPY == 0){
  $valueJPY = 0.04;
}?>

@if(count($figures) > 0)
  @php
    $i = 0
  @endphp
  @foreach($figures as $figure)
    @if($i == 0)
      <div class="row">
    @endif
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100">
        <a href="{{route('show_figure', ['id'=>$figure->id])}}"><img class="card-img-top rounded obrazek" src="{{ asset('images/'.$figure['image']) }}" alt=""></a>
        <div class="card-body">
          <h5 class="card-title"><a href="{{route('show_figure', ['id'=>$figure->id])}}">{{ $figure['title'] }}</a></h5>

          <h5 class="jpy">{{ $figure->sales()->orderBy('price','asc')->get()[0]['price'] }} JPY</h5>
          <h5 class="pln">{{$figure->sales()->orderBy('price', 'asc')->get()[0]['price']*$valueJPY}} PLN</h5>

        </div>
        <div class="card-footer">
          <small class="text-muted"> Popularność: {{$figure['popularity']}}</small>
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


@endif


@endsection
