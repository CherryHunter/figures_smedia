<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>GoFigure!</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>

    <style>

      .nav-link, .card-header {
      font-weight: 700;
      font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
      }

      .navbar-brand {
      color: #fed136;
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

      body {
          padding-top: 54px !important;
        }

        @media (min-width: 992px) {
          body {
            padding-top: 56px;
          }
        }
      }

    </style>
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="/">GoFigure!</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link nav-link2" href="/">Figurki
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/top10">Top 10</a>
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
                      <a class="dropdown-item" href="#"
                         onclick="#">
                          {{ __('Konto') }}
                      </a>
                      <a class="dropdown-item" href="/notifications"
                         onclick="#">
                          {{ __('Powiadomienia') }}
                      </a>
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


    <div class="container">

      <div class="row">

        <div class="col-lg-8">
          @yield('content')

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

          <!-- Currency converter -->
          <div class="card my-4 ">
            <h5 class="card-header">Konwerter walut JPY/PLN </h5>
            <div class="card-body">

              <button class="btn btn-secondary" type="button" onclick="convert()" >Zmień walutę</button>

            </div>
          </div>

          <!-- Side Widget -->
          <div class="card my-4">
            <h5 class="card-header">Chat</h5>
            <div class="card-body">
              Tu będzie chat
            </div>
          </div>

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

    }</script>

  </body>

</html>
