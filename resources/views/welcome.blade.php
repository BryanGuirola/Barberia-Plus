<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barbería Plus</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS Animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Google Fonts + Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>



    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3ECE7;
            color: #2E2E2E;
        }

        .navbar {
            background-color: #2E2E2E;
        }

        .nav-link,
        .navbar-brand {
            color: #fff !important;
        }

        .hero {

            height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .btn-primary {
            background-color: #B06C49;
            border: none;
        }

        .btn-primary:hover {
            background-color: #D4A373;
        }

        .feature-icon {
            font-size: 2rem;
            color: #B06C49;
        }

        footer {
            background-color: #2E2E2E;
            color: #ffffff;
        }

        .card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('images\favicon-32x32.png') }}" alt="Logo" width="32" height="32" class="me-2">
                <span class="fw-bold text-white">Barbería Plus</span>
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-white">
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="/login">Iniciar sesión</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Registrarse</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <header class="hero" style="background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)), url('{{ asset('images/landingfondo.png') }}') no-repeat center center / cover;">
        <div class="container">
            <h1 class="display-4 fw-bold" data-aos="fade-down">Reserva tu corte perfecto en segundos</h1>
            <p class="lead mt-3" data-aos="fade-up" data-aos-delay="150">Sin llamadas, sin complicaciones. Todo desde tu móvil.</p>
            <a href="/register" class="btn btn-primary btn-lg mt-4" data-aos="zoom-in" data-aos-delay="300">Agendar cita</a>
        </div>
    </header>

    <!-- Beneficios -->
    <section class="py-5 text-center bg-light">
        <div class="container">
            <h2 class="mb-5" data-aos="fade-up">¿Por qué elegir Barbería Plus?</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-right">
                    <i class="fas fa-mobile-alt feature-icon mb-3"></i>
                    <h5>Fácil de usar</h5>
                    <p>Interfaz moderna, clara y accesible desde cualquier dispositivo.</p>
                </div>
                <div class="col-md-4" data-aos="fade-up">
                    <i class="fas fa-calendar-check feature-icon mb-3"></i>
                    <h5>Citas online</h5>
                    <p>Agenda tu cita sin hacer una sola llamada.</p>
                </div>
                <div class="col-md-4" data-aos="fade-left">
                    <i class="fas fa-user-tie feature-icon mb-3"></i>
                    <h5>Barberos profesionales</h5>
                    <p>Solo trabajamos con expertos del estilo masculino.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section id="servicios" class="py-5 bg-white">
        <div class="container text-center">
            <h2 class="mb-5" data-aos="fade-up">Nuestros Servicios</h2>
            <div class="row g-4">
                <div class="col-md-3" data-aos="zoom-in">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-cut feature-icon mb-3"></i>
                            <h5 class="card-title">Corte</h5>
                            <p>Desde estilos clásicos hasta tendencias modernas.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-user + fa-hammer feature-icon mb-3"></i>
                            <h5 class="card-title">Afeitado</h5>
                            <p>Experiencia premium con toallas calientes y aceites.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-paint-brush feature-icon mb-3"></i>
                            <h5 class="card-title">Tinte</h5>
                            <p>Coloración de barba y cabello con productos de calidad.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-spa feature-icon mb-3"></i>
                            <h5 class="card-title">Tratamientos</h5>
                            <p>Masajes capilares, exfoliación y más.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5 bg-dark text-white text-center">
        <div class="container" data-aos="fade-up">
            <h2 class="mb-4">¿Listo para agendar tu próxima cita?</h2>
            <a href="/register" class="btn btn-primary btn-lg">Regístrate ahora</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-1">© 2025 Barbería Plus. Todos los derechos reservados.</p>
            <a href="#" class="text-decoration-none text-white">Política de privacidad</a> |
            <a href="#" class="text-decoration-none text-white">Términos y condiciones</a>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>

</body>

</html>