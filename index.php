<?php
require('vendor/autoload.php');
$dotenv = DotenvVault\DotenvVault::createImmutable(__DIR__);
$dotenv->safeLoad();
require __DIR__ . '/app/libs/script/pdocrud.php';
require __DIR__ . '/app/libs/xinvoice/xinvoice.php';

// Enrutador simple
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = str_replace($_ENV["BASE_URL"], '', $requestUri);

// Dividir la URL en segmentos
$segments = explode('/', $requestUri);

// Obtener el nombre del controlador y la acción
$controllerName = isset($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'UserController';
$action = isset($segments[1]) ? $segments[1] : 'index';

// Obtener los parámetros de la URL
$params = array_slice($segments, 2);

// Validar que el controlador existe
$controllerFile = __DIR__ . '/app/Controllers/' . $controllerName . '.php';
$modelFile = __DIR__ . '/app/Models/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Cargar el modelo si existe
    if (file_exists($modelFile)) {
        require_once $modelFile;
        $modelName = $controllerName . 'Model';
        $model = new $modelName();
    } else {
        $model = null;
    }

    // Crear instancias
    $view = new App\core\View();
    $controllerClassName = 'App\Controllers\\' . $controllerName;
    $controller = new $controllerClassName($model, $view);

    // Enrutamiento simple
    if (method_exists($controller, $action)) {    
        $controller->$action();
    } else {
        App\core\Redirect::to("error/index");
    }
} else {
    // Redirigir a la página predeterminada si el controlador no existe
    $controllerName = 'login';
    $action = 'index';
    if (isset($controllerName) && isset($action)) {
        App\core\Redirect::to("$controllerName" . "/" . "$action");
    }
}
