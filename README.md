# HOLA PRUEBA NIVEL
## Especificaciones
### Technical Requirements:
* Language: PHP 7.2
* Webserver: PHP native
* Package manager: composer
* PHP Framework: not required
* Persistence layer: files or database
* Coding Style: PSR-2
* Tests: PHPUnit

### Extra points:
* PHP Framework: Symfony 3.4
* Environment: Docker
* Persistence layer: MySql + Doctrine + Doctrine Migrations
* Tests: PHPUnit + code coverage >= 80%
* Checks: PHPMD, PHP_CodeSniffer

## Objetivos:
1. T-1 Project Init
*  create a user entity with this fields:
- name
- username
- password
- roles (possible values: ADMIN, PAGE_1, PAGE_2)
*  create a user with this values:
- name: Admin
- username: admin
- password: adminpassword
- roles: ADMIN
2. T-2 CRUD RESTful Api
*  create a CRUD RESTful API for the user entity. The entry point has to be secured
with basic HTTP Authentication. Only users with ADMIN role can CREATE a new
user, EDIT another user or DELETE another user.
3. T-3 /page/1 and login
*  create a webpage with this URL /page/1 with this content: “Hello 1 {{ user.name }}”
*  create a login page
PHP - Developer Test
*  only logged users with ADMIN or PAGE_1 role can view this page
*  if the user is not logged-in the page MUST redirect with a HTTP response code 302
to the login page
*  if the user is logged-in but do not have the appropriate role an error page MUST be
shown with a 403 HTTP response code
4. T-4 /page/2 and login
*  create a webpage with this URL /page/2 with this content: “Hello 2 {{ user.name }}”
*  only logged users with ADMIN or PAGE_2 role can view this page
*  if the user is not logged-in the page MUST redirect with a HTTP response code 302
to the login page
*  if the user is logged-in but do not have the appropriate role an error page MUST be
shown with a 403 HTTP response code
5. T-5 Login redirect (User Story)
A user without any session goes to /page/1 or /page/2 ->
the system redirects the user to a login page with a 302 HTTP response code ->
the user input his/her username correctly but a wrong password ->
an error has shown to the user ->
the user input the correct password ->
the system redirect the user to the desidered page with a 302 HTTP response code
6. T-6 Logout
*  every page MUST have a working logout link
7. T-7 Login timeout
*  after 5 minutes without interaction the user MUST be considered logged out

## Configuración del proyecto
**Descargar dependencias de composer**

Descargar composer, y una vez instalado hacer:

```
composer install
```

O, según la versión de composer el comando podría ser:  `php composer.phar install` 

Dependiendo de la configuración de la máquina puede ser necesario poner en el php.ini el
memory_limit=-1

**Configurar el fichero de entorno  .env**

Hay que tener un fichero `.env` , que no se repositará. Duplicar el `.env.dist` y cambiarle el nombre.
Posteriormente reajustar parámetros, especialmente en los referente a base de datos para asegurar conectividad.  `DATABASE_URL`.

**Inicializar la Database**

Ejecutar los siguientes comandos. Los fixtures introducen data en la BD.

```
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

**Iniciar servidor**
El servidor se puede inicializar de dos maneras:
a) Con el built-in server
```
php -S localhost:8000 -t public
```
a) Con el ejecutable de symfony que permite tener un servidor con un SSL en local. Para peticiones https.
https://symfony.com/download
```
symfony serve --dir path_to_the project
```

**POSTMAN** 
Para poder realizar las peticiones a la api de Hola (/api del ApiController) es conveniente hacerlo mediante
el programa POSTMAN, que permite personalizar las peticiones de forma sencilla. 
Para ejecutar los test mas básicos se incluye en la carpeta postman unos ejemplos de peticiones. 
Recordar que para poder ejecutar las peticiones se debe estar logueado:
* Añadir autenticación Bearer Token
* Copiar un token válido de la BD tabla api_tokens, y añadirlo para que salga el authentication en el Header.
* Hacer la petición. 

Si el token hubiera expirado la aplicación dará un mensaje de error. 


**Corrección de código**
Está instalado el php-sniffer, para poder comprobar y corregir desde el terminal los fallos de codificación y mantener 
un código homogéneo. 
Para utilizarlo basta con escribir el comando, el estandar y la carpeta en la que buscar los fallos. 
```
phpcs --standard=PSR2 src
```

Para corregir automáticamente: 
```
phpcbf --standard=PSR2 src
```

Para limpiar caché: 
```
php bin/console cache:clear
```

**Ejecución de los tests**
Existen dos tipos de tests, phpunit (codificación) y behat (funcionales). 
Behat usa como dependencia phpunit para las aserciones de código. Para poder usarlo hay que duplicar el behat.yml.dist y
convertirlo en .yml.
Si se desea comprobar la validez de la securización por https hay que modificar el behat.yml y tener un certificado
SSL instalado. El apache debe estar en ejecución para que corran los tests funcionales.
Para ejecutarlos basta con: 
```
bin\behat o vendor\bin\behat
vendor\bin\phpunit tests
```
*NOTA1: Dependiendo del entorno el ejecutable de behat estará en una ruta u otra. También es importante prestar atención a las barras según el SO. 

*NOTA2: Si queremos utilizar el PHPStorm como entorno de pruebas podemos 
ir a Settings > PHP > Test Frameworks y seleccionar el ejecutable de behat de la carpeta vendor: 
D:\Windows\PHPStormProjects\HOLA_CODING_TEST\vendor\behat\behat\bin\behat

Como configuration file pondremos nuestro behat.yml y en listener (bug) añadimos una nueva configuración que escuche la carpeta features. 
Hay que poner el CLI interpreter de PHP para que se puede ejecutar, y en este momento podemos ejecutar los tests de PHPStorm. 
