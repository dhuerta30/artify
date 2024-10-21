<?php

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\Request;
use App\core\View;
use App\core\Redirect;
use App\core\DB;
use Coderatio\SimpleBackup\SimpleBackup;
use App\Models\DatosPacienteModel;
use App\Models\PageModel;
use App\Models\UsuarioMenuModel;
use App\Models\UserModel;
use App\Models\ProcedimientoModel;
use App\Models\UsuarioSubMenuModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class HomeController
{
    public $token;

	public function __construct()
	{
		SessionManager::startSession();
		$Sesusuario = SessionManager::get('usuario');
		if (!isset($Sesusuario)) {
			Redirect::to("login/index");
		}
        $this->token = Token::generateFormToken('send_message');
	}

	public static function Obtener_menus(){
		$usuario_menu = new UsuarioMenuModel();
		$data_usuario_menu = $usuario_menu->Obtener_menus();
		return $data_usuario_menu;
	}

	public static function obtener_menu_por_id_usuario($id_usuario){
		$usuario_menu = new UsuarioMenuModel();
		$data_usuario_menu = $usuario_menu->Obtener_menu_por_id_usuario($id_usuario);
		return $data_usuario_menu;
	}

	public static function Obtener_submenus($id_menu){
		$usuario_submenu = new UsuarioSubMenuModel();
		$data_usuario_submenu = $usuario_submenu->Obtener_submenus($id_menu);
		return $data_usuario_submenu;
	}

	public static function Obtener_submenu_por_id_menu($id_menu, $id_usuario){
		$usuario_submenu = new UsuarioSubMenuModel();
		$data_usuario_submenu = $usuario_submenu->Obtener_submenu_por_id_menu($id_menu, $id_usuario);
		return $data_usuario_submenu;
	}

	public function obtener_menu_usuario()
	{
		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$userId = $request->post('userId');

			$data_usuario_menu = HomeController::obtener_menu_por_id_usuario($userId);

			$usuario = new UserModel();
			$data_user = $usuario->obtener_usuario_porId($userId);

			$html = '<ul class="list-none">
				<li>
					<input type="checkbox" value="select-all" name="select_all" class="select-all">
					<span>Marcar Todos / Desmarcar Todos</span>
				</li>
			</ul>';
			$html .= '<ul class="list-none">';
			$html .= '<span>Menus Asignados a ' . $data_user[0]["nombre"] . '</span><br><br>';

			foreach ($data_usuario_menu as $item) {
				$html .= '<li>';

				if ($item["submenu"] == "Si") {
					$isChecked = ($item['visibilidad_menu'] == 'Mostrar' && $item['id_usuario'] ? 'checked' : ''); // Verificar si el menú está asignado al usuario
					$html .= '<input type="checkbox" ' . $isChecked . ' id="' . $item['id_menu'] . '" class="menu-checkbox-pr mr-2" data-type="menu">';
					$html .= '<span><i class="' . $item['icono_menu'] . '"></i> ' . $item['nombre_menu'] . '</span>';
					$html .= '<ul class="list-none">';

					$data_usuario_submenu = HomeController::Obtener_submenu_por_id_menu($item["id_menu"], $userId);

					foreach ($data_usuario_submenu as $submenu) {

						$isCheckedSubmenu = ($submenu['visibilidad_submenu'] == 'Mostrar' && $submenu['id_usuario'] ? 'checked' : ''); // Verificar si el submenu está asignado al usuario
						$html .= '<li>';
						$html .= '<input type="checkbox" ' . $isCheckedSubmenu . ' id="' . $submenu['id_submenu'] . '" class="submenu-checkbox-pr mr-2" data-type="menu" data-parent="'.$item['id_menu'].'">';
						$html .= '<span><i class="' . $submenu['icono_submenu'] . '"></i> ' . $submenu['nombre_submenu'] . '</span>';
						$html .= '</li>';
					}

					$html .= '</ul>';
				} else {
					$isChecked = ($item['visibilidad_menu'] == 'Mostrar' && $item['id_usuario'] ? 'checked' : ''); // Verificar si el menú está asignado al usuario
					$html .= '<input type="checkbox" ' . $isChecked . ' id="' . $item['id_menu'] . '" class="menu-checkbox-pr mr-2" data-type="menu">';
					$html .= '<span><i class="' . $item['icono_menu'] . '"></i> ' . $item['nombre_menu'] . '</span>';
				}

				$html .= '</li>';
			}

			$html .= '<div class="row mt-4">
						<div class="col-md-12">
							<a href="javascript:;" title="Actualizar" class="btn btn-success btn-sm asignar_menu_usuario" data-id="' . $userId . '"><i class="far fa-save"></i> Actualizar</a>
						</div>
					</div>';
			$html .= '</ul>';
			$checkbox =  $html;
			HomeController::modal("menus", "<i class='far fa-eye'></i> Actualizar Menus Asignados", $checkbox);
		}
	}

	
	public function refrescarMenu()
	{
		$request = new Request();
	
		if ($request->getMethod() === 'POST') {
			// Obtén la URL actual
			$currentUrl = $_SERVER['REQUEST_URI'];
			$id_sesion_usuario = $_SESSION["usuario"][0]["id"];

			// Obtén el menú y submenús utilizando funciones existentes
			$menu = HomeController::obtener_menu_por_id_usuario($id_sesion_usuario);

			// Estructura para almacenar el menú
			$menuHtml = '<nav class="mt-2">
							<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">';

			foreach ($menu as $item) {
				if ($_SESSION["usuario"][0]["idrol"] == 1 || $item["nombre_menu"] != "usuarios" && $item["visibilidad_menu"] != "Ocultar") {
					// Obtiene submenús
					$submenus = HomeController::Obtener_submenu_por_id_menu($item['id_menu'], $id_sesion_usuario);
					$tieneSubmenus = ($item["submenu"] == "Si");
					$subMenuAbierto = false;

					// Verifica si algún submenú está activo
					foreach ($submenus as $submenu) {
						if (strpos($currentUrl, $submenu['url_submenu']) !== false) {
							$subMenuAbierto = true;
							break;
						}
					}

					$menuHtml .= '<li class="nav-item' . ($subMenuAbierto ? ' menu-is-opening menu-open' : '') . '">';
					if ($tieneSubmenus) {
						$menuHtml .= '<a href="javascript:;" class="nav-link' . (strpos($currentUrl, $submenu['url_submenu']) !== false ? ' active' : '') . '">
										<i class="' . $item['icono_menu'] . '"></i>
										<p>
											' . $item['nombre_menu'] . '
											<i class="right fas fa-angle-left"></i>
										</p>
									</a>
									<ul class="nav nav-treeview" style="' . ($subMenuAbierto ? 'display: block;' : '') . '">';
						foreach ($submenus as $submenu) {
							if ($submenu["visibilidad_submenu"] != "Ocultar") {
								$menuHtml .= '<li class="nav-item">
												<a href="' . rtrim($_ENV["BASE_URL"], '/') . $submenu['url_submenu'] . '" class="nav-link' . (strpos($currentUrl, $submenu['url_submenu']) !== false ? ' active' : '') . '">
													<i class="' . $submenu['icono_submenu'] . '"></i>
													<p>' . $submenu['nombre_submenu'] . '</p>
												</a>
											</li>';
							}
						}
						$menuHtml .= '</ul>';
					} else {
						if($item["visibilidad_menu"] != "Ocultar"){
						$menuHtml .= '<a href="' . rtrim($_ENV["BASE_URL"], '/') . $item['url_menu'] . '" class="nav-link' . (strpos($currentUrl, $item['url_menu']) !== false ? ' active' : '') . '">
										<i class="' . $item['icono_menu'] . '"></i>
										<p>' . $item['nombre_menu'] . '</p>
									</a>';
						}
					}
					$menuHtml .= '</li>';
				}
			}

			$menuHtml .= '</ul>
						</nav>';

			// Retorna el HTML del menú
			echo json_encode([$menuHtml]);
		}
	}


	public function asignar_menus_usuario()
	{
		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$userId = $request->post("userId");
			$selectedMenus = $request->post("selectedMenus");

			if (is_array($selectedMenus)) {
				$artify = DB::ArtifyCrud();
				$queryfy = $artify->getQueryfyObj();

				$menuMarcado = false;
				$menuDesmarcado = false;

				foreach ($selectedMenus as $menu) {
					$menuId = $menu["menuId"];
					$submenuIds = isset($menu["submenuIds"]) ? $menu["submenuIds"] : [];
					$checked = $menu["checked"];

					// Procesar el menú principal
					$existMenu = $queryfy->where('id_menu', $menuId)
						->where('id_usuario', $userId)
						->select('usuario_menu');

					switch ($checked) {
						case "true":
							if (!$existMenu) {
								$queryfy->insert('usuario_menu', array(
									"id_usuario" => $userId,
									"id_menu" => $menuId,
									"visibilidad_menu" => "Mostrar"
								));
								$menuMarcado = true;
							} else {
								$queryfy->where('id_usuario', $userId)
									->where('id_menu', $menuId)
									->update('usuario_menu', array("visibilidad_menu" => "Mostrar"));
								$menuMarcado = true;
							}
							break;

						case "false":
							$queryfy->where('id_usuario', $userId)
								->where('id_menu', $menuId)
								->update('usuario_menu', array("visibilidad_menu" => "Ocultar"));
							$menuDesmarcado = true;
							break;
					}

					// Procesar los submenús asociados al menú principal
					foreach ($submenuIds as $submenuId) {
						$id_submenu = $submenuId['id'];
						$checked = $submenuId["checked"];

						$existSubmenu = $queryfy->where('id_submenu', $id_submenu)
							->where('id_usuario', $userId)
							->select('usuario_submenu');

						switch ($checked) {
							case "true":
								if (!$existSubmenu) {
									$queryfy->insert('usuario_submenu', array(
										"id_usuario" => $userId,
										"id_submenu" => $id_submenu,
										"id_menu" => $menuId,
										"visibilidad_submenu" => "Mostrar"
									));
								} else {
									$queryfy->where('id_usuario', $userId)
										->where('id_submenu', $id_submenu)
										->where('id_menu', $menuId)
										->update('usuario_submenu', array("visibilidad_submenu" => "Mostrar"));
								}
								break;

							case "false":
								$queryfy->where('id_usuario', $userId)
									->where('id_submenu', $id_submenu)
									->where('id_menu', $menuId)
									->update('usuario_submenu', array("visibilidad_submenu" => "Ocultar"));
								break;
						}
					}
				}

				$response = [];

				if ($menuMarcado) {
					$response['success'][] = 'Menús asignados correctamente';
				}

				if ($menuDesmarcado) {
					$response['success'][] = 'Menús Actualizados correctamente';
				}

				if (!$menuMarcado && !$menuDesmarcado) {
					$response['error'][] = 'Todos los menús ya fueron asignados previamente';
				}

				echo json_encode($response);
			} else {
				echo json_encode(['error' => 'Debe seleccionar al menos 1 menú de la lista para continuar']);
			}
		}
	}


	public function acceso_menus(){
		$artify = DB::ArtifyCrud();
		$artify->colRename("idrol", "Rol");
		$artify->colRename("id", "ID");
		$artify->relatedData('idrol','rol','idrol','nombre_rol');
		$artify->tableColFormatting("avatar", "html",array("type" =>"html","str"=>'<img width="50" src="'.$_ENV["BASE_URL"].'app/libs/artify/uploads/{col-name}">'));
		$artify->crudRemoveCol(array("rol","estatus","password", "token", "token_api", "expiration_token"));
		$artify->setSearchCols(array("id","nombre","email", "usuario", "idrol"));
		$artify->setSettings("searchbox", true);
		$artify->setSettings("addbtn", false);
		$artify->setSettings("viewbtn", false);
		$artify->setSettings('editbtn', true);
		$artify->setSettings('delbtn', true);
		$artify->setSettings("printBtn", false);
		$artify->setSettings("pdfBtn", false);
		$artify->setSettings("csvBtn", false);
		$artify->setSettings("excelBtn", false);
		$artify->setSettings("function_filter_and_search", true);
		$artify->setSettings("template", "acceso_usuarios_menus");
		$artify->setSettings("deleteMultipleBtn", false);
		$artify->setSettings("checkboxCol", false);
		$render = $artify->dbTable("usuario")->render();

		View::render(
			'acceso_menus',[
				'render' => $render
			]
		);
	}

	public function usuarios()
	{
		if($_SESSION["usuario"][0]["idrol"] == 1){
            $token = $this->token;
			$artify = DB::ArtifyCrud();
			$artify->fieldCssClass("id", array("d-none"));
			$artify->tableHeading("Lista de usuarios");
            $artify->formStaticFields("token_form", "html", "<input type='hidden' name='auth_token' value='" . $token . "' />");
			$artify->tableColFormatting("avatar", "html",array("type" =>"html","str"=>'<img width="80" src="'.$_ENV["BASE_URL"].'app/libs/artify/uploads/{col-name}">'));
			$artify->fieldDataAttr("password", array("value"=>"", "placeholder" => "*****", "autocomplete" => "new-password"));
			$artify->formDisplayInPopup();
			$artify->fieldGroups("Name",array("nombre","email"));
			$artify->fieldGroups("Name2",array("usuario","password"));
			$artify->fieldGroups("Name3",array("idrol","avatar"));
			$artify->setSettings("searchbox", true);
			$artify->setSettings("required", false);
			$artify->setSettings("checkboxCol", false);
			$artify->setSettings("refresh", false);
			$artify->setSettings("function_filter_and_search", true);
			$artify->setSettings('editbtn', true);    
            $artify->setSettings('delbtn', true);
			$artify->setSettings("deleteMultipleBtn", false);
			$artify->colRename("id", "ID");
			$artify->colRename("idrol", "Rol");
			$artify->colRename("email", "Correo");
			$artify->fieldHideLable("id");
			$artify->addCallback("before_insert", "insetar_usuario");
			$artify->addCallback("before_update", "editar_usuario");
			$artify->crudRemoveCol(array("rol","estatus","password", "token", "token_api", "expiration_token"));
			$artify->setSearchCols(array("id","nombre","email", "usuario", "idrol"));
			$artify->where("estatus", 1);
			$artify->recordsPerPage(5);
			$artify->fieldTypes("avatar", "FILE_NEW");
			$artify->fieldTypes("password", "password");
			$artify->fieldRenameLable("nombre", "Nombre Completo");
			$artify->fieldRenameLable("email", "Correo electrónico");
			$artify->fieldRenameLable("password", "Clave de acceso");
			$artify->fieldRenameLable("idrol", "Tipo Usuario");
			$artify->setSettings("viewbtn", false);
			$artify->setSettings("hideAutoIncrement", false);
			$artify->setSettings("template", "usuarios");
			$artify->buttonHide("submitBtnSaveBack");
			$artify->formFields(array("id","nombre","email","password","usuario", "idrol", "avatar"));
			$artify->setRecordsPerPageList(array(5, 10, 15, 'All'=> 'Todo'));
			$artify->setSettings("printBtn", false);
			$artify->setSettings("pdfBtn", false);
			$artify->setSettings("csvBtn", false);
			$artify->setSettings("excelBtn", false);
			$artify->relatedData('idrol','rol','idrol','nombre_rol');
			$render = $artify->dbTable("usuario")->render();

			View::render(
				'home',
				['render' => $render]
			);
		} else {
			Redirect::to("home/datos_paciente");
		}
	}


	public function generar_datos_usuario(){
		
		$request = new Request();

    	if ($request->getMethod() === 'POST') {
			$usuario = $_SESSION["usuario"];
			echo json_encode(['usuario' => $usuario]);
		}
	}

	public function generar_edad(){
		
		$request = new Request();

    	if ($request->getMethod() === 'POST') {
			$fecha_nac = $request->post("fecha_nac");

			if(!empty($fecha_nac)){
				$fechaNacimiento = HomeController::calcularFechaNacimiento($fecha_nac);
				if($fechaNacimiento >= 0){
					echo json_encode(['fecha_nacimiento' => $fechaNacimiento]);
				} else {
					echo json_encode(['error' => 'La fecha de nacimiento no se pudo calcular, ingrese una mas antigua']);
				}
			}
		}
	}

	public static function calcularFechaNacimiento($fecha_nac){
		$fecha_nac = strtotime($fecha_nac);
		$edad = date('Y', $fecha_nac);
		if (($mes = (date('m') - date('m', $fecha_nac))) < 0) {
			$edad++;
		} elseif ($mes == 0 && date('d') - date('d', $fecha_nac) < 0) {
			$edad++;
		}
		return date('Y') - $edad;
	}

	
	public static function modal($id, $titulo, $contenido = ""){
		$modal = '<div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-modal="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">'.$titulo.'</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						'.$contenido.'
					</div>
				</div>
			</div>
		</div>';
		echo $modal;
	}

	public function respaldos(){
		$respaldos = DB::ArtifyCrud();
        $respaldos->tableHeading("Respaldos");
        $respaldos->fieldTypes("file", "file");
        $respaldos->dbOrderBy("hora desc");
		$respaldos->tableColFormatting("fecha", "date",array("format" =>"d/m/Y"));
		$respaldos->setSearchCols(array("usuario", "fecha", "hora"));
        $respaldos->tableColFormatting("archivo", "html", array("type" => "html", "str" => "<a class='btn btn-success btn-sm' href=\"".$_ENV["BASE_URL"]."app/libs/artify/uploads/{col-name}\" data-attribute=\"abc-{col-name}\"><i class=\"fa fa-download\"></i> Descargar Respaldo</a>"));
        $respaldos->setSettings("searchbox", true);
		$respaldos->setSettings("addbtn", false);
		$respaldos->setSettings('editbtn', true);    
		$respaldos->setSettings('delbtn', true);
        $respaldos->setSettings("viewbtn", false);
		$respaldos->setSettings("function_filter_and_search", true);
        $respaldos->setSettings("printBtn", false);
        $respaldos->setSettings("pdfBtn", false);
        $respaldos->setSettings("csvBtn", false);
        $respaldos->setSettings("excelBtn", false);
		$respaldos->setSettings("refresh", false);
		$respaldos->fieldTypes("archivo", "FILE_NEW");
		$respaldos->enqueueBtnTopActions("Report export",  "<i class='fa fa-database'></i> Generar Respaldo", "javascript:;", array(), "btn-report btn btn-success");
		$respaldos->crudRemoveCol(array("id"));
        $respaldos->addCallback("before_delete", "delete_file_data");
        $respaldos->addFilter("UserFilter", "Filtrar por Usuario que generó el respaldo", "usuario", "dropdown");
        $respaldos->setFilterSource("UserFilter", "backup", "usuario", "usuario as pl", "db");
        $respaldos->addFilter("DateFilter", "Filtrar por Fecha", "fecha", "dropdown");
        $respaldos->setFilterSource("DateFilter", "backup", "fecha", "fecha as pl", "db");
        $respaldos->addFilter("HourFilter", "Filtrar por Hora", "hora", "dropdown");
        $respaldos->setFilterSource("HourFilter", "backup", "hora", "hora as pl", "db");

        $render_respaldos = $respaldos->dbTable("backup")->render();

		View::render(
			"respaldos", [
				'render' => $render_respaldos
			]
		);
	}

	public function export_db()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST'){
			date_default_timezone_set("America/Santiago");
			$date = date('Y-m-d');
			$hour = date('G:i:s');
			$user = $_SESSION['usuario'][0]["usuario"];

			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();
			$id = $queryfy->select("backup");

			$exportDirectory = realpath(__DIR__ . '/../libs/artify/uploads');

			// Verificar si el directorio existe y, si no, intentar crearlo
			if (!is_dir($exportDirectory) && !mkdir($exportDirectory, 0777, true)) {
				die('Error al crear el directorio de exportación');
			}

			$simpleBackup = SimpleBackup::setDatabase([
				$_ENV['DB_NAME'],
				$_ENV['DB_USER'],
				$_ENV['DB_PASS'],
				$_ENV['DB_HOST']
			])->storeAfterExportTo($exportDirectory, "procedimiento" . time() . ".sql");

			$file = $_ENV["BASE_URL"] . $_ENV['UPLOAD_URL'] . $simpleBackup->getExportedName();

			$queryfy->insert("backup", array("archivo" => basename($file), "fecha" => $date, "hora" => $hour, "usuario" => $user));

			echo json_encode(['file' => $file, 'success' => 'Tus datos se han respaldado con éxito ']);
		}
	}

	public static function validaRut($rut)
    {
        if (strpos($rut, "-") == false) {
            $RUT[0] = substr($rut, 0, -1);
            $RUT[1] = substr($rut, -1);
        } else {
            $RUT = explode("-", trim($rut));
        }
        $elRut = $RUT[0];
        $factor = 2;
        $suma = 0;
        for ($i = strlen($elRut) - 1; $i >= 0; $i--) {
            $factor = $factor > 7 ? 2 : $factor;
            $suma += $elRut[$i] * $factor++;
        }
        $resto = $suma % 11;
        $dv = 11 - $resto;
        if ($dv == 11) {
            $dv = 0;
        } else if ($dv == 10) {
            $dv = "k";
        } else {
            $dv = $dv;
        }
        if ($dv == trim(strtolower($RUT[1]))) {
            return true;
        } else {
            return false;
        }
    }

	public static function menuDB(){
		$artify = DB::ArtifyCrud();
		$queryfy = $artify->getQueryfyObj();
		$queryfy->orderBy(array("orden_menu asc"));
		$data = $queryfy->select("menu");
		return $data;
	}

	public static function submenuDB($idMenu){
		$artify = DB::ArtifyCrud();
		$queryfy = $artify->getQueryfyObj();
		$queryfy->where("id_menu", $idMenu, "=");
		$queryfy->orderBy(array("orden_submenu asc")); // Ajusta el nombre de la columna de ordenación si es diferente
		$data = $queryfy->select("submenu");
		return $data;
	}	

	public function modulos()
	{
		$id_sesion_usuario = $_SESSION['usuario'][0]["id"];

		$artify = DB::ArtifyCrud();
		$artify->addPlugin("bootstrap-switch-master");
		
		$scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

		$host = $_SERVER['HTTP_HOST'];

		$currentUrl = $scheme . '://' . $host . "/artify/";

		$html_template = '
		<div class="card">
		<div class="card-body bg-dark">
			<h5 class="card-title mb-0"><span class="titulo_modulo"></span> Generador de Módulos</h5>
		</div>
		<div class="card-body bg-light">

		<ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
			<li class="nav-item border-0" role="presentation">
				<a class="nav-link active" id="modulos-tab" data-toggle="tab" href="#modulos" role="tab" aria-controls="modulos" aria-selected="true">Generador de Módulos</a>
			</li>
			<li class="nav-item border-0" role="presentation">
				<a class="nav-link" id="pdf-tab" data-toggle="tab" href="#pdf" role="tab" aria-controls="pdf" aria-selected="false">Generador de PDF</a>
			</li>
		</ul>

		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="modulos" role="tabpanel" aria-labelledby="modulos-tab">
			
				<div class="form mt-4">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Tipo de Módulo:</label>
								{crud_type}
								<p class="artify_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Nombre Tabla Base de Datos:</label>
								{tabla}
								<p class="artify_help_block help-block form-text with-errors"></p>
								<p style="font-size:14px;">Si No posee tablas creelas en la Pestaña Crear Tablas y luego seleccionela acá</p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Nombre Módulo:</label>
								{nombre_modulo}
								<p class="artify_help_block help-block form-text with-errors"></p>
								<p style="font-size:14px;">Opcional si lo deja vacio tomará el nombre de la tabla de la base de datos</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 d-none">
							<div class="form-group">
								<label class="form-label">ID Tabla Base de Datos:</label>
								{id_tabla}
								<p class="artify_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Nombre del Controlador:</label>
								{controller_name}
								<p class="artify_help_block help-block form-text with-errors"></p>
								<p style="font-size:14px;">Cambie por su controlador o utilice el actual</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Nombre de La Vista:</label>
								{name_view}
								<p class="artify_help_block help-block form-text with-errors"></p>
								<p style="font-size:14px;">Cambie por su vista o utilice la actual</p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Consulta DB:</label>
								{query}
								<p class="artify_help_block help-block form-text with-errors"></p>
								<p style="font-size:14px;">Cambie por su consulta o utilice la actual</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<ul class="nav nav-pills flex-column flex-sm-row" id="myTab" role="tablist">
								<li class="nav-item border-0" role="presentation">
									<a class="nav-link active" id="filtro-tab" data-toggle="tab" href="#filtro" role="tab" aria-controls="filtro" aria-selected="true">Filtro de Búsqueda</a>
								</li>
								<li class="nav-item border-0" role="presentation">
									<a class="nav-link" id="accionesgrilla-tab" data-toggle="tab" href="#accionesgrilla" role="tab" aria-controls="accionesgrilla" aria-selected="false">Acciones Grilla</a>
								</li>
								<li class="nav-item border-0" role="presentation">
									<a class="nav-link" id="camposformularios-tab" data-toggle="tab" href="#camposformularios" role="tab" aria-controls="camposformularios" aria-selected="false">Campos Formularios</a>
								</li>
							</ul>

							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active pb-3" id="filtro" role="tabpanel" aria-labelledby="filtro-tab">
								
									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Activar Filtro de Busqueda:</label>
												{active_filter}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
											<label class="form-label">Posición filtro Busqueda:</label>
											{posicion_filtro}
											<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Campos a Mostrar Filtro:</label>
												{mostrar_campos_filtro}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3 esconder_tipo_filtro d-none">
											<div class="form-group">
												<label class="form-label">Tipo de Filtro:</label>
												{tipo_de_filtro}
												<p style="font-size: 14px;">Filtros soportados: radio, dropdown, date, text</p>
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

								</div>
								<div class="tab-pane fade" id="accionesgrilla" role="tabpanel" aria-labelledby="accionesgrilla-tab">
									
									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Activar Búsqueda:</label>
												{active_search}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Activar Popup:</label>
												{active_popup}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Activar Eliminación Masiva:</label>
												{activate_deleteMultipleBtn}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Botón Agregar:</label>
												{button_add}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Campos a Mostrar en el buscador:</label>
												{mostrar_campos_busqueda}
												<span style="font-size: 14px;">seleccione la tabla para cargar estos campos</span>
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Columnas a Mostrar en la Grilla:</label>
												{mostrar_columnas_grilla}
												<span style="font-size: 14px;">seleccione la tabla para cargar estas columnas</span>
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Posición Botones de Acción Grilla:</label>
												{posicion_botones_accion_grilla}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Mostrar Columna Acciones Grilla:</label>
												{mostrar_columna_acciones_grilla}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Botón Refrescar Grilla:</label>
												{refrescar_grilla}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Clonar Filas:</label>
												{clone_row}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Activar funciones de Filtro y Búsqueda:</label>
												{function_filter_and_search}
												<span style="font-size: 14px;">Si Escoje la Opción "No" Deberá utilizar su propia lógica de Filtro y Búsqueda</span>
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Mostrar Paginación:</label>
												{mostrar_paginacion}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Activar Lista Registros por Página:</label>
												{activar_registros_por_pagina}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Cantidad de Registros por Página:</label>
												{cantidad_de_registros_por_pagina}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Botones de Exportación Grilla:</label>
												{actions_buttons_grid}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Posicionarse en la Página N°:</label>
												{posicionarse_en_la_pagina}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

									<div class="row pt-4">
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Activar Numeración Columnas:</label>
												{activar_numeracion_columnas}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Botones de Acción:</label>
												{buttons_actions}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">Ordenar Grilla por:</label>
												{ordenar_grilla_por}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
	
											<div class="form-group">
												<label class="form-label">Tipo de Orden Grilla:</label>
												{tipo_orden}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										
										</div>
									</div>

									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Activar Edición en Línea:</label>
												{activar_edicion_en_linea}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<!--<div class="col-md-12">
											<div class="form-group">
												<p class="text-center fwb">Renombrar columnas Grilla</p>
											</div>
										</div>-->
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Nombre Columnas:</label>
												{nombre_columnas}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Nuevo Nombre Columnas:</label>
												{nuevo_nombre_columnas}
												<p style="font-size: 14px;">Escriba y presione enter para agregar los nuevos nombres</p>
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Info Cantidad Registros por Página:</label>
												{totalRecordsInfo}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Activar Union Interna:</label>
												{activar_union_interna}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Tabla Principal Union Interna:</label>
												{tabla_principal_union}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3 esconder_tipo_union d-none">
											<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label">Relación Union Principal:</label>
													{campos_relacion_union_tabla_principal}
													<p style="font-size: 14px;">Ejemplo: Campo Relacional id_personas</p>
													<p class="artify_help_block help-block form-text with-errors"></p>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="form-label">Relación Union Secundaria:</label>
													{campos_relacion_union_tabla_secundaria}
													<p style="font-size: 14px;">Ejemplo: Campo Relacional id_personas</p>
													<p class="artify_help_block help-block form-text with-errors"></p>
												</div>
											</div>
										</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Tabla secundaria Union Interna:</label>
												{tabla_secundaria_union}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

								</div>
								<div class="tab-pane fade pb-3" id="camposformularios" role="tabpanel" aria-labelledby="camposformularios-tab">

									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Campos a Mostrar en el formulario Insertar:</label>
												{mostrar_campos_formulario}
												<span style="font-size: 14px;">seleccione la tabla para cargar estos campos</span>
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Encriptar Campos del Formulario:</label>
												{encryption}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Campos a Mostrar en el formulario Editar:</label>
												{mostrar_campos_formulario_editar}
												<span style="font-size: 14px;">seleccione la tabla para cargar estos campos</span>
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Campos Requeridos de formulario:</label>
												{campos_requeridos}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Activar Recaptcha:</label>
												{activar_recaptcha}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Site Key Recaptcha:</label>
												{sitekey_recaptcha}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Site Secret Recaptcha:</label>
												{sitesecret_repatcha}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Ocultar Id de la Tabla en Formularios</label>
												{ocultar_id_tabla}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

									<div class="row pt-4">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Usar Plantilla Formulario HTML:</label>
												{template_fields}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Nombre Campos:</label>
												{nombre_campos}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Nuevo Nombre Campos:</label>
												{nuevo_nombre_campos}
												<p style="font-size:14px;">Escriba y presione enter para agregar los nuevos nombres</p>
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<label class="form-label">Área Protegida por Login:</label>
												{area_protegida_por_login}
												<p class="artify_help_block help-block form-text with-errors"></p>
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 d-none">
							<div class="form-group">
								<label class="form-label">Agregar Al Menú Principal:</label>
								{add_menu}
								<p class="artify_help_block help-block form-text with-errors"></p>
							</div>
						</div>
					</div>
					<div class="row mt-3">
						
						<div class="col-md-3">
							<div class="form-group tabla_anidada d-none">
								<label class="form-label">Activar Tabla Anidada:</label>
								{activate_nested_table}
								<p class="artify_help_block help-block form-text with-errors"></p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="row mt-4">
								<div class="col-md-12 text-center">
									<button type="button" class="btn btn-danger artify-form-control artify-button artify-back regresar_modulos" data-action="back">Regresar</button> 
									<input type="submit" class="btn btn-primary artify-form-control artify-submit" data-action="insert" value="Guardar">
									<a href="javascript:;" class="btn btn-primary siguiente_1">Siguiente <i class="fa fa-arrow-right"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			
			</div>
			<div class="tab-pane fade" id="pdf" role="tabpanel" aria-labelledby="pdf-tab">
			
				<div class="row mt-4">
					<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Activar PDF:</label>
								{activate_pdf}
								<p class="artify_help_block help-block form-text with-errors"></p>
							</div>
						</div>	
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Logo PDF:</label>
							{logo_pdf}
							<p class="artify_help_block help-block form-text with-errors"></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Marca de Agua PDF:</label>
							{marca_de_agua_pdf}
							<p class="artify_help_block help-block form-text with-errors"></p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label">Consulta de Base de Datos PDF:</label>
							{consulta_pdf}
							<p class="artify_help_block help-block form-text with-errors"></p>
						</div>
					</div>	
				</div>

				<div class="row mt-4">
					<div class="col-md-12 text-center">
						<button type="button" class="btn btn-danger artify-form-control artify-button artify-back regresar_modulos" data-action="back">Regresar</button> 
						<input type="submit" class="btn btn-primary artify-form-control artify-submit" data-action="insert" value="Guardar">
						<a href="javascript:;" class="btn btn-primary anterior"><i class="fa fa-arrow-left"></i> Anterior</a>
						<a href="javascript:;" class="btn btn-primary siguiente_2">Siguiente <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
		
			</div>
		</div>

		</div>
		</div>
		';
		$artify->addPlugin("bootstrap-tag-input");
		$artify->addPlugin("select2");
		$artify->addPlugin("bootstrap-inputmask");
		$artify->set_template($html_template);
		$artify->setLangData("no_data", "No Hay Módulos creados");
		$artify->formFieldValue("active_popup", "No");
		$artify->formFieldValue("add_menu", "Si");
		$artify->formFieldValue("active_filter", "No");
		$artify->formFieldValue("clone_row", "No");
		$artify->formFieldValue("button_add", "Si");
		$artify->formFieldValue("activate_deleteMultipleBtn", "No");
		$artify->formFieldValue("active_search", "No");
		$artify->formFieldValue("encryption", "No");
		$artify->formFieldValue("activar_recaptcha", "No");
		$artify->fieldNotMandatory("actions_buttons_grid");
		$artify->fieldNotMandatory("buttons_actions");
		$artify->formFieldValue("activate_nested_table", "No");
		$artify->formFieldValue("activate_pdf", "No");
		$artify->formFieldValue("refrescar_grilla", "No");
		$artify->formFieldValue("function_filter_and_search", "Si");
		$artify->formFieldValue("activar_union_interna", "No");
		$artify->formFieldValue("posicion_botones_accion_grilla", "Derecha");
		$artify->formFieldValue("campos_requeridos", "Si");
		$artify->formFieldValue("mostrar_columna_acciones_grilla", "Si");
		$artify->formFieldValue("mostrar_paginacion", "Si");
		$artify->formFieldValue("activar_numeracion_columnas", "No");
		$artify->formFieldValue("activar_registros_por_pagina", "Si");
		$artify->formFieldValue("cantidad_de_registros_por_pagina", 10);
		$artify->formFieldValue("activar_edicion_en_linea", "No");
		$artify->formFieldValue("posicionarse_en_la_pagina", 1);
		$artify->formFieldValue("ocultar_id_tabla", "No");
		$artify->formFieldValue("totalRecordsInfo", "Si");
		$artify->formFieldValue("area_protegida_por_login", "Si");
		$artify->formfieldValue("posicion_filtro", "Izquierda");

		$artify->setLangData("add", "Agregar Módulo");

		$artify->fieldNotMandatory("nombre_modulo");
		$artify->fieldNotMandatory("modify_query");
		$artify->fieldNotMandatory("posicionarse_en_la_pagina");
		$artify->fieldTypes("logo_pdf", "select");
		$artify->fieldTypes("marca_de_agua_pdf", "select");

		$artify->fieldDataBinding("logo_pdf", "configuracion_modulos", "logo_pdf as configuracion_modulos", "logo_pdf", "db");
		$artify->fieldDataBinding("marca_de_agua_pdf", "configuracion_modulos", "marca_agua_pdf as configuracion_modulos", "marca_agua_pdf", "db");

		$artify->fieldDataAttr("logo_pdf", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("marca_de_agua_pdf", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("consulta_pdf", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("sitekey_recaptcha", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("sitesecret_repatcha", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("mostrar_campos_filtro", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("tabla_principal_union", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("tabla_secundaria_union", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("posicion_filtro", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("tipo_de_filtro", array("disabled" => "disabled"));
				
		$artify->fieldDataAttr("mostrar_campos_busqueda", array("placeholder" => "campo1/campo2/campo3/etc"));
		$artify->fieldDataAttr("mostrar_columnas_grilla", array("placeholder" => "columna1/columna2/columna3/etc"));
		$artify->fieldDataAttr("mostrar_campos_formulario", array("placeholder" => "campo1/campo2/campo3/etc"));
		$artify->fieldDataAttr("mostrar_campos_filtro", array("placeholder" => "campo1/campo2/campo3/etc"));

		$artify->fieldTypes("mostrar_campos_busqueda", "multiselect");
		$artify->fieldTypes("mostrar_campos_formulario", "multiselect");
		$artify->fieldTypes("mostrar_columnas_grilla", "multiselect");
		$artify->fieldTypes("mostrar_campos_filtro", "multiselect");
		$artify->fieldTypes("campos_relacion_union_tabla_principal", "multiselect");
		$artify->fieldTypes("campos_relacion_union_tabla_secundaria", "multiselect");
		$artify->fieldTypes("mostrar_campos_formulario_editar", "multiselect");
		$artify->fieldTypes("nombre_columnas", "multiselect");
		$artify->fieldTypes("nombre_campos", "multiselect");
		$artify->fieldTypes("tabla_principal_union", "multiselect");
		$artify->fieldTypes("tabla_secundaria_union", "multiselect");

		$artify->fieldTypes("tipo_de_filtro", "input");
		$artify->fieldTypes("ordenar_grilla_por", "select");
		$artify->fieldTypes("nuevo_nombre_columnas", "input");

		$artify->fieldTypes("nuevo_nombre_campos", "input");
		$artify->fieldAttributes("nuevo_nombre_columnas", array("data-role"=>"tagsinput"));
		$artify->fieldAttributes("nuevo_nombre_campos", array("data-role"=>"tagsinput"));

		$artify->fieldTypes("area_protegida_por_login", "select");
		$artify->fieldDataBinding("area_protegida_por_login", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("tipo_orden", "select");
		$artify->fieldDataBinding("tipo_orden", array("ASC" => "ASC", "DESC" => "DESC"), "", "", "array");
		
		$artify->fieldTypes("posicion_botones_accion_grilla", "select");
		$artify->fieldDataBinding("posicion_botones_accion_grilla", array("Derecha" => "Derecha", "Izquierda" => "Izquierda"), "", "", "array");
		
		$artify->fieldTypes("activar_edicion_en_linea", "select");
		$artify->fieldDataBinding("activar_edicion_en_linea", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activar_registros_por_pagina", "select");
		$artify->fieldDataBinding("activar_registros_por_pagina", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activar_numeracion_columnas", "select");
		$artify->fieldDataBinding("activar_numeracion_columnas", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("mostrar_columna_acciones_grilla", "select");
		$artify->fieldDataBinding("mostrar_columna_acciones_grilla", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("mostrar_paginacion", "select");
		$artify->fieldDataBinding("mostrar_paginacion", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("campos_requeridos", "select");
		$artify->fieldDataBinding("campos_requeridos", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("encryption", "select");
		$artify->fieldDataBinding("encryption", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("refrescar_grilla", "select");
		$artify->fieldDataBinding("refrescar_grilla", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("buttons_actions", "checkbox");
		$artify->fieldDataBinding("buttons_actions", array(
			"Ver" => "Mostrar botón Ver",
			"Editar" => "Mostrar botón Editar",
			"Eliminar" => "Mostrar botón Eliminar",
			"Guardar" => "Ocultar botón Guardar",
			"Guardar y regresar" => "Ocultar botón Guardar y regresar",
			"Regresar" => "Ocultar botón Regresar", 
			"Cancelar" => "Ocultar botón Cancelar", 
			"Personalizado PDF" => "Mostrar botón Personalizado PDF"
		), "", "", "array");

		$artify->fieldTypes("actions_buttons_grid", "checkbox");
		$artify->fieldDataBinding("actions_buttons_grid", array(
			"Imprimir" => "Imprimir", 
			"PDF" => "PDF", 
			"CSV" => "CSV", 
			"Excel" => "Excel"
		), "", "", "array");

		$artify->fieldTypes("posicion_filtro", "select");
		$artify->fieldDataBinding("posicion_filtro", array("Izquierda" => "Izquierda", "Derecha" => "Derecha", "Arriba" => "Arriba"), "", "", "array");

		$artify->fieldTypes("totalRecordsInfo", "select");
		$artify->fieldDataBinding("totalRecordsInfo", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("ocultar_id_tabla", "select");
		$artify->fieldDataBinding("ocultar_id_tabla", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activar_union_interna", "select");
		$artify->fieldDataBinding("activar_union_interna", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activate_nested_table", "select");
		$artify->fieldDataBinding("activate_nested_table", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activar_recaptcha", "select");
		$artify->fieldDataBinding("activar_recaptcha", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("button_add", "select");
		$artify->fieldDataBinding("button_add", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activate_pdf", "select");
		$artify->fieldDataBinding("activate_pdf", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activate_deleteMultipleBtn", "select");
		$artify->fieldDataBinding("activate_deleteMultipleBtn", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("active_search", "select");
		$artify->fieldDataBinding("active_search", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("active_popup", "select");
		$artify->fieldDataBinding("active_popup", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("active_filter", "select");
		$artify->fieldDataBinding("active_filter", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("function_filter_and_search", "select");
		$artify->fieldDataBinding("function_filter_and_search", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("clone_row", "select");
		$artify->fieldDataBinding("clone_row", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("tabla", "select");
		
		$artify->fieldCssClass("crud_type", array("crud_type"));
		$artify->fieldCssClass("tabla", array("tabla"));
		$artify->fieldCssClass("id_tabla", array("id_tabla"));
		$artify->fieldCssClass("query", array("query"));
		$artify->fieldCssClass("name_view", array("name_view"));
		$artify->fieldCssClass("controller_name", array("controller_name"));
		$artify->fieldCssClass("columns_table", array("columns_table"));
		$artify->fieldCssClass("modify_query", array("modify_query"));
		$artify->fieldCssClass("activate_nested_table", array("activate_nested_table"));
		$artify->fieldCssClass("consulta_pdf", array("consulta_pdf"));
		$artify->fieldCssClass("activate_pdf", array("activate_pdf"));
		$artify->fieldCssClass("logo_pdf", array("logo_pdf"));
		$artify->fieldCssClass("marca_de_agua_pdf", array("marca_de_agua_pdf"));
		$artify->fieldCssClass("actions_buttons_grid", array("actions_buttons_grid"));
		$artify->fieldCssClass("buttons_actions", array("buttons_actions"));
		$artify->fieldCssClass("mostrar_campos_busqueda", array("mostrar_campos_busqueda"));
		$artify->fieldCssClass("mostrar_columnas_grilla", array("mostrar_columnas_grilla"));
		$artify->fieldCssClass("mostrar_campos_filtro", array("mostrar_campos_filtro"));
		$artify->fieldCssClass("mostrar_campos_formulario", array("mostrar_campos_formulario"));
		$artify->fieldCssClass("activar_recaptcha", array("activar_recaptcha"));
		$artify->fieldCssClass("sitekey_recaptcha", array("sitekey_recaptcha"));
		$artify->fieldCssClass("sitesecret_repatcha", array("sitesecret_repatcha"));
		$artify->fieldCssClass("active_filter", array("active_filter"));
		$artify->fieldCssClass("function_filter_and_search", array("function_filter_and_search"));
		$artify->fieldCssClass("mostrar_campos_formulario_editar", array("mostrar_campos_formulario_editar"));
		$artify->fieldCssClass("ordenar_grilla_por", array("ordenar_grilla_por"));
		$artify->fieldCssClass("mostrar_columna_acciones_grilla", array("mostrar_columna_acciones_grilla"));
		$artify->fieldCssClass("posicion_botones_accion_grilla", array("posicion_botones_accion_grilla"));
		$artify->fieldCssClass("refrescar_grilla", array("refrescar_grilla"));
		$artify->fieldCssClass("clone_row", array("clone_row"));
		$artify->fieldCssClass("activar_numeracion_columnas", array("activar_numeracion_columnas"));
		$artify->fieldCssClass("mostrar_paginacion", array("mostrar_paginacion"));
		$artify->fieldCssClass("cantidad_de_registros_por_pagina", array("cantidad_de_registros_por_pagina"));
		$artify->fieldCssClass("activar_registros_por_pagina", array("activar_registros_por_pagina"));
		$artify->fieldCssClass("posicionarse_en_la_pagina", array("posicionarse_en_la_pagina"));
		$artify->fieldCssClass("activar_edicion_en_linea", array("activar_edicion_en_linea"));
		$artify->fieldCssClass("activate_deleteMultipleBtn", array("activate_deleteMultipleBtn"));
		$artify->fieldCssClass("active_popup", array("active_popup"));
		$artify->fieldCssClass("active_search", array("active_search"));
		$artify->fieldCssClass("button_add", array("button_add"));
		$artify->fieldCssClass("tipo_orden", array("tipo_orden"));
		$artify->fieldCssClass("nombre_columnas", array("nombre_columnas"));
		$artify->fieldCssClass("nuevo_nombre_columnas", array("tagsinput"));
		$artify->fieldCssClass("nombre_campos", array("nombre_campos"));
		$artify->fieldCssClass("nuevo_nombre_campos", array("tagsinput"));
		$artify->fieldCssClass("ocultar_id_tabla", array("ocultar_id_tabla"));
		$artify->fieldCssClass("tipo_de_filtro", array("tipo_de_filtro"));
		$artify->fieldCssClass("campos_relacion_union_tabla_principal", array("campos_relacion_union_tabla_principal"));
		$artify->fieldCssClass("campos_relacion_union_tabla_secundaria", array("campos_relacion_union_tabla_secundaria"));
		$artify->fieldCssClass("template_fields", array("template_fields"));
		$artify->fieldCssClass("tabla_principal_union", array("tabla_principal_union"));
		$artify->fieldCssClass("tabla_secundaria_union", array("tabla_secundaria_union"));
		$artify->fieldCssClass("activar_union_interna", array("activar_union_interna"));
		$artify->fieldCssClass("nombre_modulo", array("nombre_modulo"));
		$artify->fieldCssClass("posicion_filtro", array("posicion_filtro"));

		$artify->fieldAttributes("id_tabla", array("readonly" => "true"));
		$artify->fieldAttributes("consulta_pdf", array("placeholder"=> "Ejemplo: SELECT id as item FROM tabla", "style"=> "min-height: 200px; max-height: 200px;"));
		//$artify->fieldAttributes("consulta_api", array("placeholder"=> "Ejemplo: SELECT id as item FROM tabla", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldAttributes("consulta_crear_tabla", array("placeholder"=> "Rellena los campos de abajo para completar estos valores o ingresalos manualmente. Ejemplo: id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255)", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldAttributes("query", array("placeholder"=> "Ejemplo: SELECT id as ID, name as Name FROM demo", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldAttributes("modify_query", array("placeholder"=> "Ejemplo: DROP COLUMN categoria, ADD COLUMN edad INT(3)", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldAttributes("columns_table", array("placeholder"=> "Rellena los campos de abajo para completar estos valores o ingresalos manualmente. Ejemplo: id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255)", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldGroups("Name2",array("name_view","add_menu"));
		$artify->tableHeading("Generador de Módulos");
		
		$artify->setSearchCols(array("posicionarse_en_la_pagina", "ordenar_grilla_por", "tipo_orden", "nombre_modulo", "activar_edicion_en_linea", "cantidad_de_registros_por_pagina", "activar_numeracion_columnas", "activar_registros_por_pagina", "mostrar_paginacion", "mostrar_columna_acciones_grilla", "campos_requeridos", "posicion_botones_accion_grilla", "mostrar_campos_formulario_editar", "activar_union_interna", "function_filter_and_search", "activar_recaptcha", "sitekey_recaptcha", "sitesecret_repatcha", "query_get", "encryption", "mostrar_columnas_grilla", "mostrar_campos_filtro", "mostrar_campos_formulario", "mostrar_campos_busqueda", "consulta_pdf", "refrescar_grilla", "marca_de_agua_pdf", "activate_pdf", "id_modulos", "tabla", "id_tabla", "crud_type", "query", "controller_name", "name_view", "add_menu", "template_fields", "active_filter", "clone_row", "active_popup", "active_search", "activate_deleteMultipleBtn", "button_add", "actions_buttons_grid", "activate_nested_table", "buttons_actions"));
		$artify->formFields(array("posicion_filtro", "campos_relacion_union_tabla_principal", "campos_relacion_union_tabla_secundaria", "tabla_principal_union", "tabla_secundaria_union", "area_protegida_por_login", "totalRecordsInfo", "activate_nested_table", "tipo_de_filtro", "ocultar_id_tabla", "nombre_campos", "nuevo_nombre_campos", "nombre_columnas", "nuevo_nombre_columnas", "posicionarse_en_la_pagina", "ordenar_grilla_por", "tipo_orden", "nombre_modulo", "activar_edicion_en_linea", "cantidad_de_registros_por_pagina", "activar_numeracion_columnas", "activar_registros_por_pagina", "mostrar_paginacion", "mostrar_columna_acciones_grilla", "campos_requeridos", "posicion_botones_accion_grilla", "mostrar_campos_formulario_editar", "activar_union_interna", "function_filter_and_search", "activar_recaptcha", "sitekey_recaptcha", "sitesecret_repatcha", "query_get", "encryption", "mostrar_columnas_grilla", "mostrar_campos_filtro", "mostrar_campos_formulario", "mostrar_campos_busqueda", "consulta_pdf", "refrescar_grilla", "logo_pdf", "marca_de_agua_pdf", "activate_pdf", "tabla", "id_tabla", "crud_type", "query", "controller_name", "name_view", "add_menu", "template_fields", "active_filter", "clone_row", "active_popup", "active_search", "activate_deleteMultipleBtn", "button_add", "actions_buttons_grid", "buttons_actions"));
		$artify->editFormFields(array("posicion_filtro", "campos_relacion_union_tabla_principal", "campos_relacion_union_tabla_secundaria", "tabla_principal_union", "tabla_secundaria_union", "area_protegida_por_login", "totalRecordsInfo", "tipo_de_filtro", "ocultar_id_tabla", "nombre_campos", "nuevo_nombre_campos", "nombre_columnas", "nuevo_nombre_columnas", "posicionarse_en_la_pagina", "ordenar_grilla_por", "tipo_orden", "nombre_modulo", "activar_edicion_en_linea", "cantidad_de_registros_por_pagina", "activar_numeracion_columnas", "activar_registros_por_pagina", "mostrar_paginacion", "mostrar_columna_acciones_grilla", "campos_requeridos", "posicion_botones_accion_grilla", "mostrar_campos_formulario_editar", "activar_union_interna", "function_filter_and_search", "activar_recaptcha", "sitekey_recaptcha", "sitesecret_repatcha", "query_get", "encryption", "mostrar_columnas_grilla", "mostrar_campos_filtro", "mostrar_campos_formulario", "mostrar_campos_busqueda", "consulta_pdf", "refrescar_grilla", "logo_pdf", "marca_de_agua_pdf", "activate_pdf", "tabla", "id_tabla", "crud_type", "query", "controller_name", "name_view", "add_menu", "template_fields", "active_filter", "clone_row", "active_popup", "active_search", "activate_deleteMultipleBtn", "button_add", "actions_buttons_grid","modify_query", "activate_nested_table", "buttons_actions"));

		$artify->crudTableCol(array("crud_type","tabla","id_tabla", "controller_name", "name_view", "add_menu", "active_filter", "clone_row", "active_popup", "active_search", "activate_deleteMultipleBtn", "button_add", "actions_buttons_grid", "activate_nested_table", "buttons_actions"));
		$artify->colRename("tabla", "Nombre Tabla Base de Datos");
		$artify->colRename("id_tabla", "ID Tabla Base de Datos");
		$artify->colRename("crud_type", "Tipo de Módulo");
		$artify->colRename("active_popup", "Activar Popup");
		$artify->colRename("active_search", "Activar Búsqueda");
		$artify->colRename("activate_deleteMultipleBtn", "Activar Eliminación Masiva");
		$artify->colRename("button_add", "Botón Agregar");
		$artify->colRename("actions_buttons_grid", "Botones de Exportación Grilla");
		$artify->colRename("modify_query", "Modificar Tabla");
		$artify->colRename("activate_nested_table", "Activar Tabla Anidada");
		$artify->colRename("id_modulos", "ID");
		$artify->colRename("buttons_actions", "Botones de Acción");
		$artify->colRename("mostrar_campos_busqueda", "Campos a Mostrar en la Busqueda");

		$artify->colRename("active_filter", "Activar Filtro de Busqueda");
		$artify->colRename("clone_row", "Clonar Fila");
		
		$artify->colRename("template_fields", "Usar Plantilla Formulario HTML");

		$artify->fieldConditionalLogic("crud_type", "CRUD", "=", "query", "hide");
		$artify->fieldConditionalLogic("crud_type", "CRUD", "!=", "query", "show");

		$artify->fieldConditionalLogic("crud_type", "Modulo de Inventario", "=", "query", "hide");

		$artify->fieldConditionalLogic("crud_type", "Modulo de Inventario", "=", "id_tabla", "hide");

		$artify->fieldConditionalLogic("crud_type", "Formulario de inserción", "=", "query", "hide");
		
		$artify->formFieldValue("template_fields", "No");

		$artify->colRename("query", "Consulta BD");
		$artify->colRename("controller_name", "Nombre del Controlador");
		$artify->colRename("columns_table", "Columnas de la Tabla");
		$artify->colRename("name_view", "Nombre de la Vista");
		$artify->colRename("add_menu", "Agregar Al Menú Principal");
		$artify->fieldDesc("nombre_funcion_antes_de_insertar", "Campo opcional");

		$artify->fieldTypes("crud_type", "select");
		$artify->fieldDataBinding("crud_type", array(
			"CRUD"=> "CRUD (Mantenedor a base de una tabla)",
			"SQL"=> "SQL (Mantenedor a base de una consulta)",
			"Formulario de inserción" => "Formulario de inserción",
			"Formulario de edición" => "Formulario de edición",
			"Modulo de Inventario" => "Modulo de Inventario"
		), "", "","array");

		$artify->fieldTypes("add_menu", "select");
		$artify->fieldDataBinding("add_menu", array("Si"=> "Si"), "", "","array");

		$artify->fieldTypes("template_fields", "select");
		$artify->fieldDataBinding("template_fields", array("Si"=> "Si", "No"=> "No"), "", "","array");

		$artify->buttonHide("submitBtnSaveBack");
		$artify->setSettings("template", "modulos");
		$artify->setSettings("searchbox", true);
		$artify->setSettings("viewbtn", false);
		$artify->setSettings("refresh", false);
		$artify->setSettings("printBtn", false);
		$artify->setSettings("editbtn", true);
		$artify->setSettings("delbtn", true);
		$artify->setSettings("pdfBtn", false);
		$artify->setSettings("csvBtn", false);
		$artify->setSettings("excelBtn", false);
		$artify->setSettings("function_filter_and_search", true);
		$artify->addCallback("before_insert", "insertar_modulos", array($id_sesion_usuario));
		$artify->addCallback("after_insert", "despues_de_insertar_modulos");
		$artify->addCallback("before_update", "actualizar_modulos");
		$artify->addCallback("before_delete", "eliminar_modulos");

		$artify->buttonHide("submitBtn");
		$artify->buttonHide("submitBtnBack");
		$artify->buttonHide("cancel");

		$action = $_ENV["BASE_URL"] . "{controller_name}/index";
		$text = '<i class="fa fa-table" aria-hidden="true"></i>';
		$attr = array("title" => "Ver módulo", "target"=> "_blank");
		$artify->enqueueBtnActions("url btn btn-default btn-sm ", $action, "url", $text, "", $attr);
		//$artify->formFieldValue("query_get", "http://localhost/artify/nombre_controlador_api/nombre_metodo_api");
		$render = $artify->dbTable("modulos")->render();
		$switch = $artify->loadPluginJsCode("bootstrap-switch-master",".actions_buttons_grid, .buttons_actions, .actions_buttons_grid_db, .buttons_actions_db");
		$tags = $artify->loadPluginJsCode("bootstrap-tag-input",".tagsinput");

		$config = DB::ArtifyCrud(true);
		$html_template_config = '
		<div class="card">
		<div class="card-body bg-dark">
			<h5 class="card-title mb-0">Configuración de Api</h5>
		</div>
		<div class="card-body bg-light">

			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item border-0" role="presentation">
					<a class="nav-link active" id="Apiconfig-tab" data-toggle="tab" href="#Apiconfig" role="tab" aria-controls="Apiconfig" aria-selected="false">Configuración de API</a>
				</li>
			</ul>

  				<div class="tab-pane fade show active" id="Apiconfig" role="tabpanel" aria-labelledby="Apiconfig-tab">
				
					<div class="row mt-4">
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-label">Generar JWT Token Api:</label>
								{generar_jwt_token}
								<p class="artify_help_block help-block form-text with-errors"></p>
								<a href="javascript:;" class="btn btn-info generar_token_api d-none">Generar Token</a>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-label">Autenticar JWT Token Api:</label>
								{autenticar_jwt_token}
								<p class="artify_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="form-label">Tiempo de Caducidad token:</label>
								{tiempo_caducidad_token}
								<p class="artify_help_block help-block form-text with-errors"></p>
							</div>
						</div>
					</div>

					<div class="form-group mt-4 text-center">
						<input type="submit" class="btn btn-primary artify-form-control artify-submit mb-3" data-action="insert" value="Guardar">
						<button type="reset" class="btn btn-danger artify-form-control artify-button mb-3 artify-cancel-btn">Cancelar</button>
					</div>


				</div>
			</div>

		</div>';

		$queryfy = $config->getQueryfyObj();
		$configuraciones_api = $queryfy->select("configuraciones_api");

		if($configuraciones_api[0]["generar_jwt_token"] == "Si"){
			$_ENV["ENABLE_JWTAUTH"] = true;
		} else {
			$_ENV["ENABLE_JWTAUTH"] = false;
		}

		$config->setPK("id_configuraciones_api");
		$config->set_template($html_template_config);
		$config->fieldCssClass("generar_jwt_token", array("generar_jwt_token"));
		$config->fieldCssClass("autenticar_jwt_token", array("autenticar_jwt_token"));
		$config->fieldCssClass("tiempo_caducidad_token", array("tiempo_caducidad_token"));
		$config->formFields(array("generar_jwt_token", "autenticar_jwt_token", "tiempo_caducidad_token"));
		$config->formFieldValue("generar_jwt_token", "No");
		$config->fieldNotMandatory("autenticar_jwt_token");
		$config->fieldValidationType("tiempo_caducidad_token", "required", "", "Ingrese un tiempo de Caducidad para el token");
		$config->setSettings("refresh", false);
		$config->setSettings("editbtn", true);
		$config->setSettings("delbtn", true);
		$config->setSettings("function_filter_and_search", false);
		$config->buttonHide("submitBtn");
		$config->buttonHide("cancel");
		$config->fieldTypes("generar_jwt_token", "select");
		$config->fieldDataBinding("generar_jwt_token", array("Si" => "Si", "No" => "No"), "", "", "array");
		$config->buttonHide("submitBtnSaveBack");
		$config->addCallback("before_update", "actualizar_configuracion_api");
		$config->fieldDataAttr("autenticar_jwt_token", array("disabled"=>"disabled"));
		$config->fieldDataAttr("tiempo_caducidad_token", array("disabled"=>"disabled"));
		$render_conf = $config->dbTable("configuraciones_api")->render("editform", array("id" => "1"));

		$tablas = DB::ArtifyCrud(true);
		$tablas->fieldRenameLable("caracteres", "Caracteres");
		$tablas->fieldRenameLable("valor_nulo", "Campo con valor vacio");
		$tablas->setLangData("add", "Agregar Tabla");
		$tablas->setLangData("add_row", "Agregar Campos");
		$tablas->formFields(array("nombre_tabla", "query_tabla", "nombre_campo", "tipo", "caracteres", "autoincremental", "indice", "valor_nulo"));
		$tablas->editFormFields(array("nombre_tabla", "modificar_tabla", "tabla_modificada", "campo_anterior", "nombre_nuevo_campo", "tipo", "caracteres", "autoincremental", "indice", "valor_nulo", "modificar_campo"));
		$tablas->setSearchCols(array("nombre_tabla", "tabla_modificada"));
		$tablas->setSettings("searchbox", true);
		$tablas->setSettings("editbtn", true);
		$tablas->setSettings("delbtn", true);
		$tablas->formFieldValue("valor_nulo", "No");
		$tablas->fieldTypes("modificar_campo", "select");
		$tablas->fieldDataBinding("modificar_campo", array(
			"Si" => "Si",
			"No" => "No"
		), "", "","array");
		
		$tablas->fieldTypes("tipo", "select");
		$tablas->fieldDataBinding("tipo", array(
			"Entero" => "Entero",
			"Caracteres" => "Caracteres",
			"Texto" => "Texto",
			"Fecha" => "Fecha",
			"Número Decimal" => "Número Decimal",
			"Hora" => "Hora",
			"Booleano" => "Verdadero o falso"
		), "", "","array");

		$tablas->fieldTypes("indice", "select");
		$tablas->fieldDataBinding("indice", array(
			"Primario" => "Primario",
			"Sin Indice" => "Sin Indice"
		), "", "","array");

		$tablas->fieldTypes("valor_nulo", "select");
		$tablas->fieldDataBinding("valor_nulo", array(
			"Si" => "Si",
			"No" => "No"
		), "", "","array");

		$tablas->fieldTypes("autoincremental", "select");
		$tablas->fieldDataBinding("autoincremental", array(
			"Si" => "Si",
			"No" => "No"
		), "", "","array");

		$tablas->setSettings("template", "crear_tablas");
		$tablas->setSettings("function_filter_and_search", true);
		$tablas->fieldHideLable("tabla_modificada");
		$tablas->fieldDataAttr("tabla_modificada", array("style"=>"display:none", "value"=>"Si"));
		$tablas->crudRemoveCol(array("id_crear_tablas", "query_tabla", "modificar_tabla"));
		$tablas->fieldCssClass("nombre_tabla", array("nombre_tabla"));
		$tablas->fieldCssClass("query_tabla", array("query_tabla"));

		$tablas->fieldCssClass("nombre_campo", array("nombre"));
		$tablas->fieldCssClass("tipo", array("tipo_de_campo"));
		$tablas->fieldCssClass("caracteres", array("longitud"));
		$tablas->fieldCssClass("indice", array("indice"));
		$tablas->fieldCssClass("valor_nulo", array("nulo"));
		$tablas->fieldCssClass("autoincremental", array("autoincrementable"));
		$tablas->fieldCssClass("modificar_tabla", array("modificar_tabla"));
		$tablas->fieldCssClass("modificar_campo", array("modificar_campo"));
		$tablas->fieldCssClass("nombre_nuevo_campo", array("nombre_nuevo_campo"));
		$tablas->fieldCssClass("campo_anterior", array("campo_anterior"));

		$tablas->buttonHide("submitBtn");
		$tablas->buttonHide("submitBtnBack");
		$tablas->buttonHide("cancel");

		$tablas->buttonHide("submitBtnSaveBack");
		$tablas->fieldAttributes("nombre_tabla", array("placeholder"=> "Nombre de la tabla de la base de datos"));
		$tablas->fieldAttributes("modificar_tabla", array("placeholder"=> "CHANGE nombre_anterior_campo nombre_nuevo_campo VARCHAR(255) NOT NULL,", "style"=> "min-height: 200px; max-height: 200px;"));
		$tablas->fieldAttributes("query_tabla", array("placeholder"=> "Rellena los campos de abajo para completar estos valores o ingresalos manualmente. Ejemplo: id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255)", "style"=> "min-height: 200px; max-height: 200px;"));
		$tablas->fieldRenameLable("modificar_tabla", "Modificar Campos de la tabla");
		$tablas->fieldRenameLable("query_tabla", "Consulta BD para crear Tabla");
		$tablas->colRename("query_tabla", "Consulta BD para crear Tabla");
		$tablas->addCallback("before_insert", "insertar_crear_tablas");
		$tablas->addCallback("before_update", "editar_crear_tablas");
		$tablas->addCallback("before_delete", "eliminar_crear_tablas");
		$tablas->joinTable("estructura_tabla", "estructura_tabla.id_crear_tablas = crear_tablas.id_crear_tablas", "LEFT JOIN");
		$render_tablas = $tablas->dbTable("crear_tablas")->render();

		$pdf = DB::ArtifyCrud(true);
		$pdf->tableHeading("Configuraciones de PDF");
		$pdf->setLangData("add", "Agregar PDF");
		$pdf->setSettings("searchbox", true);
		$pdf->setSettings("editbtn", true);
		$pdf->setSettings("delbtn", true);
		$pdf->setSettings("function_filter_and_search", true);
		$pdf->setLangData("no_data", "No se encontrarón Configuraciones");
		$pdf->colRename("id_configuraciones_pdf", "ID");
		$pdf->fieldTypes("logo_pdf", "FILE_NEW");
		$pdf->fieldTypes("marca_agua_pdf", "FILE_NEW");
		$pdf->buttonHide("submitBtnSaveBack");
		$pdf->fieldNotMandatory("logo_pdf");
		$pdf->fieldNotMandatory("marca_agua_pdf");
		$pdf->fieldGroups("group1",array("logo_pdf","marca_agua_pdf"));
		$render_pdf = $pdf->dbTable("configuraciones_pdf")->render();

		View::render("modulos", 
			[
				'render' => $render, 
				'tags' => $tags,
				'render_conf' => $render_conf, 
				'switch' => $switch, 
				'render_tablas' => $render_tablas, 
				'render_pdf' => $render_pdf
			]
		);
	}

	public function obtener_campos_relacion_union_interna() {
		$request = new Request();
	
		if ($request->getMethod() === 'POST') {
			$lastSelected = $request->post('lastSelected');
			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();
			$data = $queryfy->columnNames($lastSelected);
	
			// Verificar si $data es un array antes de filtrar
			if (is_array($data)) {
				$filteredData = array_filter($data, function($column) {
					return strpos($column, 'id_') === 0;
				});
			} else {
				$filteredData = []; // Si $data no es un array, establecer un array vacío
			}
	
			echo json_encode(["data" => $filteredData]);
		}
	}	

	public function obtener_columnas_tabla(){
		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$tabla = $request->post('tabla');
			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();
			$columnNames = $queryfy->columnNames($tabla);

			echo json_encode(["columnas_tablas" => $columnNames]);
		}
	}

	public function obtener_id_tabla(){
		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$tabla = $request->post('val');
			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();
			$primaryKey = $queryfy->primaryKey($tabla);
			$columnNames = $queryfy->columnNames($tabla);
			$tablas_all = $queryfy->select("crear_tablas");

			echo json_encode(["columnas_tablas" => $columnNames, "id_tablas" => $primaryKey, 'tablas' => $tablas_all]);
		}
	}

	public function obtener_tabla_id(){
		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$dataId = $request->post('dataId');
			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();

			$queryfy->where("id_modulos", $dataId);
			$modulos = $queryfy->select("modulos");

			echo json_encode(["modulos" => $modulos]);
		}
	}

	public function obtener_tablas(){
		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();
			$result = $queryfy->select("crear_tablas");

			echo json_encode(["tablas" => $result]);
		}
	}

	public function generarToken(){
		$request = new Request();

		if ($request->getMethod() === 'POST') {
			try {
				$data = array("data" => array("usuario" => "admin", "password" => "123"));
				$data = json_encode($data);
			
				$client = new Client();
				$response = $client->post("http://localhost/". $_ENV["BASE_URL"]."/api/usuario/?op=jwtauth", [
					'body' => $data
				]);
	
				$result = $response->getBody()->getContents();
				echo $result;
	
			} catch (ClientException $e) {
				if ($e->getResponse()->getStatusCode() == 404) {
					echo $e->getResponse()->getBody()->getContents() . PHP_EOL;
				}
			}
		}
	}

	/*public function obtenerTablaActual(){
		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$tabla = $request->post('tabla');

			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();
			$columnDB = $queryfy->tableFieldInfo($tabla);

			echo json_encode(['columnas_tabla' => $columnDB]);
		}
	}*/

	public function actualizar_orden_menu(){

		$request = new Request();

		if ($request->getMethod() === 'POST') {

			$order = $request->post('order');
			if (isset($order) && is_array($order)) {
				$newOrder = $order;

				foreach ($newOrder as $position => $itemId) {
					$position++;
					$artify = DB::ArtifyCrud();
					$queryfy = $artify->getQueryfyObj();
					$queryfy->where("id_menu", $itemId);
					$queryfy->update("menu", array("orden_menu" => $position));
				}

				echo json_encode(['success' => 'Orden del menu actualizado correctamente']);
			}
		}
	}

	public function actualizar_orden_submenu(){

		$request = new Request();

		if ($request->getMethod() === 'POST') {

			$order = $request->post('order');
			if (isset($order) && is_array($order)) {
				$newOrder = $order;

				foreach ($newOrder as $position => $itemId) {
					$position++;
					$artify = DB::ArtifyCrud();
					$queryfy = $artify->getQueryfyObj();
					$queryfy->where("id_submenu", $itemId);
					$queryfy->update("submenu", array("orden_submenu" => $position));
				}

				echo json_encode(['success' => 'Orden del submenu actualizado correctamente']);
			}
		}
	}

	public function editar_iconos_menu(){

		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$id = $request->post('id');

			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();
			$queryfy->columns = array("icono_menu");
			$queryfy->where("id_menu", $id);
			$data = $queryfy->select("menu");

			$ruta_json = "http://" . $_SERVER['HTTP_HOST'] .$_ENV["BASE_URL"] . "js/icons.json";

			// Lee el contenido del archivo JSON
			$contenido_json = file_get_contents($ruta_json);

			// Decodifica el contenido JSON a un array de PHP
			$icons = json_decode($contenido_json, true);

        	echo json_encode(['data' => $data, 'icons' => $icons], JSON_UNESCAPED_UNICODE);
		}
	}

	public function editar_iconos_submenu(){

		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$id = $request->post('id');

			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();
			$queryfy->columns = array("icono_submenu");
			$queryfy->where("id_submenu", $id);
			$data = $queryfy->select("submenu");

			$ruta_json = "http://" . $_SERVER['HTTP_HOST'] .$_ENV["BASE_URL"] . "js/icons.json";

			// Lee el contenido del archivo JSON
			$contenido_json = file_get_contents($ruta_json);

			// Decodifica el contenido JSON a un array de PHP
			$icons = json_decode($contenido_json, true);

        	echo json_encode(['data' => $data, 'icons' => $icons], JSON_UNESCAPED_UNICODE);
		}
	}

	public function menu(){
		$artify = DB::ArtifyCrud();

		$queryfy = $artify->getQueryfyObj();
		$datamenu = $queryfy->DBQuery("SELECT MAX(orden_menu) as orden FROM menu");
		$newOrdenMenu = $datamenu[0]["orden"] + 1;

		$datasubmenu = $queryfy->DBQuery("SELECT MAX(orden_submenu) as orden_submenu FROM submenu");
		$newOrdenSubMenu = $datasubmenu[0]["orden_submenu"] + 1;

		$artify->addWhereConditionActionButtons("delete", "id_menu", "!=", array(4,5,6,7,10,12,19, 141));
		$artify->addWhereConditionActionButtons("edit", "id_menu", "!=", array(4,5,6,7,10,12,19, 141));

		$action = "javascript:;";
		$text = '<i class="fas fa-arrows-alt-v"></i>';
		$attr = array("title"=>"Arrastra para Reordenar Fila");
		$artify->enqueueBtnActions("url btn btn-primary btn-sm reordenar_fila", $action, "url",$text,"orden_menu", $attr);
		$artify->multiTableRelationDisplay("tab", "Menu");
		$artify->setSearchCols(array("nombre_menu","url_menu", "icono_menu", "submenu", "orden_menu", "area_protegida_menu"));
		$artify->fieldHideLable("orden_menu");
		$artify->fieldDataAttr("orden_menu", array("style"=>"display:none"));
		$artify->fieldHideLable("submenu");
		$artify->fieldDataAttr("submenu", array("style"=>"display:none"));
		$artify->formFieldValue("orden_menu", $newOrdenMenu);
		$artify->formFieldValue("submenu", "No");
		$artify->addPlugin("select2");
		$artify->dbOrderBy("orden_menu asc");
		$artify->addCallback("format_table_data", "formatTableMenu");
		$artify->addCallback("after_insert", "agregar_menu");
		$artify->addCallback("before_delete", "eliminar_menu");
		$artify->fieldTypes("icono_menu", "select");
		$artify->fieldCssClass("icono_menu", array("icono_menu"));
		$artify->fieldCssClass("submenu", array("submenu"));
		$artify->fieldGroups("group1", array("nombre_menu", "url_menu"));
		$artify->fieldGroups("group2", array("icono_menu", "area_protegida_menu"));
		$artify->fieldDesc("area_protegida_menu", "Seleccione si este menu estará protegido por un login de acceso a usuarios o no");
		$artify->crudRemoveCol(array("id_menu"));
		$artify->setSettings("searchbox", true);
		$artify->setSettings("printBtn", false);
		$artify->setSettings("pdfBtn", false);
		$artify->setSettings("csvBtn", false);
		$artify->setSettings("excelBtn", false);
		$artify->setSettings("viewbtn", false);
		$artify->setSettings("refresh", false);
		$artify->setSettings('editbtn', true);    
		$artify->setSettings('delbtn', true);
		$artify->setSettings("function_filter_and_search", true);
		$artify->buttonHide("submitBtnSaveBack");
		$artify->fieldTypes("area_protegida_menu", "select");
		$artify->fieldDataBinding("area_protegida_menu", array("Si" => "Si", "No" => "No"), "", "","array");

		$submenu = DB::ArtifyCrud(true);
		$submenu->multiTableRelationDisplay("tab", "SubMenu");
		$action = "javascript:;";
		$text = '<i class="fas fa-arrows-alt-v"></i>';
		$attr = array("title"=>"Arrastra para Reordenar Fila");
		$submenu->enqueueBtnActions("url btn btn-primary btn-sm reordenar_fila_submenu", $action, "url",$text,"orden_submenu", $attr);
		$submenu->fieldHideLable("orden_submenu");
		$submenu->fieldDataAttr("orden_submenu", array("style"=>"display:none"));
		$submenu->fieldHideLable("id_menu");
		$submenu->fieldDataAttr("id_menu", array("style"=>"display:none"));
		$submenu->setSearchCols(array("nombre_submenu","url_submenu", "icono_submenu", "orden_submenu"));
		$submenu->crudTableCol(array("nombre_submenu","url_submenu", "icono_submenu", "orden_submenu"));
		$submenu->formFields(array("id_menu","nombre_submenu","url_submenu", "icono_submenu", "orden_submenu"));
		$submenu->dbTable("submenu");
		$submenu->dbOrderBy("orden_submenu asc");
		$submenu->addCallback("format_table_data", "formatTableSubMenu");
		$submenu->addCallback("before_insert", "insertar_submenu");
		$submenu->addCallback("after_insert", "despues_insertar_submenu");
		$submenu->addCallback("before_update", "modificar_submenu");
		$submenu->addCallback("before_delete", "eliminar_submenu");
		$submenu->fieldGroups("Name", array("nombre_submenu", "url_submenu"));
		$submenu->formFieldValue("orden_submenu", $newOrdenSubMenu);
		$submenu->setSettings("template", "submenu");
		$submenu->setSettings("printBtn", false);
		$submenu->setSettings("pdfBtn", false);
		$submenu->setSettings('editbtn', true);    
		$submenu->setSettings('delbtn', true);
		$submenu->setSettings("csvBtn", false);
		$submenu->setSettings("excelBtn", false);
		$submenu->setSettings("viewbtn", false);
		$submenu->fieldTypes("icono_submenu", "select");
		$submenu->fieldCssClass("icono_submenu", array("icono_submenu"));
		$submenu->buttonHide("submitBtnSaveBack");
		$artify->multiTableRelation("id_menu", "id_menu", $submenu);
		$select2 = $artify->loadPluginJsCode("select2",".icono_menu, .icono_submenu");
		$render = $artify->dbTable("menu")->render();

		View::render(
			"menu",
				[
					'render' => $render,
					'select2' => $select2
				]
		);
	}

	public function perfil()
	{
		$id = $_SESSION['usuario'][0]["id"];
        $token = $this->token;
		$artify = DB::ArtifyCrud();
		$artify->fieldHideLable("id");
		$artify->fieldCssClass("id", array("d-none"));
		$artify->setSettings("hideAutoIncrement", false);
		$artify->setSettings("required", false);
		$artify->addCallback("before_update", "editar_perfil");
		$artify->fieldGroups("Name",array("nombre","email"));
		$artify->fieldGroups("Name2",array("usuario","password"));
		$artify->fieldGroups("Name3",array("idrol","avatar"));
		$artify->fieldTypes("avatar", "FILE_NEW");
		$artify->fieldTypes("password", "password");
		$artify->fieldRenameLable("nombre", "Nombre Completo");
		$artify->fieldRenameLable("email", "Correo electrónico");
		$artify->fieldRenameLable("password", "Clave de acceso");
		$artify->fieldRenameLable("idrol", "Tipo Usuario");
		$artify->relatedData('idrol','rol','idrol','nombre_rol');
		$artify->formFields(array("id","nombre","email","password","usuario", "idrol", "avatar"));
        $artify->formStaticFields("token_form", "html", "<input type='hidden' name='auth_token' value='" . $token . "' />");
		$artify->fieldDataAttr("password", array("value"=> "", "placeholder" => "*****", "autocomplete" => "new-password"));
		$artify->setPK("id");
		$render = $artify->dbTable("usuario")->render("editform", array("id" => $id));

		View::render(
			"perfil",
			['render' => $render]
		);
	}

	public function dashboard_custom(){
		$artify = DB::ArtifyCrud();
		$artify->addPlugin("select2");
		$artify->formStaticFields("div", "html", "<div class='mostrar_click'></div>");
		$artify->fieldTypes("cantidad_columnas", "select");
		$artify->fieldDataBinding("cantidad_columnas", array(
			"1" => 1,
			"2" => 2,
			"3" => 3,
			"4" => 4,
			"5" => 5,
			"6" => 6
		), "", "","array");
		$artify->fieldNotMandatory("titulo");
		$artify->fieldNotMandatory("icono");
		$artify->fieldNotMandatory("url");
		$artify->setLangData("title_left_join", "Opciones configuración Panel");
		$artify->setLangData("add_row", "Agregar");
		$artify->fieldTypes("icono", "select");
		$artify->fieldCssClass("icono", array("icono"));
		$artify->fieldCssClass("titulo", array("titulo"));
		$artify->fieldCssClass("cantidad_columnas", array("cantidad_columnas"));
		$artify->formFields(array("cantidad_columnas","titulo","icono", "url"));
		$artify->setSettings("template", "dashboard_custom");
		$artify->colRename("id_creador_de_panel", "ID");
		$artify->setSettings("printBtn", false);
		$artify->setSettings("pdfBtn", false);
		$artify->setSettings("csvBtn", false);
		$artify->setSettings("excelBtn", false);
		$artify->setSettings("refresh", false);
		$artify->buttonHide("submitBtnSaveBack");
		$artify->joinTable("custom_panel", "custom_panel.id_creador_de_panel = creador_de_panel.id_creador_de_panel", "LEFT JOIN");
		$render = $artify->dbTable("creador_de_panel")->render();
		$select2 = $artify->loadPluginJsCode("select2",".icono");
		View::render('dashboard_custom', [
			'render' => $render,
			'select2' => $select2
		]);
	}
}
