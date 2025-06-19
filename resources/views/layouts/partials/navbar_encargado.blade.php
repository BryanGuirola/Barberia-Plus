<nav class="navbar navbar-expand-lg" style="background-color: #2E2E2E;">
    <div class="container">
        <a class="navbar-brand text-white d-flex align-items-center" href="{{ route('personal.dashboard') }}">
            <img src="{{ asset('images/favicon-32x32.png') }}" alt="Logo" width="32" height="32" class="me-2">
            Barbería Plus
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavEncargado">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavEncargado">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('personal.citas.index', ['fecha' => now()->toDateString()]) }}">Citas</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('personal.citas.manual') }}">Agendar Manual</a></li>

                {{-- Nuevo enlace --}}
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('personal.servicios') }}">Servicios</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <form method="POST" action="{{ route('logout') }}"> @csrf
                                <button class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
