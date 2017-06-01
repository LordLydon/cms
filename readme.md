# CMS

## Requerimientos

- PHP >= 5.6.4
- Extensiones PHP:
    - OpenSSL
    - PDO
    - Mbstring
    - Tokenizer
    - XML
- Servicio SMTP
- Base de datos MySQL

## Instalación

1. Clonar repositorio
2. Instalar dependencias con el comando `composer install`
3. Configuración de variables de ambiente  
    - Copiar `.env.example` con el nombre `.env`
    - Cambiar variables de acceso de base de datos, servidor SMTP e información de la app.
4. Crear tablas en la base de datos con el comando `php artisan migrate --seed`, que crea un usuario administrador con login `admin@admin.com` y password `admin` y una pagina inicial por defecto.
5. Generar la llave de codificación de la app con el comando `php artisan key:generate` 
 **Nota:** Se recomienda ir a la administración de usuarios para cambiar el email y la contraseña del usuario!
