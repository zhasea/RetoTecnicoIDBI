
# RETO TECNICO




## Requisitos
-Lenguaje/Framework: PHP (8.0 o superior) / Laravel (8.0 o superior)

-Base de datos: MySQL (8.0 o superior) o MariaDB (10.5 o superior)

-Composer

-MySQL
## Installation

1.- Instalacion de las dependencias

```bash
  composer install
```
2.- Configuracion del archivo .env

```bash
  cd .env.example.env
```
3.-Generar la clave de la aplicacion
```bash
  php artisan key:generate
```  
4.-Configuracion de la base de datos, editando el archivo .env para la confiracion de los parametros de conexion
```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_de_la_base_de_datos
    DB_USERNAME=usuario
    DB_PASSWORD=contraseña
```  
5.- Ejecucion de migraciones
```bash
    php artisan migrate
```  
6.- Ejecucion de los seeders
```bash
    php artisan db:seed
```  
7.- Acceso directo
```bash
    php artisan storage:link
```  
8.- Generacion del key de JWT
```bash
    php artisan jwt:secret
```  
9.- Ejecucion del servidor en desarrollo
```bash
    php artisan serve
```  
Esto iniciará el servidor en http://localhost:8000 o el puerto que se indique en la terminal.
De tener problemas puede guiarse de las variables de .env.example



## Diagrama de la base de datos
A continuacion, se muestra el diagrama de la base de datos utilizando en este proyecto:
![Diagrama de la Base de Datos](https://i.postimg.cc/W4QM3427/ERD-de-Hockey.png)
## Documentación Swagger
En la siguiente ruta http://localhost:8000/docs/api  se podra encontrar a documentacion usando Swagger
## Decisiones Técnicas
1.- Se normalizo la estructura de la tabla usuarios para tener una tabla independiente para los roles. Ademas, esto puede ayudar si es que se necesita agregar más roles en un futuro (para el momento se maneja el 1 para Admin y 2 para Vendedor esto se observa en los seeders).

2.- Se normalizo la estructura de la tabla sales, para tener una columna de customers para en futuro sacar nuevas funcionalidades como reportes o KPIS de estos.

3.- El servicio de la reporteria esta regresando tanto un arreglo en json de la data como la ruta del archivo excel
