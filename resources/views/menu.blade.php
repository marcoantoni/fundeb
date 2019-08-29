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
        <li><a href="badges.html">Components</a></li>
        <!-- Dropdown Trigger -->
        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Dropdown<i class="material-icons right">arrow_drop_down</i></a></li>
      </ul>
    </div>
  </nav>
