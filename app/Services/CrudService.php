<?php

namespace App\Services;

use DotenvVault\DotenvVault;
use PDO;

class CrudService
{
    private $pdo;

    public function __construct()
    {
        $dotenv = DotenvVault::createImmutable(dirname(__DIR__, 3));
        $dotenv->safeLoad();

        $databaseHost = $_ENV['DB_HOST'];
        $databaseName = $_ENV['DB_NAME'];
        $databaseUser = $_ENV['DB_USER'];
        $databasePassword = $_ENV['DB_PASS'];

        $this->pdo = new PDO("mysql:host={$databaseHost};dbname={$databaseName}", $databaseUser, $databasePassword);
    }

    public function createCrud(
        $tableName, 
        $idTable = null, 
        $crudType, 
        $query = null, 
        $controllerName, 
        $nameview, 
        $template_html, 
        $active_filter, 
        $mostrar_campos_filtro,
        $tipo_de_filtro,
        $clone_row, 
        $active_popup, 
        $active_search, 
        $activate_deleteMultipleBtn, 
        $button_add, 
        $actions_buttons_grid, 
        $modify_query = null, 
        $activate_nested_table, 
        $buttons_actions, 
        $refrescar_grilla, 
        $encryption, 
        $mostrar_campos_busqueda, 
        $mostrar_columnas_grilla, 
        $mostrar_campos_formulario, 
        $activar_recaptcha,
        $sitekey_recaptcha, 
        $sitesecret_repatcha,
        $function_filter_and_search,
        $activar_union_interna,
        $tabla_principal_union,
        $tabla_secundaria_union,
        $campos_relacion_union_tabla_principal,
        $campos_relacion_union_tabla_secundaria,
        $mostrar_campos_formulario_editar,
        $posicion_botones_accion_grilla,
        $mostrar_columna_acciones_grilla,
        $campos_requeridos,
        $mostrar_paginacion,
        $activar_numeracion_columnas,
        $activar_registros_por_pagina,
        $cantidad_de_registros_por_pagina,
        $activar_edicion_en_linea,
        $nombre_modulo,
        $ordenar_grilla_por,
        $tipo_orden,
        $posicionarse_en_la_pagina,
        $ocultar_id_tabla,
        $nombre_columnas,
        $nuevo_nombre_columnas,
        $nombre_campos,
        $nuevo_nombre_campos,
        $totalRecordsInfo,
        $area_protegida_por_login,
        $posicion_filtro,
        $file_callback,
        $type_callback,
        $type_fields
        )
    {
        if($crudType == 'SQL'){
            $this->generateCrudControllerSQL(
                $tableName,
                $idTable,
                $query,
                $controllerName,
                $nameview,
                $template_html,
                $active_filter,
                $mostrar_campos_filtro,
                $tipo_de_filtro,
                $clone_row,
                $active_popup,
                $active_search, 
                $activate_deleteMultipleBtn,
                $button_add,
                $actions_buttons_grid,
                $activate_nested_table,
                $buttons_actions,
                $refrescar_grilla,
                $encryption,
                $mostrar_campos_busqueda,
                $mostrar_campos_formulario,
                $activar_recaptcha,
                $sitekey_recaptcha,
                $sitesecret_repatcha,
                $function_filter_and_search,
                $mostrar_campos_formulario_editar,
                $posicion_botones_accion_grilla,
                $mostrar_columna_acciones_grilla,
                $campos_requeridos,
                $activar_numeracion_columnas,
                $activar_registros_por_pagina,
                $nombre_modulo,
                $totalRecordsInfo,
                $area_protegida_por_login,
                $posicion_filtro,
                $file_callback,
                $type_callback
            );
        }

        if ($crudType == 'CRUD') {
            $this->generateCrudControllerCRUD(
                $tableName, 
                $idTable, 
                $query, 
                $controllerName, 
                $nameview, 
                $template_html,
                $active_filter, 
                $mostrar_campos_filtro,
                $tipo_de_filtro,
                $clone_row,
                $active_popup,
                $active_search, 
                $activate_deleteMultipleBtn,
                $button_add,
                $actions_buttons_grid,
                $activate_nested_table,
                $buttons_actions,
                $refrescar_grilla,
                $encryption,
                $mostrar_campos_busqueda,
                $mostrar_columnas_grilla,
                $mostrar_campos_formulario,
                $activar_recaptcha,
                $sitekey_recaptcha,
                $sitesecret_repatcha,
                $function_filter_and_search,
                $activar_union_interna,
                $tabla_principal_union,
                $tabla_secundaria_union,
                $campos_relacion_union_tabla_principal,
                $campos_relacion_union_tabla_secundaria,
                $mostrar_campos_formulario_editar,
                $posicion_botones_accion_grilla,
                $mostrar_columna_acciones_grilla,
                $campos_requeridos,
                $mostrar_paginacion,
                $activar_numeracion_columnas,
                $activar_registros_por_pagina,
                $cantidad_de_registros_por_pagina,
                $activar_edicion_en_linea,
                $nombre_modulo,
                $ordenar_grilla_por,
                $tipo_orden,
                $posicionarse_en_la_pagina,
                $ocultar_id_tabla,
                $nombre_columnas,
                $nuevo_nombre_columnas,
                $nombre_campos,
                $nuevo_nombre_campos,
                $totalRecordsInfo,
                $area_protegida_por_login,
                $posicion_filtro,
                $file_callback,
                $type_callback,
                $type_fields
            );

            if($area_protegida_por_login == "Si"){
                $this->generateView($nameview);
            } else {
                $this->generateViewNotLogin($nameview);
            }

            if(!empty($file_callback)){
                $fileName = $file_callback . ".php";
                $phpCode = '
                require_once dirname(__DIR__, 3) . "/vendor/autoload.php";

                // Cargar variables de entorno antes de iniciar la sesión
                $dotenv = DotenvVault\DotenvVault::createImmutable(dirname(__DIR__, 3));
                $dotenv->safeLoad();

                @session_name($_ENV["APP_NAME"]);
                @session_start();
                /*enable this for development purpose */
                //ini_set(\'display_startup_errors\', 1);
                //ini_set(\'display_errors\', 1);
                //error_reporting(-1);
                date_default_timezone_set(@date_default_timezone_get());
                define(\'ArtifyABSPATH\', dirname(__FILE__) . \'/\');
                require_once ArtifyABSPATH . "config/config.php";
                spl_autoload_register(\'artifyAutoLoad\');

                function artifyAutoLoad($class) {
                    if (file_exists(ArtifyABSPATH . "classes/" . $class . ".php"))
                        require_once ArtifyABSPATH . "classes/" . $class . ".php";
                }

                if (isset($_REQUEST["artify_instance"])) {
                    $fomplusajax = new ArtifyAjaxCtrl();
                    $fomplusajax->handleRequest();
                }';
                
                if(isset($type_callback)){
                    // Separar y limpiar las columnas originales
                    $values_type_callback = explode(',', $type_callback);
                    $values_type_callback = array_filter($values_type_callback, function ($value) {
                        return !empty(trim($value));
                    });
                            
                    foreach ($values_type_callback as $index => $callback) {

                        $value = $callback;

                        if($value == "Antes de Insertar"){
                            $phpCode .= "
                                function before_insert_{$tableName}(\$data, \$obj){

                                    return \$data;
                                }
                            ";
                        } 
                        
                        if($value == "Despues de Insertar"){
                            $phpCode .= "
                                function after_insert_{$tableName}(\$data, \$obj){

                                    return \$data;
                                }
                            ";
                        }
    
                        if($value == "Antes de Actualizar"){
                            $phpCode .= "
                                function before_update_{$tableName}(\$data, \$obj){

                                    return \$data;
                                }
                            ";
                        }
    
                        if($value == "Despues de Actualizar"){
                            $phpCode .= "
                                function after_update_{$tableName}(\$data, \$obj){

                                    return \$data;
                                }
                            ";
                        }
    
                        if($value == "Antes de Eliminar"){
                            $phpCode .= "
                                function before_delete_{$tableName}(\$data, \$obj){

                                    return \$data;
                                }
                            ";
                        }
    
                        if($value == "Despues de Eliminar"){
                            $phpCode .= "
                                function after_delete_{$tableName}(\$data, \$obj){

                                    return \$data;
                                }
                            ";
                        }

                        if($value == "Eliminación Masiva"){
                            $phpCode .= "
                                function before_delete_selected_{$tableName}(\$data, \$obj){
                                
                                    return \$data;
                                }
                            ";
                        }

                        if($value == "Antes de Actualizar Switch"){
                            $phpCode .= "
                                function before_switch_update_{$tableName}(\$data, \$obj){
                                
                                    return \$data;
                                }
                            ";
                        }

                        if($value == "Despues de Actualizar Switch"){
                            $phpCode .= "
                                function after_switch_update_{$tableName}(\$data, \$obj){

                                    return \$data;
                                }
                            ";
                        }

                        if($value == "Antes de Seleccionar"){
                            $phpCode .= "
                                function before_select_{$tableName}(\$data, \$obj){
                                
                                    return \$data;
                                }
                            ";
                        }

                        if($value == "Despues de Seleccionar"){
                            $phpCode .= "
                                function after_select_{$tableName}(\$data, \$obj){
                                
                                    return \$data;
                                }
                            ";
                        }
                        
                    }
                } else {
                    $phpCode .= '';
                }

                $this->generatePHPFile($fileName, $phpCode);
            }

            //$this->generateViewAdd($nameview);
        }

        $this->generateTemplateCrud($nameview);
    }

    private function generateTemplateCrud($nameview)
    {
        $sourceDir = __DIR__ . '/../libs/artify/classes/templates/bootstrap4';
        $destinationDir = __DIR__ . '/../libs/artify/classes/templates/template_' . $nameview;

        if (!file_exists($destinationDir)) {
            $this->copyDirectory($sourceDir, $destinationDir);
        }
    }

    private function copyDirectory($source, $destination)
    {
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true); // Crear la carpeta de destino
        }

        $dir = opendir($source);

        while (($file = readdir($dir)) !== false) {
            if ($file != '.' && $file != '..') {
                $sourcePath = $source . DIRECTORY_SEPARATOR . $file;
                $destPath = $destination . DIRECTORY_SEPARATOR . $file;

                if (is_dir($sourcePath)) {
                    $this->copyDirectory($sourcePath, $destPath);
                } else {
                    copy($sourcePath, $destPath);
                }
            }
        }

        closedir($dir);
    }

    private function generatePHPFile($fileName, $phpCode) {
        $filePath = __DIR__ . '/../libs/artify/' . $fileName;

        if (!file_exists($filePath)) {
            $this->writePHPCodeToFile($filePath, $phpCode);
        } else {
            echo "El archivo ya existe.";
        }
    }

    private function writePHPCodeToFile($filePath, $phpCode) {
        if ($this->createFile($filePath)) {
            $fullCode = "<?php" . $phpCode . "\n";
            file_put_contents($filePath, $fullCode);
            //echo "Archivo creado y código escrito exitosamente en: " . $filePath;
        } else {
            echo "Error al crear el archivo.";
        }
    }

    // Método privado que se asegura de que el archivo sea creado correctamente
    private function createFile($filePath) {
        $directory = dirname($filePath);

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true); // Crear directorio si no existe
        }

        if (file_put_contents($filePath, '') !== false) {
            return true;
        }

        return false;
    }

    private function generateCrudControllerSQL($tableName, $idTable = null, $query = null, $controllerName, $nameview, $template_html, $active_filter, $clone_row, $active_popup, $active_search, $activate_deleteMultipleBtn, $button_add, $actions_buttons_grid, $activate_nested_table, $buttons_actions, $refrescar_grilla, $encryption, $mostrar_campos_busqueda)
    {
        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . 'Controller.php';
        $controllerContent = "<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\DB;
        use App\core\Request;
        use App\core\View;
        use App\core\Redirect;

        class {$controllerName}Controller
        {
            public \$token;

            public function __construct()
            {
                SessionManager::startSession();
                \$Sesusuario = SessionManager::get('usuario');
                if (!isset(\$Sesusuario)) {
                    Redirect::to('login/index');
                }
                \$this->token = Token::generateFormToken('send_message');
            }

            public function index()
            {
                \$artify = DB::ArtifyCrud();
                \$queryfy = \$artify->getQueryfyObj();
                \$columnDB = \$queryfy->columnNames('{$tableName}');
                \$id = strtoupper(\$columnDB[0]);

                \$html_template = '<div class=\"form\">
                <h5>Agregar Módulo</h5>
                <hr>';

                foreach (\$columns as \$column) {
                    \$columnName = ucfirst(str_replace('_', ' ', \$column)); // Opcional: transformar el nombre de la columna
                    \$html_template .= '
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <div class=\"form-group\">
                                <label class=\"form-label\">' . \$columnName . ':</label>
                                {' . \$column . '}
                                <p class=\"artify_help_block help-block form-text with-errors\"></p>
                            </div>
                        </div>
                    </div>';
                }

                \$html_template .= '
                </div>'; // Cierre del div de formulario

                \$artify->set_template(\$html_template);
                \$tabla = \$artify->getLangData('{$tableName}');
                \$pk = \$artify->getLangData(\$id);
                \$columnVal = \$artify->getLangData(\$pk);

                \$artify->enqueueBtnTopActions('Report',  \"<i class='fa fa-plus'></i> Agregar\", \$_ENV['BASE_URL'].'{$controllerName}/agregar', array(), 'btn-report');

                \$action = \$_ENV['BASE_URL'].'{$controllerName}/editar/id/{{$idTable}}';
                \$text = '<i class=\"fa fa-edit\"></i>';
                \$attr = array('title'=> 'Editar');
                \$artify->enqueueBtnActions('url', \$action, 'url', \$text, \$pk, \$attr, 'btn-warning', array(array()));
                ";

                if ($active_filter == "Si") {
                    $controllerContent .= "
                        foreach (\$columnDB as \$column) {
                            \$columnName = ucfirst(str_replace('_', ' ', \$column));
                            
                            \$artify->addFilter('filterAdd'.\$column, 'Filtrar por '.\$columnName.' ', '', 'dropdown');
                            \$artify->setFilterSource('filterAdd'.\$column, '{$tableName}', \$column, \$column.' as pl', 'db');
                        }
                        ";
                }
        
                $actions_buttons_grid_array = explode(',', $actions_buttons_grid);
       
                foreach ($actions_buttons_grid_array as $action) {
                    if ($action === 'Imprimir') {
                            $controllerContent .= "
                            \$artify->setSettings('printBtn', true);
                        ";
                    } else if ($action === 'PDF') {
                            $controllerContent .= "
                            \$artify->setSettings('pdfBtn', true);
                        ";
                    } else if ($action === 'CSV') {
                            $controllerContent .= "
                            \$artify->setSettings('csvBtn', true);
                        ";
                    } else if ($action === 'Excel') {
                            $controllerContent .= "
                            \$artify->setSettings('excelBtn', true);
                        ";
                    }
                }


                if($active_popup == 'Si'){
                    $controllerContent .= "
                        \$artify->formDisplayInPopup();
                    ";
                }
        
                if($active_search == 'Si'){
                    $controllerContent .= "
                        \$artify->setSettings('searchbox', true);
                    ";
                } else {
                    $controllerContent .= "
                        \$artify->setSettings('searchbox', false);
                    ";
                }
        
                // Continue with the remaining settings
                if ($clone_row == 'Si') {
                $controllerContent .= "
                        \$artify->setSettings('clonebtn', true);
                    ";
                } else {
                    $controllerContent .= "
                        \$artify->setSettings('clonebtn', false);
                    ";
                }
        
                if($activate_deleteMultipleBtn == 'Si'){
                    $controllerContent .= "
                        \$artify->setSettings('checkboxCol', true);
                        \$artify->setSettings('deleteMultipleBtn', true);
                    ";
                } else {
                    $controllerContent .= "
                        \$artify->setSettings('checkboxCol', false);
                        \$artify->setSettings('deleteMultipleBtn', false);
                    ";
                }
        
                if($refrescar_grilla == "Si"){
                    $controllerContent .= "
                        \$artify->setSettings('refresh', true);
                    ";
                } else {
                    $controllerContent .= "
                    \$artify->setSettings('refresh', false);
                ";
                }
        
                if($button_add == 'Si'){
                    $controllerContent .= "
                        \$artify->setSettings('addbtn', true);
                    ";
                } else {
                    $controllerContent .= "
                        \$artify->setSettings('addbtn', false);
                    ";
                }

                $controllerContent .= "\$artify->setSettings('encryption', false);
                \$artify->setSettings('pagination', true);
                \$artify->setSettings('recordsPerPageDropdown', true);
                \$artify->setSettings('totalRecordsInfo', true);
                \$artify->setSettings('editbtn', false);
                \$artify->setSettings('delbtn', true);
                \$artify->setSettings('actionbtn', true);
                \$artify->setSettings('numberCol', true);
                \$artify->setSettings('template', 'template_{$nameview}');
                \$artify->setLangData('no_data', 'Sin Resultados');
            
                \$artify->setLangData('tabla', '{$tableName}')
                    ->setLangData('pk', \$pk)
                    ->setLangData('columnVal', \$columnVal);
                \$artify->tableHeading('{$tableName}');
                \$artify->addCallback('before_delete_selected', 'eliminacion_masiva_tabla');
                \$artify->addCallback('before_sql_data', 'buscador_tabla', array(\$columnDB));
                \$artify->addCallback('before_delete', 'eliminar_tabla');

                \$artify->setSettings('viewbtn', false);
                \$artify->addCallback('format_sql_col', 'format_sql_col_tabla', array(\$columnDB));
                \$render = \$artify->setQuery('{$query}')->render('SQL');

                View::render(
                    '{$nameview}', 
                    [
                        'render' => \$render
                    ]
                );
            }

            public function agregar(){
                \$artify = DB::ArtifyCrud();
                \$artify->buttonHide('submitBtn');
                \$artify->buttonHide('cancel');
                \$artify->setSettings('template', 'template_{$nameview}');
                \$artify->formStaticFields('botones', 'html', '
                    <div class=\"col-md-12 text-center\">
                        <input type=\"submit\" class=\"btn btn-primary artify-form-control artify-submit\" data-action=\"insert\" value=\"Guardar\"> 
                        <a href=\"'.\$_ENV['BASE_URL'].'{$controllerName}/index\" class=\"btn btn-danger\">Regresar</a>
                    </div>
                ');
                \$render = \$artify->dbTable('{$tableName}')->render('insertform');
                View::render(
                    'agregar_{$nameview}',
                    [
                        'render' => \$render
                    ]
                );
            }

            public function editar(){
                \$request = new Request();
                \$id = \$request->get('id');

                \$artify = DB::ArtifyCrud();

                \$queryfy = \$artify->getQueryfyObj();
                \$columnDB = \$queryfy->columnNames('{$tableName}');
                \$id_tabla = strtoupper(\$columnDB[0]);

                \$artify->setPK(\$id_tabla);
                \$artify->setSettings('template', 'template_{$nameview}');
                \$artify->buttonHide('submitBtn');
                \$artify->buttonHide('cancel');
                \$artify->formStaticFields('botones', 'html', '
                    <div class=\"col-md-12 text-center\">
                        <input type=\"submit\" class=\"btn btn-primary artify-form-control artify-submit\" data-action=\"insert\" value=\"Guardar\"> 
                        <a href=\"'.\$_ENV['BASE_URL'].'{$controllerName}/index\" class=\"btn btn-danger\">Regresar</a>
                    </div>
                ');
                \$render = \$artify->dbTable('{$tableName}')->render('editform', array('id' => \$id));

                View::render(
                    'editar_{$nameview}',
                    [
                        'render' => \$render
                    ]
                );
            }
        }";
     
        file_put_contents($controllerPath, $controllerContent);
    }

    private function generateCrudControllerCRUD(
        $tableName, 
        $idTable = null, 
        $query = null, 
        $controllerName, 
        $nameview, 
        $template_html, 
        $active_filter, 
        $mostrar_campos_filtro, 
        $tipo_de_filtro,
        $clone_row, 
        $active_popup, 
        $active_search, 
        $activate_deleteMultipleBtn, 
        $button_add, 
        $actions_buttons_grid, 
        $activate_nested_table, 
        $buttons_actions, 
        $refrescar_grilla,
        $encryption, 
        $mostrar_campos_busqueda, 
        $mostrar_columnas_grilla, 
        $mostrar_campos_formulario, 
        $activar_recaptcha, 
        $sitekey_recaptcha, 
        $sitesecret_repatcha,
        $function_filter_and_search,
        $activar_union_interna,
        $tabla_principal_union,
        $tabla_secundaria_union,
        $campos_relacion_union_tabla_principal,
        $campos_relacion_union_tabla_secundaria,
        $mostrar_campos_formulario_editar,
        $posicion_botones_accion_grilla,
        $mostrar_columna_acciones_grilla,
        $campos_requeridos,
        $mostrar_paginacion,
        $activar_numeracion_columnas,
        $activar_registros_por_pagina,
        $cantidad_de_registros_por_pagina,
        $activar_edicion_en_linea,
        $nombre_modulo,
        $ordenar_grilla_por,
        $tipo_orden,
        $posicionarse_en_la_pagina,
        $ocultar_id_tabla,
        $nombre_columnas,
        $nuevo_nombre_columnas,
        $nombre_campos,
        $nuevo_nombre_campos,
        $totalRecordsInfo,
        $area_protegida_por_login,
        $posicion_filtro,
        $file_callback,
        $type_callback,
        $type_fields
        )
    {
        $controllerPath = __DIR__ . '/../Controllers/' . $controllerName . 'Controller.php';
        $controllerContent = "<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\DB;
        use App\core\View;
        use App\core\Redirect;
        use Docufy;

        class {$controllerName}Controller
        {
            public \$token;

            public function __construct()
            {";

                if($area_protegida_por_login == "Si"){
                    $controllerContent .= "
                    SessionManager::startSession();
                    \$Sesusuario = SessionManager::get('usuario');
                    if (!isset(\$Sesusuario)) {
                        Redirect::to('login/index');
                    }
                    \$this->token = Token::generateFormToken('send_message');
                    ";
                }
                
            $controllerContent .= "
            }
            public function index()
            {";

            if(!empty($file_callback)){
                $controllerContent .= "
                    \$settings[\"script_url\"] = \$_ENV['URL_ArtifyCrud'];
                    \$_ENV[\"url_artify\"] = \"artify/functions.php\";
                    \$settings[\"url_artify\"] = \$_ENV[\"url_artify\"];
                    \$settings[\"downloadURL\"] = \$_ENV['DOWNLOAD_URL'];
                    \$settings[\"hostname\"] = \$_ENV['DB_HOST'];
                    \$settings[\"database\"] = \$_ENV['DB_NAME'];
                    \$settings[\"username\"] = \$_ENV['DB_USER'];
                    \$settings[\"password\"] = \$_ENV['DB_PASS'];
                    \$settings[\"dbtype\"] = \$_ENV['DB_TYPE'];
                    \$settings[\"characterset\"] = \$_ENV[\"CHARACTER_SET\"];

                    \$artify = DB::ArtifyCrud(false, \"\", \"\",  \$settings);
                    \$queryfy = \$artify->getQueryfyObj();
                ";

                if(isset($type_callback)){
                    // Separar y limpiar las columnas originales
                    $values_type_callback = explode(',', $type_callback);
                    $values_type_callback = array_filter($values_type_callback, function ($value) {
                        return !empty(trim($value));
                    });
                            
                    foreach ($values_type_callback as $index => $callback) {

                        $value = $callback;

                        if($value == "Antes de Insertar"){
                            $controllerContent .= "
                                \$artify->addCallback(\"before_insert\", \"before_insert_{$tableName}\");
                            ";
                        } 
                        
                        if($value == "Despues de Insertar"){
                            $controllerContent .= "
                                \$artify->addCallback(\"after_insert\", \"after_insert_{$tableName}\");
                            ";
                        }
    
                        if($value == "Antes de Actualizar"){
                            $controllerContent .= "
                                \$artify->addCallback(\"before_update\", \"before_update_{$tableName}\");
                            ";
                        }
    
                        if($value == "Despues de Actualizar"){
                            $controllerContent .= "
                                \$artify->addCallback(\"after_update\", \"after_update_{$tableName}\");
                            ";
                        }
    
                        if($value == "Antes de Eliminar"){
                            $controllerContent .= "
                                \$artify->addCallback(\"before_delete\", \"before_delete_{$tableName}\");
                            ";
                        }
    
                        if($value == "Despues de Eliminar"){
                            $controllerContent .= "
                                \$artify->addCallback(\"after_delete\", \"after_delete_{$tableName}\");
                            ";
                        }

                        if($value == "Eliminación Masiva"){
                            $controllerContent .= "
                                \$artify->addCallback(\"before_delete_selected\", \"before_delete_selected_{$tableName}\");
                            ";
                        }

                        if($value == "Eliminación Masiva"){
                            $controllerContent .= "
                                \$artify->addCallback(\"before_delete_selected\", \"before_delete_selected_{$tableName}\");
                            ";
                        }

                        if($value == "Antes de Actualizar Switch"){
                            $controllerContent .= "
                                \$artify->addCallback(\"before_switch_update\", \"before_switch_update_{$tableName}\");
                            ";
                        }

                        if($value == "Despues de Actualizar Switch"){
                            $controllerContent .= "
                                \$artify->addCallback(\"after_switch_update\", \"after_switch_update_{$tableName}\");
                            ";
                        }

                        if($value == "Antes de Seleccionar"){
                            $controllerContent .= "
                                \$artify->addCallback(\"before_select\", \"before_select_{$tableName}\");
                            ";
                        }

                        if($value == "Despues de Seleccionar"){
                            $controllerContent .= "
                                \$artify->addCallback(\"after_select\", \"after_select_{$tableName}\");
                            ";
                        }
                        
                    }
                }

            } else {
                $controllerContent .= "
                    \$artify = DB::ArtifyCrud();
                    \$queryfy = \$artify->getQueryfyObj();
                ";
            }

                 if(isset($mostrar_campos_busqueda)){

                    $values = explode(',', $mostrar_campos_busqueda);

                    $values = array_filter($values, function ($value) {
                        return !empty(trim($value));
                    });

                    $valuesString = '"' . implode('", "', $values) . '"';

                    $controllerContent .= "
                        \$artify->setSearchCols(array({$valuesString}));
                    ";
                }

                if($activar_recaptcha == "Si"){
                    $controllerContent .= "
                        \$artify->recaptcha(\"{$sitekey_recaptcha}\", \"{$sitesecret_repatcha}\");
                    ";
                }

                if(isset($mostrar_columnas_grilla)){

                    $values = explode(',', $mostrar_columnas_grilla);

                    $values = array_filter($values, function ($value) {
                        return !empty(trim($value));
                    });
                    
                    $valuesString = '"' . implode('", "', $values) . '"';

                    $controllerContent .= "
                        \$artify->crudTableCol(array({$valuesString}));
                    ";
                }

                if (isset($mostrar_campos_formulario)) {

                    // Separar y limpiar los campos del formulario
                    $values = explode(',', $mostrar_campos_formulario);
                    $values = array_filter($values, function ($value) {
                        return !empty(trim($value));
                    });
                
                    if (!empty($type_fields)) {
                        // Separar y limpiar los tipos de campos
                        $values_type_fields = explode(',', $type_fields);
                        $values_type_fields = array_filter($values_type_fields, function ($value) {
                            return !empty(trim($value));
                        });
                
                        // Asegurarse de que ambas matrices tengan la misma cantidad de elementos
                        if (count($values) === count($values_type_fields)) {
                            foreach ($values as $index => $campo) {
                                $tipoDeCampo = $values_type_fields[$index];
                
                                // Asignar el tipo de campo basado en $tipoDeCampo
                                switch ($tipoDeCampo) {
                                    case "Imagen":
                                        $controllerContent .= "
                                            \$artify->fieldTypes(\"{$campo}\", \"FILE_NEW\");
                                        ";
                                        break;
                                    case "Archivo Único":
                                        $controllerContent .= "
                                            \$artify->fieldTypes(\"{$campo}\", \"FILE\");
                                        ";
                                        break;
                                    case "Multiples Archivos":
                                        $controllerContent .= "
                                            \$artify->fieldTypes(\"{$campo}\", \"FILE_MULTI\");
                                        ";
                                        break;
                                    case "Radiobox":
                                        $controllerContent .= "
                                            \$artify->fieldTypes(\"{$campo}\", \"radio\");
                                        ";
                                        break;
                                    case "Checkbox":
                                        $controllerContent .= "
                                            \$artify->fieldTypes(\"{$campo}\", \"checkbox\");
                                        ";
                                        break;
                                    case "Combobox":
                                        $controllerContent .= "
                                            \$artify->fieldTypes(\"{$campo}\", \"select\");
                                        ";
                                        break;
                                    case "Combobox Multiple":
                                        $controllerContent .= "
                                            \$artify->fieldTypes(\"{$campo}\", \"multiselect\");
                                        ";
                                        break;
                                    case "Campo de Texto":
                                        $controllerContent .= "
                                            \$artify->fieldTypes(\"{$campo}\", \"input\");
                                        ";
                                        break;
                                    case "Campo de Fecha":
                                        $controllerContent .= "
                                            \$artify->fieldTypes(\"{$campo}\", \"date\");
                                        ";
                                        break;
                                }
                            }
                        }
                    }
                
                    // Convertir los valores a un string para formFields
                    $valuesString = '"' . implode('", "', $values) . '"';
                    $controllerContent .= "
                        \$artify->formFields(array({$valuesString}));
                    ";
                }                

                if(isset($mostrar_campos_formulario_editar)){

                    $values = explode(',', $mostrar_campos_formulario_editar);

                    $values = array_filter($values, function ($value) {
                        return !empty(trim($value));
                    });
                    
                    $valuesString = '"' . implode('", "', $values) . '"';

                    $controllerContent .= "
                        \$artify->editFormFields(array({$valuesString}));
                    ";
                }


                if ($active_filter == "Si" && isset($mostrar_campos_filtro) && !empty($tipo_de_filtro)) {

                    // Separar y limpiar los campos de filtro (mostrar_campos_filtro)
                    $values_mostrar_campos_filtro = explode(',', $mostrar_campos_filtro);
                    $values_mostrar_campos_filtro = array_filter($values_mostrar_campos_filtro, function ($value) {
                        return !empty(trim($value));
                    });
                
                    // Separar y limpiar los tipos de filtro (tipo_de_filtro)
                    $values_tipo_de_filtro = explode(',', $tipo_de_filtro);
                    $values_tipo_de_filtro = array_filter($values_tipo_de_filtro, function ($value) {
                        return !empty(trim($value));
                    });
                
                    // Asegurarse de que ambas matrices tengan la misma cantidad de elementos
                    if (!empty($values_mostrar_campos_filtro) && count($values_mostrar_campos_filtro) === count($values_tipo_de_filtro)) {
                
                        foreach ($values_mostrar_campos_filtro as $index => $column) {
                            // Formatear el nombre de la columna para que sea legible
                            $columnName = ucfirst(str_replace('_', ' ', $column));
                
                            // Obtener el tipo de filtro correspondiente
                            $columnTipoFiltro = $values_tipo_de_filtro[$index];

                            if($columnTipoFiltro == "text"){
                                $controllerContent .= "
                                    \$artify->addFilter('filterAdd{$column}', 'Filtrar por {$columnName}', '{$column}', 'text');
                                    \$artify->setFilterSource('filterAdd{$column}', '', '', '', '');
                                ";
                            } else {
                                $controllerContent .= "
                                    \$artify->addFilter('filterAdd{$column}', 'Filtrar por {$columnName}', '{$column}', '{$columnTipoFiltro}');
                                    \$artify->setFilterSource('filterAdd{$column}', '{$tableName}', '{$column}', '{$column} as pl', 'db');
                                ";
                            }
                        }
                    }
                }
                

                if(!empty($nombre_columnas) && !empty($nuevo_nombre_columnas)){

                    // Separar y limpiar las columnas originales
                    $values_nombre_columnas = explode(',', $nombre_columnas);
                    $values_nombre_columnas = array_filter($values_nombre_columnas, function ($value) {
                        return !empty(trim($value));
                    });
                    
                    // Separar y limpiar los nuevos nombres de columnas
                    $values_nuevo_nombre_columnas = explode(',', $nuevo_nombre_columnas);
                    $values_nuevo_nombre_columnas = array_filter($values_nuevo_nombre_columnas, function ($value) {
                        return !empty(trim($value));
                    });

                    // Asegurarse de que ambas matrices tengan la misma cantidad de elementos
                    if (count($values_nombre_columnas) === count($values_nuevo_nombre_columnas)) {
                       
                        foreach ($values_nombre_columnas as $index => $columnNombre) {
                            $columnNuevoNombre = $values_nuevo_nombre_columnas[$index];

                            $columnNombreColumna = $columnNombre;
                            $columnNuevoNombreColumna = $columnNuevoNombre;

                            $controllerContent .= "
                                \$artify->colRename(\"{$columnNombreColumna}\", \"{$columnNuevoNombreColumna}\");
                            ";
                        }
                    }
                }


                if (!empty($nombre_campos) && !empty($nuevo_nombre_campos)) {

                    // Separar y limpiar las columnas originales
                    $values_nombre_campos = explode(',', $nombre_campos);
                    $values_nombre_campos = array_filter($values_nombre_campos, function ($value) {
                        return !empty(trim($value));
                    });
                
                    // Separar y limpiar los nuevos nombres de columnas
                    $values_nuevo_nombre_campos = explode(',', $nuevo_nombre_campos);
                    $values_nuevo_nombre_campos = array_filter($values_nuevo_nombre_campos, function ($value) {
                        return !empty(trim($value));
                    });
                
                    // Asegurarse de que ambas matrices tengan la misma cantidad de elementos
                    if (count($values_nombre_campos) === count($values_nuevo_nombre_campos)) {
                
                        foreach ($values_nombre_campos as $index => $campoNombre) {
                            $campoNuevoNombre = $values_nuevo_nombre_campos[$index];
                
                            $controllerContent .= "
                                \$artify->fieldRenameLable(\"{$campoNombre}\", \"{$campoNuevoNombre}\");
                            ";
                        }
                    }
                }                

        if ($template_html == "Si") {
            $controllerContent .= "
                \$html_template = '<div class=\"form\">
                <h5>Agregar Módulo</h5>
                <hr>
                <div class=\"row\">';

                \$columnSizes = [
                    'col-md-4',
                    'col-md-4',
                    'col-md-4',
                    'col-md-12'
                ];

                \$sizeIndex = 0;

                foreach (\$columnDB as \$column) {
                    \$columnName = ucfirst(str_replace('_', ' ', \$column));
                    
                    \$colClass = \$columnSizes[\$sizeIndex % count(\$columnSizes)];
                    
                    \$html_template .= '
                    <div class=\"' . \$colClass . '\">
                        <div class=\"form-group\">
                            <label class=\"form-label\">' . \$columnName . ':</label>
                            {' . \$column . '}
                            <p class=\"artify_help_block help-block form-text with-errors\"></p>
                        </div>
                    </div>';

                    \$sizeIndex++;
                }

                \$html_template .= '</div></div>';

                \$artify->set_template(\$html_template);
                ";
        }

        if($activate_nested_table == "Si"){
            $controllerContent .= "
               
            ";
        }

        if(!empty($nombre_modulo)){
            $controllerContent .= "
                \$artify->tableHeading('{$nombre_modulo}');
            ";
        }

        if ($activar_union_interna == "Si") {

            $values_tabla_principal_union = explode(',', $campos_relacion_union_tabla_principal);
            $values_tabla_principal_union = array_filter($values_tabla_principal_union, function ($value) {
                return !empty(trim($value));
            });
        
            $values_tabla_secundaria_union = explode(',', $campos_relacion_union_tabla_secundaria);
            $values_tabla_secundaria_union = array_filter($values_tabla_secundaria_union, function ($value) {
                return !empty(trim($value));
            });
        
            foreach ($values_tabla_principal_union as $index => $campoPrincipal) {

                $campoSecundario = $values_tabla_secundaria_union[$index];
    
                $columnName = ucfirst(str_replace('_', ' ', $campoPrincipal));
    
                $controllerContent .= "
                    \$artify->joinTable(\"{$tabla_secundaria_union}\", \"{$tabla_secundaria_union}.{$campoSecundario} = {$tabla_principal_union}.{$campoPrincipal}\", \"INNER JOIN\");
                ";
            }
        }        

        if(!empty($posicion_filtro) && $posicion_filtro == "Izquierda"){
            $controllerContent .= "
                \$artify->setSettings(\"actionFilterPosition\", \"left\");
            ";
        } else if($posicion_filtro == "Derecha"){
            $controllerContent .= "
                \$artify->setSettings(\"actionFilterPosition\", \"right\");
            ";
        } else if($posicion_filtro == "Arriba"){
            $controllerContent .= "
                \$artify->setSettings(\"actionFilterPosition\", \"top\");
            ";
        }

        if(isset($ordenar_grilla_por) && isset($tipo_orden)){
            $controllerContent .= "
                \$artify->dbOrderBy(\"{$ordenar_grilla_por}\", \"{$tipo_orden}\");
            ";
        }


        if(!empty($posicionarse_en_la_pagina)){
            $controllerContent .= "
                \$artify->currentPage({$posicionarse_en_la_pagina});
            ";
        }

        if($posicion_botones_accion_grilla == "Izquierda"){
            $controllerContent .= "
                \$artify->setSettings(\"actionBtnPosition\", \"left\");
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings(\"actionBtnPosition\", \"right\");
            ";
        }

        $buttons_actions_array = explode(',', $buttons_actions);
       
        foreach ($buttons_actions_array as $Btnaction) {
            if ($Btnaction === 'Ver') {
                $controllerContent .= "
                    \$artify->setSettings('viewbtn', true);
                ";
            } else if ($Btnaction === 'Editar') {
                $controllerContent .= "
                    \$artify->setSettings('editbtn', true);
                ";
            } else if ($Btnaction === 'Eliminar') {
                $controllerContent .= "
                    \$artify->setSettings('delbtn', true);
                ";
            } else if ($Btnaction === 'Guardar') {
                $controllerContent .= "
                    \$artify->buttonHide(\"submitBtn\");
                ";
            } else if ($Btnaction === 'Guardar y regresar') {
                $controllerContent .= "
                    \$artify->buttonHide(\"submitBtnSaveBack\");
                ";
            } else if ($Btnaction === 'Regresar') {
                $controllerContent .= "
                    \$artify->buttonHide(\"submitBtnBack\");
                ";
            } else if ($Btnaction === 'Cancelar') {
                $controllerContent .= "
                    \$artify->buttonHide(\"cancel\");
                ";
            } else if ($Btnaction === 'Personalizado PDF') {
                $controllerContent .= "
                    \$action = \$_ENV['BASE_URL'].'{$controllerName}/{$tableName}_pdf/id/{{$idTable}}';
                    \$text = \"<i class='fa fa-file-pdf-o'></i>\";
                    \$attr = array('title'=> 'Ver PDF', 'target'=> '_blank');
                    \$artify->enqueueBtnActions('artify-button-url', \$action, 'url', \$text, '', \$attr);
                ";
            }
        }

        $actions_buttons_grid_array = explode(',', $actions_buttons_grid);
       
        foreach ($actions_buttons_grid_array as $action) {
            if ($action === 'Imprimir') {
                    $controllerContent .= "
                    \$artify->setSettings('printBtn', true);
                ";
            } else if ($action === 'PDF') {
                    $controllerContent .= "
                    \$artify->setSettings('pdfBtn', true);
                ";
            } else if ($action === 'CSV') {
                    $controllerContent .= "
                    \$artify->setSettings('csvBtn', true);
                ";
            } else if ($action === 'Excel') {
                    $controllerContent .= "
                    \$artify->setSettings('excelBtn', true);
                ";
            }
        }
        
        if($active_popup == 'Si'){
            $controllerContent .= "
                \$artify->formDisplayInPopup();
            ";
        }

        if($activar_edicion_en_linea == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('inlineEditbtn', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('inlineEditbtn', false);
            ";
        }

        if($ocultar_id_tabla == "Si") {
            $controllerContent .= "
                \$artify->setSettings('hideAutoIncrement', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('hideAutoIncrement', false);
            ";
        }

        if($mostrar_columna_acciones_grilla == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('actionbtn', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('actionbtn', false);
            ";
        }

        if( $function_filter_and_search == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('function_filter_and_search', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('function_filter_and_search', false);
            ";
        }

        if($active_search == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('searchbox', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('searchbox', false);
            ";
        }

        // Continue with the remaining settings
        if ($clone_row == 'Si') {
        $controllerContent .= "
                \$artify->setSettings('clonebtn', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('clonebtn', false);
            ";
        }

        if($activate_deleteMultipleBtn == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('checkboxCol', true);
                \$artify->setSettings('deleteMultipleBtn', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('checkboxCol', false);
                \$artify->setSettings('deleteMultipleBtn', false);
            ";
        }

        if($refrescar_grilla == "Si"){
            $controllerContent .= "
                \$artify->setSettings('refresh', true);
            ";
        } else {
            $controllerContent .= "
            \$artify->setSettings('refresh', false);
        ";
        }

        if($button_add == 'Si'){
            $controllerContent .= "
                \$artify->setSettings('addbtn', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('addbtn', false);
            ";
        }

        if($encryption == "Si"){
            $controllerContent .= "
                \$artify->setSettings('encryption', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('encryption', false);
            ";
        }

        if($campos_requeridos == "Si"){
            $controllerContent .= "
                \$artify->setSettings('required', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('required', false);
            ";
        }

        if($mostrar_paginacion == "Si"){
            $controllerContent .= "
                \$artify->setSettings('pagination', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('pagination', false);
            ";
        }

        if($activar_numeracion_columnas == "Si"){
            $controllerContent .= "
                \$artify->setSettings('numberCol', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('numberCol', false);
            ";
        }

        if($activar_registros_por_pagina == "Si"){
            $controllerContent .= "
                \$artify->setSettings('recordsPerPageDropdown', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('recordsPerPageDropdown', false);
            "; 
        }

        if($totalRecordsInfo == "Si"){
            $controllerContent .= "
                \$artify->setSettings('totalRecordsInfo', true);
            ";
        } else {
            $controllerContent .= "
                \$artify->setSettings('totalRecordsInfo', false);
            "; 
        }

        $controllerContent .= "
                \$artify->recordsPerPage({$cantidad_de_registros_por_pagina});
            "; 

        $controllerContent .= "
            \$artify->setSettings('template', 'template_{$nameview}');
            \$render = \$artify->dbTable('{$tableName}')->render();

            View::render('{$nameview}', ['render' => \$render]);
        }";

        foreach ($buttons_actions_array as $Btnaction) {
            if ($Btnaction === 'Personalizado PDF') {
                $controllerContent .= "
                    public function {$tableName}_pdf(){
                        
                        \$docufy = DB::Docufy();
                        \$docufy->setInvoiceDisplaySettings(\"header\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"to\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"from\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"footer\",  \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"payment\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"message\", \"\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"subtotal\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"discount\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"tax\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"shipping\", false);
                        \$docufy->setInvoiceDisplaySettings(\"total\", \"grandtotal\", false);
                        echo \$docufy->render();
                    }
                ";
            }
        }

        $controllerContent .= 
        "\n
        }";

        // Save the generated controller content to a file
        file_put_contents($controllerPath, $controllerContent);
    }

    private function generateViewNotLogin($nameview){
        $viewPath = __DIR__ . '/../Views/' . $nameview . '.php';

        $viewContent = '
        <?php require "layouts/header.php"; ?>
        <?php require "layouts/sidebarNotLogin.php"; ?>
        <link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
        <div class="content-wrapper">
            <section class="content">
                <div class="card mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <?=$render?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
        <div id="artify-ajax-loader">
            <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/artify/images/ajax-loader.gif" class="artify-img-ajax-loader"/>
        </div>
        <?php require "layouts/footer.php"; ?>
        <script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
        <script>
            $(document).on("artify_after_ajax_action", function(event, obj, data){
                var dataAction = obj.getAttribute(\'data-action\');
                var dataId = obj.getAttribute(\'data-id\');

                if(dataAction == "add"){
                
                }

                if(dataAction == "edit"){
                
                }
            });
            $(document).on("artify_after_submission", function(event, obj, data) {
                let json = JSON.parse(data);

                if (json.message) {
                    Swal.fire({
                        icon: "success",
                        text: json["message"],
                        confirmButtonText: "Aceptar",
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".artify-back").click();
                        }
                    });
                }
            });
        </script>';

        file_put_contents($viewPath, $viewContent);
    }

    private function generateView($nameview)
    {
        $viewPath = __DIR__ . '/../Views/' . $nameview . '.php';

        $viewContent = '
        <?php require "layouts/header.php"; ?>
        <?php require "layouts/sidebar.php"; ?>
        <link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
        <div class="content-wrapper">
            <section class="content">
                <div class="card mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <?=$render?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
        <div id="artify-ajax-loader">
            <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/artify/images/ajax-loader.gif" class="artify-img-ajax-loader"/>
        </div>
        <?php require "layouts/footer.php"; ?>
        <script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
        <script>
            $(document).on("artify_after_ajax_action", function(event, obj, data){
                var dataAction = obj.getAttribute(\'data-action\');
                var dataId = obj.getAttribute(\'data-id\');

                if(dataAction == "add"){
                
                }

                if(dataAction == "edit"){
                
                }
            });
            $(document).on("artify_after_submission", function(event, obj, data) {
                let json = JSON.parse(data);

                if (json.message) {
                    Swal.fire({
                        icon: "success",
                        text: json["message"],
                        confirmButtonText: "Aceptar",
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".artify-back").click();
                        }
                    });
                }
            });
        </script>';

        file_put_contents($viewPath, $viewContent);
    }

    private function generateViewAdd($nameview)
    {
        $viewPath = __DIR__ . '/../Views/agregar_' . $nameview . '.php';

        $viewContent = '
        <?php require "layouts/header.php"; ?>
        <?php require "layouts/sidebar.php"; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="card mt-4">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <?=$render?>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
        <div id="artify-ajax-loader">
            <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/artify/images/ajax-loader.gif" class="artify-img-ajax-loader"/>
        </div>
        <?php require "layouts/footer.php"; ?>';

        file_put_contents($viewPath, $viewContent);
    }
}
