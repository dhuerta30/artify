# PHP Artify Framework
Artify es un framework creado para facilitar el uso y agilizar el desarrollo web, esta equipado con muchas funciones que facilitaran el tiempo de desarrollo. Algunas caracteristicas son:
- Generador de Módulos
- Generador de PDF con la clase Xinvoice
- Ejecución de comandos por consola para crear controladores, modelos, vistas, crud, etc.
- Migraciones de base de datos con comandos por consola
- Api Rest para conectar aplicaciones con seguridad de Tokens
- Mantenedores Crud con menos código o por comandos de CMD

## Autor
- **Nombre del Autor:** [Daniel Huerta]
- **Correo Electrónico:** [daniel.telematico@gmail.com]
# Para crear controladores use el comando por consola

```cmd
php artify make:controller NombreControlador
```
# Para crear modelos use el comando por consola

```cmd
php artify make:model NombreModelo
```
# Para crear Vistas use el comando por consola

```cmd
php artify make:view nombre_vista
```
# Para crear una Tabla en la DB use el comando por consola

```cmd
php artify create:table nombre_tabla "columna1 INT, columna2 VARCHAR(255), columna3 DATE"
```
# Para eliminar una Tabla en la DB use el comando por consola

```cmd
php artify drop:table nombre_tabla
```
# Para crear Crud use el comando por consola

```cmd
php artify create:crud nombre_tabla "columna1 INT, columna2 VARCHAR(255), columna3 DATE" nombre_vista
```
# Para crear una migración de BD use el comando por consola

```cmd
php artify database:migrate
```
# Para listar todos los comandos disponibles use el comando por consola

```cmd
php artify list
```
# Estructura de los controladores

```PHP
<?php

namespace App\Controllers;

use App\core\SessionManager; // llama a los metodos de session
use App\core\Token;  // llama a los tokens de formularios
use App\core\Request; // llama a los parametros por $_POST
use App\core\View; // llama a los metodos que cargan la vista
use App\core\Redirect;  // llama a los metodos que usan redirecciones para no usar header("Location: ");
use App\core\DB;  // llama a PDOModel y PDOCrud para generar mantenedores con pocas lineas de codigo y consultas a la base de datos
use Xinvoice;  // llama al generador de PDF
use Coderatio\SimpleBackup\SimpleBackup;  // libreria para generar respaldos a la BD
use App\Models\DatosPacienteModel;  // llama al modelo 
use App\Models\PageModel;   // llama al modelo 

class HomeController
{

}
?>
```

# Estructura de los Modelos
```PHP
<?php
namespace App\Models;
use App\core\DB;

class NombreModel
{
  private $tabla;

  function __construct() {
	
	$this->tabla = "nombre_tabla";
  }

  public function MiMetodo($param){
	$pdomodel = DB::PDOModel();
	$pdomodel->where("rut", $param);
	$data = $pdomodel->select($this->tabla);
	return $data;
  }

}
?>
```
# Estructura de la Api
```PHP
<?php

namespace App\Controllers;

use App\core\DB;
use App\core\RequestApi; // request para leer datos json en postman
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;

class ApiController
{
    private $secretKey;

    public function __construct()
    {
          $this->secretKey = $_ENV['CSRF_SECRET'];
    }

    // ejemplo con validación de token
    public function listar()
    {
        $request = new RequestApi(); // se instancia la request de esta forma

        if ($request->getMethod() === 'GET') {

            $token = $request->get('token'); // se usa igual que la request normal

            $usuario = new UserModel();
            $data = $usuario->select_userBy_token($token);

            if ($data && !empty($token) && $this->validarToken($token)) {
                echo json_encode(['data' => $data]);
            } else {
                echo json_encode(['error' => 'Token inválido no tiene permisos para acceder a esta Api']);
            }
        }
    }
}
?>
```
# Archivo de configuraciones de la BD y mas .env
```env
# DB config #
DB_HOST=localhost
DB_USER=root
DB_NAME=procedimiento
DB_PASS=
# Set the database type to be used. Available values are "mysql", "pgsql", "sqlite" and "sqlserver".
DB_TYPE=mysql

BASE_URL=/procedimiento/  // url base del directorio principal de tu proyecto

URL_PDOCRUD=/procedimiento/app/libs/
UPLOAD_URL=app/libs/script/uploads/
DOWNLOAD_URL=/procedimiento/app/libs/script/downloads/
DOWNLOAD_FOLDER=downloads/
UPLOAD_FOLDER=uploads/
LANG=es

CSRF_SECRET=dfa%d_FA{]2Ñf523scvDAgfasg
CHARACTER_SET=utf8

# Recaptcha #
SITE_KEY=6LdVvpshAAAAACalclDg_LRIgHp5ZxR1Zeps5paY
SITE_SECRET=6LdVvpshAAAAABa5qxgcBrv7_L3PUUrSXmuThXO6

# Email Config #
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
SMTP_AUTH=true
MAIL_USERNAME=daniel.telematico@gmail.com
MAIL_PASSWORD=zdkbgrxsnjmyyzrj
EMAIL_FROM=Procedimiento
SMTP_SECURE=tls
SMTP_KEEP_ALIVE=true
```
# Asignar menus a usuarios
![Asignar menus a usuarios](https://github.com/dhuerta30/procedimiento/blob/main/Screenshot_21.png)

# Mantenedor de Menus
![Mantenedor de Menus](https://github.com/dhuerta30/procedimiento/blob/main/Screenshot_22.png)

# Respaldo de DB
![Respaldo de DB](https://github.com/dhuerta30/procedimiento/blob/main/Screenshot_23.png)
