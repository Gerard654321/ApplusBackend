# Applus Backend

API construida con Laminas API Tools que expone los servicios de backend para la app de Applus (Norm Assist). La base de datos es PostgreSQL, alojada en Supabase.

## Requisitos

- PHP 8.1 u 8.2, con las extensiones `pdo_pgsql` y `pgsql` habilitadas.
- Composer 2.
- Acceso a la base de datos de Supabase (host, usuario, contraseña y puerto del pooler).

## Instalación

```bash
git clone
cd applus-backend
composer install
```

## Configuración de la base de datos

La conexión se arma en `config/autoload/global.php` a partir de variables de entorno (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_PORT`). Para desarrollo local, esos valores se completan en `config/autoload/local.php`, que no se sube al repositorio.

Para configurarlo:

```bash
cp config/autoload/local.php.dist config/autoload/local.php
```

Y completar ahí las credenciales reales del proyecto en Supabase:

```php
return [
    'db' => [
        'database' => 'postgres',
        'username' => 'usuario-del-pooler',
        'password' => 'contraseña',
        'hostname' => 'host-del-pooler.supabase.com',
        'port'     => '5432',
    ],
];
```

En producción (Render) estas mismas claves se inyectan como variables de entorno, sin necesidad de este archivo.

## Cómo correrlo

Con el servidor embebido de PHP:

```bash
composer serve
```

Esto levanta la aplicación en `http://localhost:8080`.

También se puede usar Docker:

```bash
docker-compose build
docker-compose up
```

## Módulos

- **Application**: módulo base del esqueleto de Laminas.
- **Business**: capa de acceso a datos y lógica de negocio (`AppUsuariosTable`, `DocumentsAppTable`, `UneApplusService`). No expone rutas propias, la consumen los módulos REST.
- **Applus_NormAssit**: expone los recursos REST de la API, entre ellos `ValidacionUsuario` (login, registro, consulta y actualización de usuarios).

La mayoría de las reglas de negocio (validación de login, registro, encriptación de contraseñas, permisos) se resuelven llamando a funciones del esquema `pkg_app_seguridad` en la base de datos, no en el código PHP.

## Documentación de la API

Con el modo desarrollo activado se puede navegar la documentación generada por API Tools desde el navegador:

```bash
composer development-enable
composer serve
```

Y entrando a `http://localhost:8080` se accede al dashboard con la documentación de cada endpoint.

## Pruebas y estilo de código

```bash
composer test # PHPUnit
composer cs-check # Verifica el estilo de código
composer cs-fix # Corrige el estilo de código automáticamente
```

## Despliegue

El despliegue en Render usa el `Dockerfile` de la raíz del proyecto (imagen autocontenida, instala dependencias en el build). La configuración de variables de entorno para producción está en `render.yaml`.

---

Backend diseñado por Gerardo Caldas de GCode Software 2026
