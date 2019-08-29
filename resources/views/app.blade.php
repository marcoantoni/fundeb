<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>@yield('title')</title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://materializecss.com/dist/css/materialize.min.css"  media="screen,projection"/>
    <link href="https://materializecss.com/templates/starter-template/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <style>
      body {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
      }
      main {
        flex: 1 0 auto;
      }
    </style>
  </head>
  <body>
    <header>
      <!-- Dropdown Structure -->
      <ul id="dropdown1" class="dropdown-content">
        <li><a href="#!">one</a></li>
        <li><a href="#!">two</a></li>
        <li class="divider"></li>
        <li><a href="#!">three</a></li>
      </ul>
      <nav class="light-blue lighten-1" role="navigation">
        <div class="nav-wrapper container">
          <!-- <a href="#!" class="brand-logo">Logo</a>-->
          <ul class="left hide-on-med-and-down">
            <li><a href="{{ URL::route('matricula.index') }}">Matrículas</a></li>
            <li><a href="{{ URL::route('despesa.index') }}">Acompanhar gastos</a></li>
            <!-- Dropdown Trigger -->
            <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Dropdown<i class="material-icons right">arrow_drop_down</i></a></li>
          </ul>
        </div>
      </nav>
    </header>


    <!--<div class="section no-pad-bot" id="index-banner">
    <div class="container">
    <br><br>
    <h1 class="header center orange-text">Starter Template</h1>
    <div class="row center">
    <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
    </div>
    <div class="row center">
    <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light orange">Get Started</a>
    </div>
    <br><br>

    </div>
    </div>-->


    <main class="container">
      <div class="section">
      @yield('content')
      </div>
      <br><br>
    </main>

    <footer class="page-footer light-blue">
      <div class="container">
        <div class="row">
          <div class="col l6 s12">
            <h5 class="white-text">Company Bio</h5>
            <p class="grey-text text-lighten-4">We are a team of college students working on this project like it's our full time job. Any amount would help support and continue development on this project and is greatly appreciated.</p>
          </div>
          <div class="col l3 s12">
            <h5 class="white-text">Settings</h5>
            <ul>
            <li><a class="white-text" href="#!">Link 1</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
            </ul>
          </div>
          <div class="col l3 s12">
            <h5 class="white-text">Connect</h5>
            <ul>
              <li><a class="white-text" href="#!">Link 1</a></li>
              <li><a class="white-text" href="#!">Link 2</a></li>
              <li><a class="white-text" href="#!">Link 3</a></li>
              <li><a class="white-text" href="#!">Link 4</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-copyright">
        <div class="container">
          Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
        </div>
      </div>
    </footer>
    <!--  Scripts-->
    <script type="text/javascript" src="https://materializecss.com/bin/materialize.js"></script>
    <script src="js/init.js"></script>
    <script>
      $(document).ready(function() {
        $(".dropdown-trigger").dropdown();
      });
    </script>
  </body>
</html>