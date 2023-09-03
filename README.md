# Información del Intranet Asistencia

> Requisitos de la Aplicación

**Requisitos Funcionales:**

* Gestión de Administración:

    El administrador puede gestionar parámetros relacionados con áreas, asistencias, departamentos por usuario, perfiles, roles, servicios, estados, tiempos, tipos y usuarios. Para el caso de servicios se tiene como referencia los siguientes: Gestión, Break, Almuerzo, Baño y Otros. Y para el caso de tipos tenemos de Entrada y Salida.

    Puede agregar, editar y eliminar registros en cada una de las secciones mencionadas anteriormente.


* Gestión de Reportes:

    El administrador puede generar informes generales y específicos por fecha de inicio y fin.
	Los informes deben mostrar detalles de las actividades realizadas por los usuarios.
	Los informes deben ser exportables en formatos comunes como PDF o CSV.


* Roles y Permisos:

    Existen tres roles principales: Administrador, Ejecutivo y Trabajador.
	El Administrador tiene acceso completo a todas las funciones de la aplicación.
	El Rol Ejecutivo puede ver informes y la asistencia general solo con opción de agregar observación en el caso de requiera.
	Los Trabajadores solo pueden ver su propia asistencia y marcar asistencia.


* Registro de Asistencia:

    Todos los roles pueden marcar asistencia. Se utiliza un botón de "Gestión" el cual es un servicio para marcar asistencia, el cual permitirá iniciar su día laboral y permitir seleccionar otros servicios como "Almuerzo", "Baño" , "Break" u "Otros".
	No se permite marcar más de un servicio a la vez. Al marcar un servicio, el botón cambia de color indicando entrada o salida.


* Control de Sesión:

    Los usuarios deben iniciar sesión para acceder a la aplicación.
	La sesión debe expirar automáticamente después de un período de inactividad.


>  Requisitos No Funcionales:

* Seguridad:

    La aplicación debe tener medidas de seguridad basada en roles para el control de la información. Así como mantener las contraseñas de acceso bajo un cifrado.


* Usabilidad:

    La aplicación debe ser compatible con dispositivos móviles para facilitar el acceso desde cualquier lugar, así mismo para laptops, tablets y monitor.

* Disponibilidad:

    La aplicación debe estar disponible y accesible en todo momento, con un tiempo de inactividad mínimo planificado para el mantenimiento.

* Integración:

    La aplicación debe admitir la integración con sistemas existentes si es necesario.


> Diseño Físico de la BD

![Database](https://github.com/bryan-arrivasplata-rojas/intranet_asistencia_restapi_v1.0_2023/assets/97413969/83344d35-2746-4bef-8546-d399b443bf53)

> Arquitectura de la Aplicación

![arquitectura](https://github.com/bryan-arrivasplata-rojas/intranet_asistencia_restapi_v1.0_2023/assets/97413969/94cf4bf7-0e08-4d08-81d2-bcfbf6f415a1)

# Implementación

- El proyecto es "Intranet_asistencia", deberan tener configurado el RestApi y Backend en servidor local o web
- Tener listo la base de datos intranet_asistencia de la ruta "backup/intraner_asistencia.sql"
- Configurar en base a sus rutas especificas los archivos .env del ResApi y Backend

# Cuenta de acceso

- admin/123456789
- executive/123456789
- worker/123456789

# Vistas

> Login

![1app](https://github.com/bryan-arrivasplata-rojas/intranet_asistencia_restapi_v1.0_2023/assets/97413969/989c1b30-9a69-48f0-8303-a96a6aae89e6)

> admin

![2app](https://github.com/bryan-arrivasplata-rojas/intranet_asistencia_restapi_v1.0_2023/assets/97413969/4a85e2d9-4d66-451e-a446-9bb89adcb914)
![2appadmin](https://github.com/bryan-arrivasplata-rojas/intranet_asistencia_restapi_v1.0_2023/assets/97413969/ba9f1584-df00-4050-8a78-8ba85f96c04b)

> executive

![3appexecutive](https://github.com/bryan-arrivasplata-rojas/intranet_asistencia_restapi_v1.0_2023/assets/97413969/e5c17f17-88ca-4625-9940-5af31928810f)

> worker

![4appworker](https://github.com/bryan-arrivasplata-rojas/intranet_asistencia_restapi_v1.0_2023/assets/97413969/8ba938a1-1b5c-45e2-885e-c0e0824fcc88)
![5appworker](https://github.com/bryan-arrivasplata-rojas/intranet_asistencia_restapi_v1.0_2023/assets/97413969/dbb75a82-01bf-4f99-8a54-59408c8c56ba)

# Información

website: https://bryanarrivasplata.com/
intranet_asistencia (backend): https://bryanarrivasplata.com/intranet_asistencia/backend/
intranet_asistencia (restapi): https://bryanarrivasplata.com/intranet_asistencia/restapi/

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

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
