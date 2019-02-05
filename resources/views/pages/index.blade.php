@extends('layouts.app',['valueJPY' => $valueJPY])

@section('content')

<div class="card my-4">
  <div class="card-body">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-secondary" type="button">Go!</button>
      </span>
    </div>
  </div>
</div>

<!-- Post Content -->

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
        <a href="#"><img class="card-img-top rounded obrazek" src="{{ asset('images/'.$figure['image']) }}" alt=""></a>
        <div class="card-body">
          <h5 class="card-title"><a href="#">{{ $figure['title'] }}</a></h5>

          <h5 class="jpy">{{ $figure->sales[0]['price'] }} JPY</h5>

          <?php $valueJPY = Currency::conv($from = 'JPY', $to = 'PLN', $value = 1, $decimals = 2);?>
          <h5 class="pln">{{$figure->sales[0]['price']*$valueJPY}} PLN</h5>

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
<div class="pagination-centered">
  {!! $figures->links(); !!}
</div>
@endsection
