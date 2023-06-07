<h6 class="navbar-heading text-muted">
  @if(auth()->user()->role == 'admin')
    Gestion
  @else
    menu
  @endif
</h6>
 <!-- Navigation -->
 <ul class="navbar-nav">
        @include('includes.panel.menu.'.auth()->user()->role)
     
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
              <i class="fas fa-sign-in-alt"></i> Cerrar session
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: none;" id="formLogout">
              @csrf
            </form>
          </li>
        
      @if(auth()->user()->role == 'admin')
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">Reportes</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/reportes/citas/line') }}">
              <i class="ni ni-books text-default"></i> Citas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/reportes/doctors/colum') }}">
              <i class="ni ni-chart-bar-32 text-warning"></i> Desempeños medicos
            </a>
          </li>
          
        </ul>
      @endif