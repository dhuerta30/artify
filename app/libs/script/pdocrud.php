<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";

// Cargar variables de entorno antes de iniciar la sesión
$dotenv = DotenvVault\DotenvVault::createImmutable(dirname(__DIR__, 3));
$dotenv->safeLoad();

@session_name($_ENV["APP_NAME"]);
@session_start();
/*enable this for development purpose */
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);
date_default_timezone_set(@date_default_timezone_get());
define('PDOCrudABSPATH', dirname(__FILE__) . '/');
require_once PDOCrudABSPATH . "config/config.php";
spl_autoload_register('pdocrudAutoLoad');

function pdocrudAutoLoad($class) {
    if (file_exists(PDOCrudABSPATH . "classes/" . $class . ".php"))
        require_once PDOCrudABSPATH . "classes/" . $class . ".php";
}

if (isset($_REQUEST["pdocrud_instance"])) {
    $fomplusajax = new PDOCrudAjaxCtrl();
    $fomplusajax->handleRequest();
}

function buscador_tabla($data, $obj, $columnDB = array()) {
    $pdomodel = $obj->getPDOModelObj();
    $tabla = $obj->getLangData("tabla");

    $columnNames = $pdomodel->columnNames($tabla);
 
    $whereClause = "";
 
    if(isset($data["action"]) && $data["action"] == "search"){
        if (isset($data['search_col']) && isset($data['search_text'])) {
                $search_col = $data['search_col'];
                $search_text = $data['search_text'];
             
                // Sanitize inputs to prevent SQL injection
                $search_col = preg_replace('/[^a-zA-Z0-9_]/', '', $search_col);
                $search_text = htmlspecialchars($search_text, ENT_QUOTES, 'UTF-8');
             
            if ($search_text !== '') { 
                if ($search_col !== 'all') {
                    $whereClause = "WHERE $search_col LIKE '%$search_text%'";
                } else {
                    $whereConditions = [];
                    foreach ($columnNames as $columnName) {
                        $whereConditions[] = "$columnName LIKE '%$search_text%'";
                    }
                    $whereClause = "WHERE " . implode(" OR ", $whereConditions);
                }
            }
 
            $query = "SELECT id as ID, name as Name 
            FROM $tabla
            $whereClause";
 
            $obj->setQuery($query);
        }
    }
 
    return $data;
}

function format_sql_col_tabla($data, $obj, $columnDB = array()) {
    $pdomodel = $obj->getPDOModelObj();
    $tabla = $obj->getLangData("tabla");
 
    $columnNames = $pdomodel->columnNames($tabla);
 
    $template = array(
        'colname' => '',
        'tooltip' => '',
        'attr' => '',
        'sort' => '',
        'col' => '',
        'type' => ''
    );
 
    $default_cols = array();
    foreach ($columnDB as $column) {
        // Aplicar la plantilla y ajustar los valores específicos de la columna
        $details = $template;
        $details['colname'] = ucfirst(str_replace('_', ' ', $column));
        $details['col'] = $column;
 
        // Verificar si la columna está en la base de datos
        if (in_array($column, $columnNames)) {
            // Columna existente en la base de datos
            $default_cols[$column] = $details;
        } else {
            // Columna concatenada o que no está en la base de datos
            $default_cols[$column] = $details;
        }
    }

     // Convertir las claves de $data a minúsculas
    $data = array_change_key_case($data, CASE_LOWER);

    // Evitar duplicados y combinar datos de manera controlada
    foreach ($default_cols as $key => $value) {
        if (!array_key_exists($key, $data)) {
            $data[$key] = $value;
        }
    }
 
    return $data;
}

function eliminacion_masiva_tabla($data, $obj){
    $tabla = $obj->getLangData("tabla");
    $pk = $obj->getLangData("pk");
    $pdomodel = $obj->getPDOModelObj();
 
    // Obtener los IDs seleccionados del array
    $selected_ids = $data["selected_ids"];
 
    // Asegurarse de que $selected_ids no esté vacío
    if (!empty($selected_ids)) {
        // Recorrer cada ID y eliminar el producto correspondiente
        foreach ($selected_ids as $id) {
            $pdomodel->where($pk, $id);
            $pdomodel->delete($tabla);
        }
    }
 
    return $data;
}

function eliminar_tabla($data, $obj){
    $tabla = $obj->langData["tabla"];
    $pk = $obj->langData["pk"];
    $pdomodel = $obj->getPDOModelObj();
 
    $id = $data["id"];
 
    if (!empty($id)) {
        $pdomodel->where($pk, $id);
        $pdomodel->delete($tabla);
    }
 
    return $data;
}

function carga_masiva_nmedicos_insertar($data, $obj){
    $archivo = basename($data["carga_masiva_nmedicos"]["archivo"]);
    $extension = pathinfo($archivo, PATHINFO_EXTENSION);

    $pdomodel = $obj->getPDOModelObj();
   
    $rutInvalidos = [];

    if (empty($archivo)) { 
        $error_msg = array("message" => "", "error" => "No se ha subido ningún Archivo", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else {
        if ($extension != "xlsx") { /* comprobamos si la extensión del archivo es diferente de excel */
            //unlink(__DIR__ . "/uploads/".$archivo); /* eliminamos el archivo que se subió */
            $error_msg = array("message" => "", "error" => "El Archivo Subido no es un Archivo Excel Válido", "redirectionurl" => "");
            die(json_encode($error_msg));
        } else {

            $records = $pdomodel->excelToArray("uploads/".$archivo); /* Acá capturamos el nombre del archivo excel a importar */

            $sql = array();
            foreach ($records as $Excelval) {

                $rut_completo = $Excelval['Rut'] . '-' . $Excelval['Dv'];

                if (!App\Controllers\HomeController::validaRut($rut_completo)) {
                    $rutInvalidos[] = $rut_completo;
                } else {

                    $existingMedico = $pdomodel->DBQuery("SELECT * FROM nmedico WHERE rutmedico = :rut", ['rut' => $rut_completo]);

                    if (!$existingMedico) {
                        $sql = array(
                            'nmedico' => $Excelval['Nombre'],
                            'especialidad' => $Excelval['Especialidad'],
                            'rutmedico' => $rut_completo
                        );

                        $pdomodel->insertBatch("nmedico", array($sql));
                    } else {
                        $error_msg = array("message" => "", "error" => "Lo Siguientes Médicos ingresados ya existen: ". implode(", ", $Excelval["Nombre"]), "redirectionurl" => "");
                        die(json_encode($error_msg));
                    }
                }
            }

            if (!empty($rutInvalidos)) {
                $error_msg = array("message" => "", "error" => "Los siguientes Rut inválidos no han sido cargados: " . implode(", ", $rutInvalidos), "redirectionurl" => "");
                die(json_encode($error_msg));
            }
            $data["carga_masiva_nmedicos"]["archivo"] = basename($data["carga_masiva_nmedicos"]["archivo"]);
        }
    }
    return $data;
}


function actualizar_criticosapa($data, $obj){
    $Idsolicitud = $data["criticosapa"]["Idsolicitud"];
    $fecharesultado = $data["criticosapa"]["fecharesultado"];
    $notificado = $data["criticosapa"]["notificado"];

    if($notificado == "si"){
        $pdomodel = $obj->getPDOModelObj();
        $pdomodel->insert("historico_caso", array(
            "tipo" => "6",
            "fecha_y_hora" => $fecharesultado,
            "Id_solicitud" => $Idsolicitud
        ));
    }

    $obj->setLangData("success", "Datos Actualizados con éxito");
    return $data;
}

function actualizar_notificar_paciente($data, $obj){
    $Idsolicitud = $data["criticosapa"]["Idsolicitud"];
    $fecha = $data["criticosapa"]["fecha"];
    $hora = $data["criticosapa"]["hora"];
    $nombre_funcionario = $data["criticosapa"]["nombre_funcionario"];
    $texto_libre = $data["criticosapa"]["texto_libre"];

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->insert("historico_caso", array(
        "tipo" => "5",
        "fecha_y_hora" => $fecha . ' ' . $hora,
        "Id_solicitud" => $Idsolicitud
    ));

    return $data;
}

function formatTableColCallBack($data, $obj){
    // Definir la nueva columna y su valor
    $newColumns = [
        'Imprimir' => [
            'colname' => 'Imprimir', // Nombre visible de la columna
            'tooltip' => '', // Tooltip, si es necesario
            'attr' => '', // Atributos adicionales, si es necesario
            'sort' => '', // Indicar si la columna es ordenable
            'col' => 'imprimir', // Nombre interno de la columna
            'type' => 'text', // Tipo de columna
        ],
        'resultados' => [
            'colname' => 'Resultados', // Nombre visible de la columna
            'tooltip' => '', // Tooltip, si es necesario
            'attr' => '', // Atributos adicionales, si es necesario
            'sort' => '', // Indicar si la columna es ordenable
            'col' => 'resultados', // Nombre interno de la columna
            'type' => 'text', // Tipo de columna
        ],
        'traza' => [
            'colname' => 'Traza', // Nombre visible de la columna
            'tooltip' => '', // Tooltip, si es necesario
            'attr' => '', // Atributos adicionales, si es necesario
            'sort' => '', // Indicar si la columna es ordenable
            'col' => 'traza', // Nombre interno de la columna
            'type' => 'text', // Tipo de columna
        ],
        'edicion' => [
            'colname' => 'Edición', // Nombre visible de la columna
            'tooltip' => '', // Tooltip, si es necesario
            'attr' => '', // Atributos adicionales, si es necesario
            'sort' => '', // Indicar si la columna es ordenable
            'col' => 'edicion', // Nombre interno de la columna
            'type' => 'text', // Tipo de columna
        ]
    ];

    // Agregar las nuevas columnas al array $data
    foreach ($newColumns as $key => $column) {
        $data[$key] = $column;
    }

    return $data;
}

function actualizar_solicitudesapa($data, $obj){
    $obj->setLangData("success", "Datos Actualizados con éxito");
    return $data;
}  

function formatTableDataCallBack($data, $obj){
        // Definir los nombres y valores de las nuevas columnas
        $newColumns = [
        'Imprimir' => function($row){
            return '<a class="btn btn-light btn-sm ver_solicitudes" href="javascript:;" title="Imprimir" data-id="'.$row['Idsolicitud'].'">
                        <i class="fa fa-print"></i>
                    </a>
                    <a class="btn btn-light btn-sm ver_etiquetas" href="javascript:;" title="Etiqueta" data-id="'.$row['Idsolicitud'].'">
                        <i class="fa fa-barcode"></i>
                    </a>';
        },        
        'resultados' => function($row) {
            return '<a class="btn btn-light btn-sm ver_resultado" href="javascript:;" title="Resultado" data-id="'.$row['Idsolicitud'].'">
                        <i class="fa fa-upload"></i>
                    </a>
                    <a class="btn btn-light btn-sm ver_pdf" href="javascript:;" title="PDF" data-id="'.$row['Idsolicitud'].'">
                        <i class="fa fa-file-pdf-o"></i>
                    </a>';
        },
        'traza' => function($row) {
            return '<a class="btn btn-light btn-sm ver_traza" href="javascript:;" title="Traza" data-id="'.$row['Idsolicitud'].'">
                        <i class="fa fa-info-circle"></i>
                    </a>';
        },
        'edicion' => function($row) {
            return '<a class="pdocrud-actions btn btn-warning btn-sm pdocrud-button pdocrud-button-edit" href="javascript:;" title="Editar" data-id="'.$row['Idsolicitud'].'" data-action="edit">
                        <i class="fa fa-pencil-square-o"></i>
                    </a>
                    <a class="btn btn-danger btn-sm eliminar_solicitudes" href="javascript:;" title="Eliminar" data-id="'.$row['Idsolicitud'].'">
                        <i class="fa fa-trash"></i>
                    </a>';
        }
    ];

    // Iterar sobre cada fila de datos y agregar las nuevas columnas
    foreach ($data as &$row) {
        foreach ($newColumns as $colName => $value) {
            if (is_callable($value)) {
                // Si el valor es una función, llámala con la fila actual
                $row[$colName] = $value($row);
            } else {
                // Si el valor no es una función, asígnalo directamente
                $row[$colName] = $value;
            }
        }
    }

    return $data;
}

function actualizar_resultados($data, $obj){
    $Idsolicitud = $data["solicitudesapa"]["Idsolicitud"];
    $estado = $data["solicitudesapa"]["estado"];
    $fecharesultado = $data["solicitudesapa"]["fecharesultado"];
    $nmedico = $data["solicitudesapa"]["nmedico"];
    $critico = $data["solicitudesapa"]["critico"];
    $rut =  $data["solicitudesapa"]["rut"];
    $nombres = $data["solicitudesapa"]["nombres"];
    $apaterno = $data["solicitudesapa"]["apaterno"];
    $amaterno = $data["solicitudesapa"]["amaterno"];
    $resultado = basename($data["solicitudesapa"]["resultado"]);

    $explode = explode('.', $resultado);
    $extension = array_pop($explode);

    if ($extension != "pdf") {
        $error_msg = array("message" => "", "error" => "El Archivo Subido no es un Archivo PDF Válido", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    $fecharesultadoDateTime = DateTime::createFromFormat('Y-m-d\TH:i', $fecharesultado);
    if ($fecharesultadoDateTime) {
        $fecharesultadoMysql = $fecharesultadoDateTime->format('Y-m-d H:i:s');
    } else {
        // Manejar el error si la fecha no tiene el formato esperado
        $fecharesultadoMysql = null; // O puedes elegir otro valor por defecto
    }

    if ($critico == 'si') {
        $pdomodel = $obj->getPDOModelObj();
       
        $pdomodel->insert("criticosapa", array(
            "Id_solicitud" => $Idsolicitud, 
            "rut" => $rut,
            "nombres" => $nombres,
            "apaterno" => $apaterno,
            "amaterno" => $amaterno, 
            "fecharesultado" => $fecharesultado,
            "nmedico" => $nmedico
        ));    
    }

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("Idsolicitud", $Idsolicitud);
    $solicitudes = $pdomodel->select("solicitudesapa");

    $pdomodel->insert("historico_caso", array(
        "tipo" => $solicitudes[0]["estado"],
        "fecha_y_hora" => $fecharesultadoMysql,
        "Id_solicitud" => $Idsolicitud
    ));

    $data["solicitudesapa"]["resultado"] = basename($data["solicitudesapa"]["resultado"]);
    $data["solicitudesapa"]["fecharesultado"] = $fecharesultadoMysql;
    $obj->setLangData("success", "Resultados Actualizados con éxito");
    return $data;
}


function search_table($data, $obj) {
    if (isset($data["action"]) && $data["action"] == "search") {
        if (isset($data['search_col']) && isset($data['search_text'])) {
            $search_col = $data['search_col'];
            $search_text = $data['search_text'];

            // Limpiar condiciones previas
            $obj->clearWhereConditions();

            // Si se busca por 'all', aplicar condiciones a todas las columnas relevantes
            if ($search_col == 'all') {
                $obj->where("Idsolicitud", "%$search_text%", "LIKE", "OR")
                    ->where("fechatoma", "%$search_text%", "LIKE", "OR")
                    ->where("rut", "%$search_text%", "LIKE", "OR")
                    ->where("CONCAT(nombres, ' ', apaterno, ' ', amaterno)", "%$search_text%", "LIKE", "OR")
                    ->where("tipomuestra", "%$search_text%", "LIKE", "OR")
                    ->where("servicio", "%$search_text%", "LIKE", "OR")
                    ->where("dgclinico", "%$search_text%", "LIKE", "OR")
                    ->where("organo", "%$search_text%", "LIKE", "OR")
                    ->where("nmedico", "%$search_text%", "LIKE", "OR")
                    ->where("centroderivacion", "%$search_text%", "LIKE", "OR")
                    ->where("estado", "%$search_text%", "LIKE");
                    
            } else {
                // Aplicar condición en la columna específica
                if ($search_col == 'nombres') {
                    $obj->where("CONCAT(nombres, ' ', apaterno, ' ', amaterno)", "%$search_text%", "LIKE");
                } else {
                    $obj->where($search_col, "%$search_text%", "LIKE");
                }
            }
        }
    }
    return $data;
}


function beforeTableDataCallBackCriticos($data, $obj){
    if(isset($data['search_col']) && $data['search_col'] == 'all'){
        $obj->setSearchOperator("LIKE");

        if (isset($data['search_text'])) {
            $date = DateTime::createFromFormat('d-m-Y H:i:s', $data['search_text']);

            // Si se ha logrado convertir a una fecha válida
            if ($date) {
                $data['search_text'] = $date->format('Y-m-d H:i:s');
            }
        }
    }

    return $data;
}

function despues_de_insertar_solicitudesapa($data, $obj){
    $id = $data;   
    $pdomodel = $obj->getPDOModelObj();

    $pdomodel->where("Idsolicitud", $id);
    $solicitudes = $pdomodel->select("solicitudesapa");

    $pdomodel->insert("historico_caso", array(
        "tipo" => $solicitudes[0]["estado"],
        "fecha_y_hora" => $solicitudes[0]["fecharegistro"],
        "Id_solicitud" => $id
    ));

    return $data;
}

function agregar_detalle_muestra($data, $obj){
    $run = $data["solicitudesapa"]["rut"];
    if (!App\Controllers\HomeController::validaRut($run)) {
        $error_msg = array("message" => "", "error" => "El Run Ingresado no es Válido", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    $obj->setLangData("success", "Datos Guardados con éxito");
    
    return $data;
}

function seleccionar_solicitudesapa($data, $obj){
    $id = isset($_POST["id"]) ? explode(",", $_POST["id"]) : array();
    $estado = $data["solicitudesapa"]["estado"];
    $fechaderivacion = $data["solicitudesapa"]["fechaderivacion"];

    if(empty($_POST["id"])){
        $error_msg = array("message" => "", "error" => "El campo Ingreso de Ids es Requerido", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    if(empty($estado)){
        $error_msg = array("message" => "", "error" => "El campo Estado es Requerido", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    if(empty($fechaderivacion)){
        $error_msg = array("message" => "", "error" => "El campo Fecharecepcion es Requerido", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    $pdomodel = $obj->getPDOModelObj();
    foreach ($id as $Idsolicitud) {
        $pdomodel->where("Idsolicitud", $Idsolicitud);
        $pdomodel->update("solicitudesapa", array(
            "estado" => $estado, 
            "fechaderivacion" => $fechaderivacion
        ));

        $pdomodel->insert("historico_caso", array(
            "tipo" => $estado,
            "fecha_y_hora" => $fechaderivacion,
            "Id_solicitud" => $Idsolicitud
        ));
    }

    $obj->setLangData("success", "Registros actualizados correctamente");

    $newdata = array();
    $newdata["solicitudesapa"]["estado"] = $estado;
    $newdata["solicitudesapa"]["fechaderivacion"] = $fechaderivacion;

    return $newdata;
}

function seleccionar_solicitudesapa_derivacion($data, $obj){
    $id = isset($_POST["id"]) ? explode(",", $_POST["id"]) : array();
    $estado = $data["solicitudesapa"]["estado"];
    $fechaderivacion = $data["solicitudesapa"]["fechaderivacion"];
    $centroderivacion = $data["solicitudesapa"]["centroderivacion"];

    if(empty($_POST["id"])) {
        $error_msg = array("message" => "", "error" => "El campo Ingreso de Ids es Requerido", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    if(empty($estado)){
        $error_msg = array("message" => "", "error" => "El campo Estado es Requerido", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    if(empty($fechaderivacion)){
        $error_msg = array("message" => "", "error" => "El campo fechaderivacion es Requerido", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    if(empty($centroderivacion)){
        $error_msg = array("message" => "", "error" => "El campo centroderivacion es Requerido", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    $pdomodel = $obj->getPDOModelObj();
    foreach ($id as $Idsolicitud) {
        $pdomodel->where("Idsolicitud", $Idsolicitud);
        $pdomodel->update("solicitudesapa", array(
            "estado" => $estado, 
            "fechaderivacion" => $fechaderivacion, 
            "centroderivacion" => $centroderivacion
        ));

        $pdomodel->insert("historico_caso", array(
            "tipo" => $estado,
            "fecha_y_hora" => $fechaderivacion,
            "Id_solicitud" => $Idsolicitud
        ));
    }

    $obj->setLangData("success", "Registros actualizados correctamente");

    $newdata = array();
    $newdata["solicitudesapa"]["estado"] = $estado;
    $newdata["solicitudesapa"]["fechaderivacion"] = $fechaderivacion;

    return $newdata;
}

function actualizar_configuracion($data, $obj){
    $data["configuracion_general"]["logo_login"] = basename($data["configuracion_general"]["logo_login"]);
    $data["configuracion_general"]["imagen_de_fondo_login"] = basename($data["configuracion_general"]["imagen_de_fondo_login"]);
    $data["configuracion_general"]["imagen_de_carga"] = basename($data["configuracion_general"]["imagen_de_carga"]);
    return $data;
}

function agregar_menu($data, $obj){
    $id_menu = $data;
    $id_usuario_session = $_SESSION["usuario"][0]["id"];

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->insert("usuario_menu", array("id_menu" => $id_menu, "id_usuario" => $id_usuario_session, "visibilidad_menu" => "Mostrar"));

    return $data;
}

function despues_insertar_submenu($data, $obj){
    $id_submenu = $data;
    $id_usuario_session = $_SESSION["usuario"][0]["id"];

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("id_submenu", $id_submenu);
    $id_menu = $pdomodel->select("submenu");
    $pdomodel->insert("usuario_submenu", array("id_menu" => $id_menu[0]["id_menu"], "id_submenu" => $id_submenu, "id_usuario" => $id_usuario_session, "visibilidad_submenu" => "Mostrar"));

    return $data;
}

function eliminar_menu($data, $obj){
    $id_menu = $data["id"];
    $id_usuario_session = $_SESSION["usuario"][0]["id"];
    
    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("id_menu", $id_menu);
    $pdomodel->where("id_usuario", $id_usuario_session);
    $pdomodel->delete("usuario_menu");

    $pdomodel->where("id_menu", $id_menu);
    $id_menu_db = $pdomodel->select("submenu");

    if($id_menu_db){
        $pdomodel->where("id_submenu", $id_menu_db[0]["id_submenu"]);
        $pdomodel->delete("submenu");

        $pdomodel->where("id_menu", $id_menu);
        $pdomodel->where("id_usuario", $id_usuario_session);
        $pdomodel->delete("usuario_submenu");
    }

    if(!$id_menu_db){
        $pdomodel->where("id_menu", $id_menu_db[0]["id_menu"]);
        $pdomodel->update("menu", array("submenu" => "No"));
    }

    return $data;
}

function eliminar_submenu($data, $obj){
    $id_submenu = $data["id"];
    $id_usuario_session = $_SESSION["usuario"][0]["id"];

    $pdomodel = $obj->getPDOModelObj();

    $pdomodel->where("id_submenu", $id_submenu);
    $id_menu = $pdomodel->select("submenu");

    $result = $pdomodel->DBQuery("SELECT COUNT(*) AS total FROM submenu WHERE id_menu = :id_menu", [":id_menu" => $id_menu[0]["id_menu"]]);

    $num_submenus = $result[0]["total"];

    if ($num_submenus == 0) {
        $pdomodel->where("id_menu", $id_menu[0]["id_menu"]);
        $pdomodel->update("menu", array("submenu" => "No"));
    }

    $pdomodel->where("id_submenu", $id_submenu);
    $pdomodel->where("id_usuario", $id_usuario_session);
    $pdomodel->delete("usuario_submenu");

    return $data;
}

function carga_masiva_prestaciones_insertar($data, $obj){
    $archivo = basename($data["carga_masiva_prestaciones"]["archivo"]);

    $explode = explode('.', $archivo);
    $extension = array_pop($explode);

    $pdomodel = $obj->getPDOModelObj();
   
    if (empty($archivo)) { 
        $error_msg = array("message" => "", "error" => "No se ha subido ningún Archivo", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else {
        if ($extension != "xlsx") { /* comprobamos si la extensión del archivo es diferente de excel */
            unlink(__DIR__ . "/uploads/".$archivo); /* eliminamos el archivo que se subió */
            $error_msg = array("message" => "", "error" => "El Archivo Subido no es un Archivo Excel Válido", "redirectionurl" => "");
            die(json_encode($error_msg));

        } else {

            $records = $pdomodel->excelToArray("uploads/".$archivo); /* Acá capturamos el nombre del archivo excel a importar */

            $sql = array();
            foreach ($records as $Excelval) {
                $sql['tipo_solicitud'] = $Excelval['TIPO SOLICITUD'];
                $sql['especialidad'] = $Excelval['ESPECIALIDAD'];
                $sql['tipo_de_examen'] = $Excelval['TIPO DE EXAMEN'];
                $sql['examen'] = $Excelval['EXAMEN'];
                $sql['codigo_fonasa'] = $Excelval['CODIGO FONASA'];
                $sql['glosa'] = $Excelval['GLOSA'];

                $pdomodel->insertBatch("prestaciones", array($sql));
            }
            $data["carga_masiva_prestaciones"]["archivo"] = basename($data["carga_masiva_prestaciones"]["archivo"]);
        }
    }
    return $data;
}

function insertar_detalle_solicitud($data, $obj){
    return $data;
}

function insertar_procedimientos($data, $obj){
    $rut = $data["procedimiento"]["rut"];
    $fecha_solicitud = $data["procedimiento"]["fecha_solicitud"];
    $especialidad = $data["procedimiento"]["procedimiento"];
    $procedimiento_2 = $data["procedimiento"]["procedimiento_2"];
    $servicio = $data["procedimiento"]["servicio"];
    $fecha_registro = $data["procedimiento"]["fecha_registro"];
    $nombres = $data["procedimiento"]["nombres"];
    $apellido_paterno = $data["procedimiento"]["apellido_paterno"];
    $apellido_materno = $data["procedimiento"]["apellido_materno"];
    $operacion = $data["procedimiento"]["operacion"];
    $profesional_solicitante = $data["procedimiento"]["profesional_solicitante"];
    $numero_contacto = $data["procedimiento"]["numero_contacto"];
    $numero_contacto_2 = $data["procedimiento"]["numero_contacto_2"];
    $prioridad = $data["procedimiento"]["prioridad"];

    if(empty($rut) && empty($especialidad) && empty($procedimiento_2) && empty($servicio) && empty($nombres) && empty($apellido_paterno) && empty($apellido_materno) && empty($operacion) && empty($profesional_solicitante) && empty($numero_contacto) && empty($numero_contacto_2) && empty($prioridad)){
        $error_msg = array("message" => "", "error" => "Todos los campos son obligatorios", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    $newdata = array();
    $newdata["procedimiento"]["rut"] = $rut;
    $newdata["procedimiento"]["fecha_solicitud"] = $fecha_solicitud;
    $newdata["procedimiento"]["procedimiento"] = $procedimiento;
    $newdata["procedimiento"]["procedimiento_2"] = $procedimiento_2;
    $newdata["procedimiento"]["servicio"] = $servicio;
    $newdata["procedimiento"]["fecha_registro"] = $fecha_registro;
    $newdata["procedimiento"]["nombres"] = $nombres;
    $newdata["procedimiento"]["apellido_paterno"] = $apellido_paterno;
    $newdata["procedimiento"]["apellido_materno"] = $apellido_materno;
    $newdata["procedimiento"]["operacion"] = $operacion;
    $newdata["procedimiento"]["profesional_solicitante"] = $profesional_solicitante;
    $newdata["procedimiento"]["numero_contacto"] = $numero_contacto;
    $newdata["procedimiento"]["numero_contacto_2"] = $numero_contacto_2;
    $newdata["procedimiento"]["prioridad"] = $prioridad;

    return $newdata;
}

function delete_file_data($data, $obj)
{
    $id = $data['id'];
    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->fetchType = "OBJ";
    $pdomodel->where("id", $id);
    $result = $pdomodel->select("backup");

    $file_sql = $result[0]->archivo;

    $file_crop = "uploads/".$file_sql;

    if (file_exists($file_crop)) {
        unlink($file_crop);
        echo "<script>
        Swal.fire({
            title: 'Genial!',
            text: 'Respaldo Eliminado con éxito',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
        </script>";
    }
    return $data;
}

function eliminar_detalle_solicitud($data, $obj){
    /*$id = $data["id"];
    
    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("id_detalle_de_solicitud", $id);
    $result = $pdomodel->select("detalle_de_solicitud");
    
    $id_datos_paciente = $result[0]["id_datos_paciente"];
    $pdomodel->where("id_datos_paciente", $id_datos_paciente);
    $pdomodel->delete("diagnostico_antecedentes_paciente");*/
    return $data;
}

function before_sql_data_estat($data, $obj){
    //print_r($data);
    return $data;
}

/*function editar_procedimientos($data, $obj){
    $id_datos_paciente = $data['datos_paciente']['id_datos_paciente'];
    $estado = $data["detalle_de_solicitud"]["estado"];
    $fecha = $data["detalle_de_solicitud"]["fecha"];
    $fecha_solicitud = $data["detalle_de_solicitud"]["fecha_solicitud"];
    $fundamento = $data['diagnostico_antecedentes_paciente']['fundamento'];
    $adjuntar = $data['diagnostico_antecedentes_paciente']['adjuntar'];
    $id_detalle_de_solicitud = $data["detalle_de_solicitud"]["id_detalle_de_solicitud"];
    $id_diagnostico_antecedentes_paciente = $data["diagnostico_antecedentes_paciente"]["id_diagnostico_antecedentes_paciente"];
 
    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("id_detalle_de_solicitud", $id_detalle_de_solicitud, "=");
    $data_detalle = $pdomodel->select("detalle_de_solicitud");
   
    $pdomodel->where("id_diagnostico_antecedentes_paciente", $id_diagnostico_antecedentes_paciente, "=");
    $data_diagnostico = $pdomodel->select("diagnostico_antecedentes_paciente");
    
    if($data_detalle && $data_diagnostico){
        $pdomodel->where("id_detalle_de_solicitud", $id_detalle_de_solicitud, "=", "AND");
        $pdomodel->update("detalle_de_solicitud", array("fecha" => $fecha, "estado" => $estado));

        $pdomodel->where("id_diagnostico_antecedentes_paciente", $id_diagnostico_antecedentes_paciente);
        $pdomodel->update("diagnostico_antecedentes_paciente", array("fundamento" => $fundamento, "adjuntar" => basename($adjuntar)));

        $success = array("message" => "Operación realizada con éxito", "error" => [], "redirectionurl" => "");
        die(json_encode($success));
    }

    $newdata = array();
    $newdata['datos_paciente']['id_datos_paciente'] = $id_datos_paciente;
    $newdata['diagnostico_antecedentes_paciente']['estado'] = $estado;
    $newdata['diagnostico_antecedentes_paciente']['diagnostico'] = $data['diagnostico_antecedentes_paciente']['diagnostico'];

    return $newdata;
}*/

function editar_procedimientos($data, $obj){
    $id_datos_paciente = $data["datos_paciente"]["id_datos_paciente"];
    $estado = $data["detalle_de_solicitud"]["estado"];
    $fecha = $data["detalle_de_solicitud"]["fecha"];
    $fecha_solicitud = $data["detalle_de_solicitud"]["fecha_solicitud"];
    $adjuntar = $data["diagnostico_antecedentes_paciente"]["adjuntar"];
    $diagnostico = $data["diagnostico_antecedentes_paciente"]["diagnostico"];
    $fundamento = $data["diagnostico_antecedentes_paciente"]["fundamento"];

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->columns = array("fecha", "datos_paciente.id_datos_paciente", "fecha_solicitud", "diagnostico", "fundamento", "adjuntar", "estado");
    $pdomodel->joinTables("detalle_de_solicitud", "detalle_de_solicitud.id_datos_paciente = datos_paciente.id_datos_paciente", "INNER JOIN");
    $pdomodel->joinTables("diagnostico_antecedentes_paciente", "diagnostico_antecedentes_paciente.id_datos_paciente = datos_paciente.id_datos_paciente", "INNER JOIN");

    // Filtrar por ID y Fecha
    $pdomodel->where("datos_paciente.id_datos_paciente", $id_datos_paciente);
    $pdomodel->where("detalle_de_solicitud.fecha_solicitud", $fecha_solicitud);

    // Condiciones para verificar si los valores son diferentes
    $pdomodel->where("detalle_de_solicitud.estado", $estado, "=");
    $pdomodel->where("detalle_de_solicitud.fecha", $fecha, "=");
    $pdomodel->where("diagnostico_antecedentes_paciente.diagnostico", $diagnostico, "=");
    $pdomodel->where("diagnostico_antecedentes_paciente.fundamento", $fundamento, "=");
    $pdomodel->where("diagnostico_antecedentes_paciente.adjuntar", $adjuntar, "=");

     // Seleccionar para verificar si existen registros con condiciones diferentes
    $result = $pdomodel->select("datos_paciente");
    
    if ($result) {
        $error_msg = array("message" => "", "error" => "Modifique los campos para actualizar", "redirectionurl" => "");
        die(json_encode($error_msg));
    }
    
    $pdomodel->where("id_datos_paciente", $id_datos_paciente);
    $pdomodel->where("detalle_de_solicitud.fecha_solicitud", $fecha_solicitud);
    $pdomodel->update("detalle_de_solicitud", array("estado" => $estado, "fecha" => $fecha));
    $pdomodel->update("diagnostico_antecedentes_paciente", array("adjuntar" => $adjuntar, "diagnostico" => $diagnostico, "fundamento" => $fundamento));
    
    return $data;
}


function editar_egresar_solicitud($data, $obj) {
    $id_datos_paciente = $data['datos_paciente']['id_datos_paciente'];
    $fecha_egreso = $data['diagnostico_antecedentes_paciente']['fecha_egreso'];
    $motivo_egreso = $data['diagnostico_antecedentes_paciente']['motivo_egreso'];
    $observacion = $_POST['observacion'];

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("observacion", $observacion, "!=", "AND");
    $pdomodel->where("id_datos_paciente", $id_datos_paciente, "=");
    $data_observacion = $pdomodel->select("detalle_de_solicitud");

    if($data_observacion){
        $pdomodel->where("id_datos_paciente", $id_datos_paciente);
        $pdomodel->update("detalle_de_solicitud", array("observacion" => $observacion));

        $success = array("message" => "Operación realizada con éxito", "error" => [], "redirectionurl" => "");
        die(json_encode($success));
    }

    $newdata = array();
    $newdata['datos_paciente']['id_datos_paciente'] = $id_datos_paciente;
    $newdata['diagnostico_antecedentes_paciente']['fecha_egreso'] = $fecha_egreso;
    $newdata['diagnostico_antecedentes_paciente']['motivo_egreso'] = $motivo_egreso;

    return $newdata;
}


function formatTable_datos_paciente($data, $obj){
    if($data){
        for ($i = 0; $i < count($data); $i++) {
            if($data[$i]["fecha_y_hora_ingreso"] != "0000-00-00 00:00:00"){
                $data[$i]["fecha_y_hora_ingreso"] = "<div class='badge badge-success'>" . $data[$i]["fecha_y_hora_ingreso"] . "</div>";
            } else {
                $data[$i]["fecha_y_hora_ingreso"] = "<div class='badge badge-success'>Sin Fecha</div>";
            }

            if($data[$i]["edad"] == "0"){
                $data[$i]["edad"] = "<div class='badge badge-danger'>Sin Edad</div>";
            } else {
                $data[$i]["edad"] = $data[$i]["edad"];
            }
        }
    }
    return $data;
}

function editar_lista_examenes_notas($data, $obj){
    $id_datos_paciente = $data["datos_paciente"]["id_datos_paciente"];
    $fecha_solicitud = $data["detalle_de_solicitud"]["fecha_solicitud"];
    $observacion = $data["detalle_de_solicitud"]["observacion"];

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->columns = array("datos_paciente.id_datos_paciente", "fecha_solicitud", "observacion");
    $pdomodel->joinTables("detalle_de_solicitud", "detalle_de_solicitud.id_datos_paciente = datos_paciente.id_datos_paciente", "INNER JOIN");

    $pdomodel->where("datos_paciente.id_datos_paciente", $id_datos_paciente, "=", "AND");
    $pdomodel->where("detalle_de_solicitud.fecha_solicitud", $fecha_solicitud);
    
    $pdomodel->where("observacion", $observacion, "=");
    $result = $pdomodel->select("datos_paciente");

    if ($result) {
        $error_msg = array("message" => "", "error" => "Modifique los campos para actualizar", "redirectionurl" => "");
        die(json_encode($error_msg));
    }
    
    $pdomodel->where("id_datos_paciente", $id_datos_paciente);
    $pdomodel->where("detalle_de_solicitud.fecha_solicitud", $fecha_solicitud);
    $pdomodel->update("detalle_de_solicitud", array("observacion" => $observacion));

    return $data;
}


function insertar_generador_pdf($data, $obj){
    $data["generador_pdf"]["logo"] = basename($data["generador_pdf"]["logo"]);
    return $data;
}


function formatTable_buscar_examenes($data, $obj){
    if($data){
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]["nombres"] = ucwords($data[$i]["nombres"]) . " " .  ucwords($data[$i]["apellido_paterno"]) . " " . ucwords($data[$i]["apellido_materno"]);

            if($data[$i]["fecha_y_hora_ingreso"] == "0000-00-00 00:00:00"){
                $data[$i]["fecha_y_hora_ingreso"] = "<div class='badge badge-danger'>Sin Fecha</div>";
            } else {
                $data[$i]["fecha_y_hora_ingreso"] = date('d/m/Y H:i:s', strtotime($data[$i]["fecha_y_hora_ingreso"]));
            }

            if($data[$i]["fecha"] != null){
                $data[$i]["fecha"] = date('d/m/Y', strtotime($data[$i]["fecha"]));
            } else {
                $data[$i]["fecha"] = "<div class='badge badge-danger'>Sin Fecha</div>";
            }

            $data[$i]["profesional"] = ucwords($data[$i]["profesional"]);
        }
    }
    return $data;
}

function insertar_modulos($data, $obj, $id_sesion_usuario = null){
    $tabla = $data["modulos"]["tabla"];
    $id_tabla = isset($data["modulos"]["id_tabla"]) ? $data["modulos"]["id_tabla"] : null;
    $crud_type = $data["modulos"]["crud_type"];
    $query_db = isset($data["modulos"]["query"]) ? $data["modulos"]["query"] : null;
    $controller_name = $data["modulos"]["controller_name"];
    $columns_table = $data["modulos"]["columns_table"];
    $name_view = $data["modulos"]["name_view"];
    $add_menu = $data["modulos"]["add_menu"];
    $template_fields = $data["modulos"]["template_fields"];
    $active_filter = $data["modulos"]["active_filter"];
    $clone_row = $data["modulos"]["clone_row"];
    $active_popup = $data["modulos"]["active_popup"];
    $active_search = $data["modulos"]["active_search"];
    $activate_deleteMultipleBtn = $data["modulos"]["activate_deleteMultipleBtn"];
    $button_add = $data["modulos"]["button_add"];
    $actions_buttons_grid = $data["modulos"]["actions_buttons_grid"];

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("tabla", $tabla);
    $db_result = $pdomodel->select("modulos");

    if($db_result){
        echo "Lo siento La Tabla Ingresada ya existe, pruebe con otra diferente";
        die();
    }

    if($add_menu == "Si"){
        $datamenu = $pdomodel->DBQuery("SELECT MAX(orden_menu) as orden FROM menu");
		$newOrdenMenu = $datamenu[0]["orden"] + 1;

        $pdomodel->insert("menu", array(
            "nombre_menu" => $controller_name, 
            "url_menu" => "/".$controller_name."/index",
            "icono_menu" => "far fa-circle", 
            "submenu" => "No",
            "orden_menu" => $newOrdenMenu
        ));

        $id_menu = $pdomodel->lastInsertId;

        $pdomodel->insert("usuario_menu", array(
            "id_usuario" => $id_sesion_usuario,
            "id_menu" => $id_menu,
            "visibilidad_menu" => "Mostrar"
        ));
    }

    if($crud_type == "SQL"){
        $crudService = new App\Services\CrudService();
        $tableName = $tabla;
        $idTable = $id_tabla;
        $crudType = $crud_type;
        $query = $query_db;
        $controllerName = $controller_name;
        $columns = $columns_table;
        $nameview = $name_view;
        $template_html = $template_fields;
        $crudService->createCrud($tableName, $idTable, $crudType, $query, $controllerName, $columns, $nameview, $template_html, $active_filter, $clone_row);
    }

    if($crud_type == "CRUD"){
        $crudService = new App\Services\CrudService();
        $tableName = $tabla;
        $crudType = $crud_type;
        $controllerName = $controller_name;
        $columns = $columns_table;
        $nameview = $name_view;
        $template_html = $template_fields;
        $crudService->createCrud($tableName, null, $crudType, null, $controllerName, $columns, $nameview, $template_html, $active_filter, $clone_row, $active_popup, $active_search, $activate_deleteMultipleBtn, $button_add, $actions_buttons_grid);
    }

    $data["modulos"]["id_menu"] = $id_menu;
    $data["modulos"]["controller_name"] = ucfirst($controller_name);
    return $data;
}


function actualizar_modulos($data, $obj){
    $tabla = $data["modulos"]["tabla"];
    $id_tabla = isset($data["modulos"]["id_tabla"]) ? $data["modulos"]["id_tabla"] : null;
    $crud_type = $data["modulos"]["crud_type"];
    $query_db = isset($data["modulos"]["query"]) ? $data["modulos"]["query"] : null;
    $controller_name = $data["modulos"]["controller_name"];
    $columns_table = $data["modulos"]["columns_table"];
    $name_view = $data["modulos"]["name_view"];
    $add_menu = $data["modulos"]["add_menu"];
    $template_fields = $data["modulos"]["template_fields"];
    $active_filter = $data["modulos"]["active_filter"];
    $clone_row = $data["modulos"]["clone_row"];
    $active_popup = $data["modulos"]["active_popup"];
    $active_search = $data["modulos"]["active_search"];
    $activate_deleteMultipleBtn = $data["modulos"]["activate_deleteMultipleBtn"];
    $button_add = $data["modulos"]["button_add"];
    $actions_buttons_grid = $data["modulos"]["actions_buttons_grid"];
    $modify_query = $data["modulos"]["modify_query"];

    $pdomodel = $obj->getPDOModelObj();

    if($add_menu == "Si"){
        $datamenu = $pdomodel->DBQuery("SELECT MAX(orden_menu) as orden FROM menu");
		$newOrdenMenu = $datamenu[0]["orden"] + 1;

        $pdomodel->insert("menu", array(
            "nombre_menu" => $controller_name, 
            "url_menu" => "/".$controller_name."/index",
            "icono_menu" => "far fa-circle", 
            "submenu" => "No",
            "orden_menu" => $newOrdenMenu
        ));

        $id_menu = $pdomodel->lastInsertId;

        $pdomodel->insert("usuario_menu", array(
            "id_usuario" => $id_sesion_usuario,
            "id_menu" => $id_menu,
            "visibilidad_menu" => "Mostrar"
        ));
    }

    if($crud_type == "SQL"){
        $crudService = new App\Services\CrudService();
        $tableName = $tabla;
        $idTable = $id_tabla;
        $crudType = $crud_type;
        $query = $query_db;
        $controllerName = $controller_name;
        $columns = $columns_table;
        $nameview = $name_view;
        $template_html = $template_fields;
        $crudService->createCrud($tableName, $idTable, $crudType, $query, $controllerName, $columns, $nameview, $template_html, $active_filter, $clone_row);
    }

    if($crud_type == "CRUD"){
        $crudService = new App\Services\CrudService();
        $tableName = $tabla;
        $crudType = $crud_type;
        $controllerName = $controller_name;
        $columns = $columns_table;
        $nameview = $name_view;
        $template_html = $template_fields;
        $crudService->createCrud(
            $tableName, 
            null, 
            $crudType, 
            null, 
            $controllerName, 
            $columns, 
            $nameview, 
            $template_html, 
            $active_filter, 
            $clone_row, 
            $active_popup, 
            $active_search, 
            $activate_deleteMultipleBtn, 
            $button_add, 
            $actions_buttons_grid, 
            $modify_query
        );
    }

    $data["modulos"]["id_menu"] = $id_menu;
    $data["modulos"]["controller_name"] = ucfirst($controller_name);
    return $data;
}


function eliminar_modulos($data, $obj)
{
    $id = $data["id"];
    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("id_modulos", $id);
    $query = $pdomodel->select("modulos");

    $id_menu = $query[0]["id_menu"];

    if (empty($query)) {
       echo "No se encontró ningún módulo con el ID proporcionado.";
    }

    $pdomodel->where("id_menu", $id_menu);
    $pdomodel->delete("menu");

    $pdomodel->where("id_menu", $id_menu);
    $pdomodel->delete("usuario_menu");

    $tabla = $query[0]["tabla"];
    $controller_name = $query[0]["controller_name"];
    $nameview = $query[0]["name_view"];

    $controllerFilePath = dirname(__DIR__, 3) . '/app/Controllers/' . $controller_name . 'Controller.php';
    $viewFilePath =  dirname(__DIR__, 3) . '/app/Views/' . $nameview . '.php';
    $viewFilePathEdit =  dirname(__DIR__, 3) . '/app/Views/editar_' . $nameview . '.php';
    $viewFilePathAdd =  dirname(__DIR__, 3) . '/app/Views/agregar_' . $nameview . '.php';

    $filesToDelete = [$controllerFilePath, $viewFilePath, $viewFilePathEdit, $viewFilePathAdd];

    foreach ($filesToDelete as $filePath) {
        if ($filePath && file_exists($filePath)) {
            try {
                if (unlink($filePath)) {
                    echo "Archivo eliminado con éxito";
                } else {
                    echo "Error al eliminar el archivo.";
                }
            } catch (Exception $e) {
                echo "Error al intentar eliminar el archivo $filePath:". $e->getMessage();
            }
        } else {
            echo "El archivo no existe";
        }
    }

    // Función para eliminar un directorio completo y su contenido
    function eliminar_directorio_completo($dir)
    {
        if (!file_exists($dir)) {
            return false;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $filePath = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($filePath)) {
                eliminar_directorio_completo($filePath); // Llamada recursiva
            } else {
                unlink($filePath);
            }
        }

        return rmdir($dir);
    }

    $templaesCrudDirPath = dirname(__DIR__, 3) . '/app/libs/script/classes/templates/template_' . $nameview . '/';
    if (file_exists($templaesCrudDirPath) && is_dir($templaesCrudDirPath)) {
        try {
            if (eliminar_directorio_completo($templaesCrudDirPath)) {
                echo "Directorio eliminado con éxito:";
            } else {
                echo "Error al eliminar el directorio: $templaesCrudDirPath";
            }
        } catch (Exception $e) {
            echo "Error al intentar eliminar el directorio: " . $e->getMessage();
        }
    } else {
        echo "El directorio no existe: $templaesCrudDirPath";
    }

    $pdomodel->dropTable($tabla);

    return $data;
}

function editar_perfil($data, $obj){
    $token = $_POST['auth_token'];
    $valid = App\core\Token::verifyFormToken('send_message', $token);
    if (!$valid) {
        echo "El token recibido no es válido";
        die();
    }

    $id     = $data["usuario"]["id"];
    $nombre = $data["usuario"]["nombre"];
    $email  = $data["usuario"]["email"];
    $user   = $data["usuario"]["usuario"];
    $clave  = $data["usuario"]["password"];
    $rol    = $data["usuario"]["idrol"];

    if(empty($nombre)){
        $error_msg = array("message" => "", "error" => "El campo Nombre Completo es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($email)){
        $error_msg = array("message" => "", "error" => "El campo Correo Electrónico es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($user)){
        $error_msg = array("message" => "", "error" => "El campo Usuario es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($clave)){
        $error_msg = array("message" => "", "error" => "El campo Clave de acceso es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($rol)){
        $error_msg = array("message" => "", "error" => "El campo Rol es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    $pdomodel = $obj->getPDOModelObj();
    $result = $pdomodel->DBQuery("SELECT * FROM usuario WHERE (usuario = :user OR email = :email) AND id != :id", [':user' => $user, ':email' => $email, ':id' => $id]);

    if($result){
        $error_msg = array("message" => "", "error" => "El correo o el usuario ya existe.", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else {

        if(empty($clave)){
            $error_msg = array("message" => "", "error" => "Ingresa una clave para guardar tus datos.", "redirectionurl" => "");
            die(json_encode($error_msg));
        }

        $newdata = array();
        $newdata["usuario"]["nombre"] = $nombre;
        $newdata["usuario"]["usuario"] = $user;
        $newdata["usuario"]["email"] = $email;
        $newdata["usuario"]["avatar"] = basename($data["usuario"]["avatar"]);
        $newdata["usuario"]["password"] = password_hash($clave, PASSWORD_DEFAULT);
        $newdata["usuario"]["token"] = $token;
        $newdata["usuario"]["expiration_token"] = 0;
        $newdata["usuario"]["idrol"] = $rol;
        $newdata["usuario"]["estatus"] = 1;

        return $newdata;
    }
}

function insetar_usuario($data, $obj){
    $token = $_POST['auth_token'];
    $valid = App\core\Token::verifyFormToken('send_message', $token);
    if (!$valid) {
        echo "El token recibido no es válido";
        die();
    }

    $nombre = $data["usuario"]["nombre"];
    //$rut = $data["usuario"]["rut"];
    $email  = $data["usuario"]["email"];
    $user   = $data["usuario"]["usuario"];
    $clave  = $data["usuario"]["password"];
    $rol    = $data["usuario"]["idrol"];
    $avatar = $data["usuario"]["avatar"];

    if(empty($nombre)){
        $error_msg = array("message" => "", "error" => "El campo Nombre Completo es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    /*} else if(empty($rut)){
        $error_msg = array("message" => "", "error" => "El campo Rut es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));*/
    } else if(empty($email)){
        $error_msg = array("message" => "", "error" => "El campo Correo Electrónico es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($user)){
        $error_msg = array("message" => "", "error" => "El campo Usuario es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($clave)){
        $error_msg = array("message" => "", "error" => "El campo Clave de acceso es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($rol)){
        $error_msg = array("message" => "", "error" => "El campo Rol es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    $pdomodel = $obj->getPDOModelObj();
    $result = $pdomodel->DBQuery("SELECT * FROM usuario WHERE usuario = '$user' OR email = '$email'");

    if($result){
        $error_msg = array("message" => "", "error" => "El correo o el usuario ya existe.", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else {
        $newdata = array();
        $newdata["usuario"]["nombre"] = $nombre;
        //$newdata["usuario"]["rut"] = $rut;
        $newdata["usuario"]["usuario"] = $user;
        $newdata["usuario"]["email"] = $email;
        if (empty($avatar)) {
            $image = PDOCrudABSPATH . 'uploads/1710162578_user.png';
            $newdata["usuario"]["avatar"] =  basename($image);
        } else {
            $newdata["usuario"]["avatar"] = basename($avatar);
        }
        $newdata["usuario"]["password"] = password_hash($clave, PASSWORD_DEFAULT);
        $newdata["usuario"]["token"] = $token;
        $newdata["usuario"]["expiration_token"] = 0;
        $newdata["usuario"]["idrol"] = $rol;
        $newdata["usuario"]["estatus"] = 1;

        return $newdata;
    }
}

function editar_usuario($data, $obj){
    $token = $_POST['auth_token'];
    $valid = App\core\Token::verifyFormToken('send_message', $token);
    if (!$valid) {
        echo "El token recibido no es válido";
        die();
    }

    $id     = $data["usuario"]["id"];
    $nombre = $data["usuario"]["nombre"];
    $rut    = $data["usuario"]["rut"];
    $email  = $data["usuario"]["email"];
    $clave  = $data["usuario"]["password"];
    $user   = $data["usuario"]["usuario"];
    $rol    = $data["usuario"]["idrol"];

    
    if(empty($nombre)){
        $error_msg = array("message" => "", "error" => "El campo Nombre Completo es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($rut)){
        $error_msg = array("message" => "", "error" => "El campo Rut es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($email)){
        $error_msg = array("message" => "", "error" => "El campo Correo Electrónico es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($user)){
        $error_msg = array("message" => "", "error" => "El campo Usuario es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($clave)){
        $error_msg = array("message" => "", "error" => "El campo Clave de acceso es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else if(empty($rol)){
        $error_msg = array("message" => "", "error" => "El campo Rol es obligatorio", "redirectionurl" => "");
        die(json_encode($error_msg));
    }

    $pdomodel = $obj->getPDOModelObj();
    $result = $pdomodel->DBQuery("SELECT * FROM usuario WHERE (usuario = :user OR email = :email) AND id != :id", [':user' => $user, ':email' => $email, ':id' => $id]);
    
    if ($result) {
        $error_msg = array("message" => "", "error" => "El correo o el usuario ya existe.", "redirectionurl" => "");
        die(json_encode($error_msg));
    } else {
        $newdata = array();
        $newdata["usuario"]["id"] = $id;
        $newdata["usuario"]["nombre"] = $nombre;
        $newdata["usuario"]["rut"] = $rut;
        $newdata["usuario"]["usuario"] = $user;
        $newdata["usuario"]["email"] = $email;
        $newdata["usuario"]["avatar"] = basename($data["usuario"]["avatar"]);
        $newdata["usuario"]["password"] = password_hash($clave, PASSWORD_DEFAULT);
        $newdata["usuario"]["token"] = $token;
        $newdata["usuario"]["expiration_token"] = 0;
        $newdata["usuario"]["idrol"] = $rol;
        $newdata["usuario"]["estatus"] = 1;

        return $newdata;
    }
}

//example of how to add action function
function beforeloginCallback($data, $obj) {  

    $pass = $data['usuario']['password'];
    $user = $data['usuario']['usuario'];

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("usuario", $user);
    $hash = $pdomodel->select("usuario");

    if($hash){
        if (password_verify($pass, $hash[0]['password'])) {
            @session_start();
            $_SESSION["data"] = $data;
            $obj->setLangData("no_data", "Bienvenido");
            $obj->formRedirection($_ENV['URL_PDOCRUD']."home/datos_paciente");
        } else {
            echo "El usuario o la contraseña ingresada no coinciden";
            die();
        }
    } else {
        echo "Datos erroneos";
        die();
    }

    return $data;
}
 
function insertar_submenu($data, $obj){
    $id_menu = $data["submenu"]["id_menu"];
   
    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("id_menu", $id_menu);
    $result = $pdomodel->select("menu");
    
    if($result){
        $pdomodel->where("id_menu", $id_menu);
        $pdomodel->update("menu", array("submenu"=> "Si"));
    }
    return $data;
}

function modificar_submenu($data, $obj){
    $id_menu = $data["submenu"]["id_menu"];
   
    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("id_menu", $id_menu);
    $result = $pdomodel->select("menu");
    
    if($result){
        $pdomodel->where("id_menu", $id_menu);
        $pdomodel->update("menu", array("submenu"=> "Si"));
    }
    return $data;
}
 
function formatTableMenu($data, $obj){
    if($data){
        for ($i = 0; $i < count($data); $i++) {

            if($data[$i]["submenu"] == "No"){
                $data[$i]["submenu"] = "<div class='badge badge-danger'>".$data[$i]["submenu"]."</div>";
            } else {
                $data[$i]["submenu"] = "<div class='badge badge-success'>".$data[$i]["submenu"]."</div>";
            }

            $data[$i]["orden_menu"] = "<div class='badge badge-success'>".$data[$i]["orden_menu"]."</div>";

            $data[$i]["icono_menu"] = "<i style='font-size: 20px;' class='".$data[$i]["icono_menu"]."'></i>";
            
        }
    }
    return $data;
}


function formatTableSolicitudesapa($data, $obj){
    if($data){
        for ($i = 0; $i < count($data); $i++) {

            if($data[$i]["estado"] == "Resultado"){
                $data[$i]["estado"] = "<div class='badge badge-success'>".$data[$i]["estado"]."</div>";
            } else if($data[$i]["estado"] == "Recepcionado"){
                $data[$i]["estado"] = "<div class='badge badge-warning'>".$data[$i]["estado"]."</div>";
            } else if($data[$i]["estado"] == "Solicitado"){
                $data[$i]["estado"] = "<div class='badge badge-secondary'>".$data[$i]["estado"]."</div>";
            } else {
                $data[$i]["estado"] = "<div class='badge badge-primary'>".$data[$i]["estado"]."</div>";
            }
        }
    }
    return $data;
}

function formatTableCriticos($data, $obj){
    if($data){
        foreach($data as &$items){

            if($items["notificado"] == "si"){
                $items["notificado"] = "<div class='badge badge-success'>".$items["notificado"]."</div>";
            } else {
                $items["notificado"] = "<div class='badge badge-danger'>".$items["notificado"]."</div>";
            }
        }
        return $data;
    } 
}


function formatTableSubMenu($data, $obj){
    if($data){
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]["orden_submenu"] = "<div class='badge badge-success'>".$data[$i]["orden_submenu"]."</div>";

            $data[$i]["icono_submenu"] = "<i style='font-size: 20px;' class='".$data[$i]["icono_submenu"]."'></i>";
            
        }
    }
    return $data;
}


function agregar_profesional($data, $obj){
    $nombre_profesional = $data["profesional"]["nombre_profesional"];
    $apellido_profesional = $data["profesional"]["apellido_profesional"];

    $obj->setLangData("success", "Profesional Agregado con éxito");

    return $data;
}

function resetloginCallback($data, $obj)
{   
    $email = htmlspecialchars($data['usuario']['email']);

    if(empty($email)){
        echo "Ingrese un correo para Recuperar su contraseña";
        die(); 
    } 

    $pdomodel = $obj->getPDOModelObj();
    $pdomodel->where("email", $email);
    $hash = $pdomodel->select("usuario");

    if ($hash) {
        $pass = $pdomodel->getRandomPassword(15, true);
        $encrypt = password_hash($pass, PASSWORD_DEFAULT);

        $pdomodel->where("id", $hash[0]["id"]);
        $pdomodel->update("usuario", array("password" => $encrypt));

        $emailBody = "Correo enviado  tu nueva contraseña es: $pass";
        $subject = "Nueva Contraseña de acceso al sistema de Procedimentos";
        $to = $email;

        //$pdomodel->send_email_public($to, 'daniel.telematico@gmail.com', null, $subject, $emailBody);
        App\core\DB::PHPMail($to, "daniel.telematico@gmail.com", $subject, $emailBody);
        $obj->setLangData("success", "Correo enviado con éxito");
    }

    return $data;
}
