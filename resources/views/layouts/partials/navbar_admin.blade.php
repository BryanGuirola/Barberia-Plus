<nav class="navbar navbar-expand-lg" style="background-color: #2E2E2E;">
    <div class="container"> <a class="navbar-brand text-white d-flex align-items-center" href="{{ route('admin.dashboard') }}"> <img src="{{ asset('images/favicon-32x32.png') }}" alt="Logo" width="32" height="32" class="me-2"> Barbería Plus </a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAdmin"> <span class="navbar-toggler-icon"></span> </button>
        <div class="collapse navbar-collapse" id="navbarNavAdmin">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.servicios.index') }}">Servicios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.usuarios.index') }}">Encargados</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.horarios.index') }}">Horarios</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.citas.manual') }}">Agendar Cita</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.reportes.citas') }}">Reportes</a></li>
                <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"> {{ Auth::user()->name }} </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="{{ route('logout') }}"> @csrf <button class="dropdown-item">Cerrar sesión</button> </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>