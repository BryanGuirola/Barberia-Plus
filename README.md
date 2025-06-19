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


## Contacto
Si tienes sugerencias, encuentras errores o deseas contribuir al proyecto, puedes abrir un issue o enviar un pull request en este repositorio.
También puedes contactarme directamente a través de mi perfil de GitHub.

## Credits
Tambien destacar que en este proyecto participo aparte de mi persona:
Aldo Sandoval
Cristian Calzadilla
Gerardo Mendez

------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
# Barbería Plus
Barbería Plus is an appointment management system developed with Laravel 10, designed to optimize the management of appointments in hair salons and barber shops. It allows clients to easily schedule, cancel, or reschedule appointments, while staff (administrators and managers) efficiently manage services, schedules, users, and reports.

## Main Features
Online appointment management: Clients can schedule, cancel, or modify appointments based on availability.
Admin module: Manage services, users, schedules, and generate reports with advanced filters and PDF export.
Manager panel: View and manage daily appointments, manually schedule new ones.
Reports with charts: Appointment statistics by status using Chart.js.
Security: Role-based access control (admin, manager, client) with mandatory password change on first login.
Responsive design: Optimized for desktop, tablet, and mobile devices.
Automation: Scheduler automatically marks overdue appointments as forgotten.

## Technologies Used
Laravel 10
Bootstrap 5
Chart.js
DomPDF (PDF generation)
MySQL
JavaScript (vanilla + Fetch API)

##Current Limitations
No online payment support.
No support for multiple branches (yet).
No email or WhatsApp notifications implemented (could be extended in the future).

## Requirements
PHP >= 8.1
Composer
MySQL or MariaDB
Node.js + NPM (for compiling assets if necessary)

## Installation and Setup
Clone the repository: git clone https://github.com/your-username/barberia-plus.git and cd barberia-plus
Install PHP dependencies: composer install
Set up the environment file: copy .env.example to .env and configure your environment variables (database connection, etc.)
Generate the application key: php artisan key:generate
Run migrations and seeders: php artisan migrate --seed
(Optional) Install Node dependencies and compile assets: npm install and npm run build
Start the development server (XAMPP was used in this case): php artisan serve
Open your browser and go to: http://localhost:8000

## Contact
If you have suggestions, encounter any bugs, or would like to contribute to the project, feel free to open an issue or submit a pull request on this repository.
You can also contact me directly through my GitHub profile.

## Credits
This project was developed by myself, with contributions from:

Aldo Sandoval
Cristian Calzadilla
Gerardo Mendez
