<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GoFigure!</title>

    <link rel = "stylesheet"
       href = "https://storage.googleapis.com/code.getmdl.io/1.0.6/material.indigo-pink.min.css">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- Custom font styles -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>

    <style>

      .nav-link, .card-header {
      font-weight: 700;
      font-size: 20px;
      font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
      }

      .navbar-brand {
      color: #fed136;
      font-size: 30px;
      font-family: 'Kaushan Script', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
      }

      .obrazek {
        object-fit: none; /* Do not scale the image */
        object-position: top; /* Center the image within the element */
        height: 100%;
        max-width: 250px;
        margin-bottom: 1rem;
      }

      .smollimg {
        object-fit: none; /* Do not scale the image */
        object-position: top;
        width: 180px;
        height: 180px;
        margin-right: 50px;
      }

      .smollimg2 {
        object-fit: none; /* Do not scale the image */
        object-position: top;
        width: 120px;
        height: 120px;
        margin-right: 50px;
      }

      body {
          padding-top: 54px !important;
          font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
        }

        @media (min-width: 992px) {
          body {
            padding-top: 56px;
          }
        }

        .fat{
          font-weight: bold;
        }

        .smolltext{
          font-size: 10px;
        }

        .mediumtext{
          font-size: 15px;
        }







    </style>

    <script src = "https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js">
      </script>
      <link rel = "stylesheet"
         href = "https://fonts.googleapis.com/icon?family=Material+Icons">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top my-10">
      <div class="container">
        <a class="navbar-brand" href="/">GoFigure!</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link nav-link2" href="/">Nowinki ze świata kolekcjonerów
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/top10">Top 10</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/users">Użytkownicy</a>
            </li>
            @guest
                <li><a class="nav-link" href="{{ route('login') }}">{{ __('Zaloguj') }}</a></li>
                <li><a class="nav-link" href="{{ route('register') }}">{{ __('Rejestracja') }}</a></li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      @if(Auth::user()->permission_id == 1)
                      <a class="dropdown-item" href="{{route('admin')}}"
                         onclick="#">Administracja</a>
                      @endif

                      <a class="dropdown-item" href="{{route('profile', ['name'=>Auth::user()->name])}}"
                         onclick="#">
                          {{ __('Konto') }}
                          </a>
                      <a class="dropdown-item"  href="/notifications" onclick="#">
                      @if(Auth::user()->allnotifications() == 0)
                      <span>Powiadomienia</span>
                      @else
                      <span class = "mdl-badge" data-badge = "{{Auth::user()->allnotifications()}}" >Powiadomienia</span>
                      @endif
                      </a>

                          <a class="dropdown-item" href="/mailbox"
                             onclick="#"><span class = "mdl-badge" data-badge = "1" >Wiadomości</span></a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Wyloguj') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
          </ul>

        </div>
      </div>
    </nav>

    <div class= 'my-5'></div>


    <div class="container">

      <div class="row">

        <div class="col-lg-8">
          @yield('content')

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

          <!-- Currency converter -->
          <div class="card my-4 ">
            <h5 class="card-header  d-flex justify-content-center">Konwerter walut JPY/PLN </h5>
            <div class="card-body d-flex justify-content-center">

              <button class="btn btn-secondary" type="button" onclick="convert()" >Zmień walutę</button>

            </div>
          </div>

          <!-- Top 3 -->
          <div class="card my-4 ">
            <h5 class="card-header  d-flex justify-content-center"><img src="{{ asset('images/fire.png') }}">Najpopularniejsze! </h5>
            <div class="card-body">

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" src="{{ asset('images/'.App\Figure::top3()[0]['image']) }}" alt="First slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{ asset('images/'.App\Figure::top3()[1]['image']) }}" alt="Second slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{ asset('images/'.App\Figure::top3()[2]['image']) }}" alt="Third slide">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>

            </div>
          </div>

          <!-- Message to admin -->
          @guest
          @else
          <div class="card my-4 ">
            <h5 class="card-header  d-flex justify-content-center">Zgłoś problem</h5>
            <div class="card-body d-flex justify-content-center">

              <button type="button" class="btn btn-secondary my-4" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Wyślij zgłoszenie</button>

              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Wyślij wiadomość do administracji</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      {{ Form::open(array('route' => 'send_message')) }}
                        <div class="form-group">
                          <label for="message-text" class="col-form-label">Opisz swój problem możliwie jak najbardziej szczegółowo:</label>
                          {{ Form::textarea('body', null, ['class' => 'form-control', 'rows' => 3, 'maxlength'=>"400"]) }}
                          {{ Form::hidden('receiver', 'admin') }}
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
          @endguest

        </div>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white"> &copy; Klaudia Duda</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>



  </body>

  <script>
  $('.pln').hide()
  pln = false;
  function convert() {
    if (!pln){
      $('.jpy').hide()
      $('.pln').show()
      pln = true;
    } else {
      $('.jpy').show()
      $('.pln').hide()
      pln = false;
    }

  }
</script>

<script>
$('.option').hide()
option = false;
function options() {
  if (!option){
    $('.option').show()
    $('.option2').hide()
    option = true;
  } else {
    $('.option').hide()
    $('.option2').show()
    option = false;
  }

}
</script>

</html>
