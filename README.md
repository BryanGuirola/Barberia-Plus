# Barbería Plus

**Barbería Plus** es un sistema de gestión de citas desarrollado en **Laravel 10**, diseñado para optimizar la administración de citas en peluquerías y barberías. Permite a los clientes agendar, cancelar o reprogramar citas de forma sencilla, mientras que el personal (administradores y encargados) gestiona servicios, horarios, usuarios y reportes de manera eficiente.

---

## Características principales

- **Gestión de citas en línea:** Los clientes pueden agendar, cancelar o modificar citas según disponibilidad.
- **Módulo administrativo:** El administrador gestiona servicios, usuarios, horarios y genera reportes con filtros avanzados y exportación a PDF.
- **Panel para encargados:** Visualización y gestión de citas diarias, agendado manual.
- **Reportes con gráficos:** Estadísticas de citas por estado mediante **Chart.js**.
- **Seguridad:** Control de acceso por roles (admin, encargado, cliente), cambio obligatorio de contraseña en primer login.
- **Diseño responsivo:** Optimizado para computadoras, tablets y móviles.
- **Automatización:** Scheduler que marca automáticamente las citas vencidas como olvidadas.

---

## Tecnologías utilizadas

- Laravel 10
- Bootstrap 5
- Chart.js
- DomPDF (PDFs)
- MySQL
- JavaScript (vanilla + Fetch API)

---

## Limitaciones actuales

- No incluye pagos en línea.
- No soporta múltiples sucursales (por ahora).
- No implementa notificaciones por correo o WhatsApp (se podría extender).

---

## Requisitos

- PHP >= 8.1
- Composer
- MySQL o MariaDB
- Node.js + NPM (para compilar assets si es necesario)

---

## Instalación y configuración

Sigue los siguientes pasos para instalar y ejecutar el proyecto en tu entorno local.

### 1. Clonar el repositorio
git clone https://github.com/tu-usuario/barberia-plus.git
cd barberia-plus
### 2. Instalar dependencias de PHP
composer install
### 3. Configurar el archivo de entorno
cp .env.example .env
Edita el archivo .env para configurar los datos de conexión de la base de datos y otras variables necesarias.

### 4. Generar la clave de la aplicación
php artisan key:generate
### 5. Ejecutar migraciones y seeders
php artisan migrate --seed
### 6. (Opcional) Instalar dependencias de Node y compilar assets
npm install
npm run build
### 7. Iniciar el servidor de desarrollo(yo utilice XAMP)
php artisan serve
Luego accede en tu navegador a http://localhost:8000.

ademas de esto tengo este sitio publicado puedes verlo en este link :https://barberia-plus.onrender.com/ 


Contacto
Si tienes sugerencias, encuentras errores o deseas contribuir al proyecto, puedes abrir un issue o enviar un pull request en este repositorio.
También puedes contactarme directamente a través de mi perfil de GitHub.

Tambien destacar que en este proyecto participo aparte de mi persona:
Aldo Sandoval
Cristian Calzadilla 
Gerardo Mendez


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
