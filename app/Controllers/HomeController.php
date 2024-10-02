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

	public static function obtener_menu_por_id_usuario($id_usuario){
		$usuario_menu = new UsuarioMenuModel();
		$data_usuario_menu = $usuario_menu->Obtener_menu_por_id_usuario($id_usuario);
		return $data_usuario_menu;
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
				$pdomodel = $artify->getQueryfyObj();

				$menuMarcado = false;
				$menuDesmarcado = false;

				foreach ($selectedMenus as $menu) {
					$menuId = $menu["menuId"];
					$submenuIds = isset($menu["submenuIds"]) ? $menu["submenuIds"] : [];
					$checked = $menu["checked"];

					// Procesar el menú principal
					$existMenu = $pdomodel->where('id_menu', $menuId)
						->where('id_usuario', $userId)
						->select('usuario_menu');

					switch ($checked) {
						case "true":
							if (!$existMenu) {
								$pdomodel->insert('usuario_menu', array(
									"id_usuario" => $userId,
									"id_menu" => $menuId,
									"visibilidad_menu" => "Mostrar"
								));
								$menuMarcado = true;
							} else {
								$pdomodel->where('id_usuario', $userId)
									->where('id_menu', $menuId)
									->update('usuario_menu', array("visibilidad_menu" => "Mostrar"));
								$menuMarcado = true;
							}
							break;

						case "false":
							$pdomodel->where('id_usuario', $userId)
								->where('id_menu', $menuId)
								->update('usuario_menu', array("visibilidad_menu" => "Ocultar"));
							$menuDesmarcado = true;
							break;
					}

					// Procesar los submenús asociados al menú principal
					foreach ($submenuIds as $submenuId) {
						$id_submenu = $submenuId['id'];
						$checked = $submenuId["checked"];

						$existSubmenu = $pdomodel->where('id_submenu', $id_submenu)
							->where('id_usuario', $userId)
							->select('usuario_submenu');

						switch ($checked) {
							case "true":
								if (!$existSubmenu) {
									$pdomodel->insert('usuario_submenu', array(
										"id_usuario" => $userId,
										"id_submenu" => $id_submenu,
										"id_menu" => $menuId,
										"visibilidad_submenu" => "Mostrar"
									));
								} else {
									$pdomodel->where('id_usuario', $userId)
										->where('id_submenu', $id_submenu)
										->where('id_menu', $menuId)
										->update('usuario_submenu', array("visibilidad_submenu" => "Mostrar"));
								}
								break;

							case "false":
								$pdomodel->where('id_usuario', $userId)
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
		$artify->setSettings("addbtn", false);
		$artify->setSettings("viewbtn", false);
		$artify->setSettings('editbtn', true);    
		$artify->setSettings('delbtn', true);
		$artify->setSettings("printBtn", false);
		$artify->setSettings("pdfBtn", false);
		$artify->setSettings("csvBtn", false);
		$artify->setSettings("excelBtn", false);
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
			$artify->setSettings("required", false);
			$artify->setSettings("checkboxCol", false);
			$artify->setSettings("refresh", false);
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
        $respaldos->setSettings("addbtn", false);
		$respaldos->setSettings('editbtn', true);    
		$respaldos->setSettings('delbtn', true);
        $respaldos->setSettings("viewbtn", false);
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
			$pdomodel = $artify->getQueryfyObj();
			$id = $pdomodel->select("backup");

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

			$pdomodel->insert("backup", array("archivo" => basename($file), "fecha" => $date, "hora" => $hour, "usuario" => $user));

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
		$pdomodel = $artify->getQueryfyObj();
		$pdomodel->orderBy(array("orden_menu asc"));
		$data = $pdomodel->select("menu");
		return $data;
	}

	public static function submenuDB($idMenu){
		$artify = DB::ArtifyCrud();
		$pdomodel = $artify->getQueryfyObj();
		$pdomodel->where("id_menu", $idMenu, "=");
		$pdomodel->orderBy(array("orden_submenu asc")); // Ajusta el nombre de la columna de ordenación si es diferente
		$data = $pdomodel->select("submenu");
		return $data;
	}	

	public function modulos()
	{
		$id_sesion_usuario = $_SESSION['usuario'][0]["id"];

		$artify = DB::ArtifyCrud();
		$html_template = '
		<div class="card">
		<div class="card-body bg-dark">
			<h5 class="card-title mb-0">Generador de Módulos</h5>
		</div>
		<div class="card-body bg-light">

		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
				<a class="nav-link active" id="modulos-tab" data-toggle="tab" href="#modulos" role="tab" aria-controls="modulos" aria-selected="true">Configuración de Módulos</a>
			</li>
			<li class="nav-item" role="presentation">
				<a class="nav-link" id="pdf-tab" data-toggle="tab" href="#pdf" role="tab" aria-controls="pdf" aria-selected="false">Configuración de PDF</a>
			</li>
			 <li class="nav-item" role="presentation">
				<a class="nav-link" id="Api-tab" data-toggle="tab" href="#Api" role="tab" aria-controls="Api" aria-selected="false">Configuración Api</a>
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
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Nombre Tabla Base de Datos:</label>
								{tabla}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
								<p>Cambie por su tabla o utilice la actual</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">ID Tabla Base de Datos:</label>
								{id_tabla}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Nombre del Controlador:</label>
								{controller_name}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
								<p>Cambie por su controlador o utilice el actual</p>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Consulta DB:</label>
								{query}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
								<p>Cambie por su consulta o utilice la actual</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Columnas de La Tabla:</label>
								{columns_table}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Nombre de La Vista:</label>
								{name_view}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
								<p>Cambie por su vista o utilice la actual</p>
							</div>
						</div>
						<div class="col-md-12 d-none">
							<div class="form-group">
								<label class="form-label">Agregar Al Menú Principal:</label>
								{add_menu}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Usar Plantilla Formulario HTML:</label>
								{template_fields}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Activar Filtro de Busqueda:</label>
								{active_filter}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Clonar Filas:</label>
								{clone_row}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Activar Popup:</label>
								{active_popup}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Activar Búsqueda:</label>
								{active_search}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Activar Eliminación Masiva:</label>
								{activate_deleteMultipleBtn}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Botón Agregar:</label>
								{button_add}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Botones de Exportación Grilla:</label>
								{actions_buttons_grid}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Activar Tabla Anidada:</label>
								{activate_nested_table}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Botones de Acción:</label>
								{buttons_actions}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="form-label">Refrescar Grilla:</label>
								{refrescar_grilla}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Seleccionar Tema:</label>
								{selected_theme}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Seleccionar Piel:</label>
								{selected_skin}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
					</div>
					<div class="row modificar_tabla_col">
						<div class="col-md-6">
							<div class="form-group">
								<label class="form-label">Modificar Tabla:</label>
								{modify_query}
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>
						<div class="col-md-6 campos_view_tabla">
							<div class="form-group">
								<label class="form-label">Vista Previa Campos Tabla Actual:</label>
								<ul class="list-group vista_previa_campos_tabla"></ul>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="component addrow float-right">
								<div class="control-group">
									<div class="controls">
										<a class="pdocrud-actions pdocrud-button pdocrud-button-add-row btn btn-success agregar_muestras d-none" href="javascript:;" data-action="add_row_module">
											<i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar       
										</a>
									</div>
								</div>
							</div>
							<div class="table-responsive leftjoin_grilla d-none">
							<table class="table pdocrud-left-join responsive">
								<thead>
									<tr>
										<th>
											<label class=" control-label col-form-label">Número de módulo a crear</label>
										</th>
										<th>
											<label class=" control-label col-form-label">Nombre Tabla Base de Datos</label>
										</th>
										<th>
											<label class=" control-label col-form-label">Columnas de la Tabla</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Usar Plantilla Formulario HTML</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Activar Filtro de Busqueda</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Clonar Filas</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Activar Popup</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Activar Búsqueda</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Activar Eliminación Masiva</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Botón Agregar</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Botones de Exportación Grilla</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Activar Tabla Anidada</label>
										</th>  
										<th>
											<label class=" control-label col-form-label">Botones de Acción</label>
										</th>    
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_1">
											<select class="form-control pdocrud-form-control pdocrud-select nivel" name="nivel_db[]" disabled="disabled" required="1">
												<option value="">Seleccionar</option>
												<option selected="selected" value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
											</select>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_2">
											<input type="text" class="form-control pdocrud-form-control pdocrud-text tabla_db" name="tabla_db[]" disabled="disabled" required="1">
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_3">
											<textarea class="form-control pdocrud-form-control  pdocrud-textarea consulta_crear_tabla" name="consulta_crear_tabla[]" disabled="disabled" placeholder="Rellena los campos de abajo para completar estos valores o ingresalos manualmente. Ejemplo: id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255)" style="min-height: 200px; max-height: 200px;" required="1"></textarea>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_4">
											<select class="form-control pdocrud-form-control pdocrud-select template_fields_db" disabled="disabled" name="template_fields_db[]" required="1">
												<option value="">Seleccionar</option>
												<option value="Si">Si</option>
												<option selected="selected" value="No">No</option>
											</select>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_5">
											<select class="form-control pdocrud-form-control pdocrud-select active_filter_db" disabled="disabled" name="active_filter_db[]" required="1">
												<option value="">Seleccionar</option>
												<option value="Si">Si</option>
												<option selected="selected" value="No">No</option>
											</select>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_6">
											<select class="form-control pdocrud-form-control pdocrud-select clone_row_db" disabled="disabled" name="clone_row_db[]" required="1">
												<option value="">Seleccionar</option>
												<option value="Si">Si</option>
												<option selected="selected" value="No">No</option>
											</select>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_7">
											<select class="form-control pdocrud-form-control pdocrud-select active_popup_db" disabled="disabled" name="active_popup_db[]" required="1">
												<option value="">Seleccionar</option>
												<option value="Si">Si</option>
												<option selected="selected" value="No">No</option>
											</select>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_8">
											<select class="form-control pdocrud-form-control pdocrud-select " id="active_search_db" disabled="disabled" name="active_search_db[]" required="1">
												<option value="">Seleccionar</option>
												<option value="Si">Si</option>
												<option selected="selected" value="No">No</option>
											</select>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_9">
											<select class="form-control pdocrud-form-control pdocrud-select activate_deleteMultipleBtn_db" disabled="disabled" name="activate_deleteMultipleBtn_db[]" required="1">
												<option value="">Seleccionar</option>
												<option value="Si">Si</option>
												<option selected="selected" value="No">No</option>
											</select>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_10">
											<select class="form-control pdocrud-form-control pdocrud-select button_add_db" disabled="disabled" name="button_add_db[]" required="1">
												<option value="">Seleccionar</option>
												<option value="Si">Si</option>
												<option selected="selected" value="No">No</option>
											</select>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_11">
											<div class="checkbox pdocrud-checkbox-group">
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox actions_buttons_grid_db" disabled="disabled" name="actions_buttons_grid_db[]" value="Imprimir">Imprimir</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox actions_buttons_grid_db" disabled="disabled" name="actions_buttons_grid_db[]" value="PDF">PDF</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox actions_buttons_grid_db" disabled="disabled" name="actions_buttons_grid_db[]" value="CSV">CSV</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox actions_buttons_grid_db" disabled="disabled" name="actions_buttons_grid_db[]" value="Excel">Excel</label>
											</div>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_12">
											<select class="form-control pdocrud-form-control pdocrud-select activate_nested_table_db" disabled="disabled" name="activate_nested_table_db[]" required="1">
												<option value="">Seleccionar</option>
												<option value="Si">Si</option>
												<option selected="selected" value="No">No</option>
											</select>
										</td>
										<td class="pdocrud_leftjoin_row_1 pdocrud_leftjoin_col_13">
											<div class="checkbox pdocrud-checkbox-group">
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox buttons_actions_db" disabled="disabled" name="buttons_actions_db[]" value="Ver">Mostrar botón Ver</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox buttons_actions_db" disabled="disabled" name="buttons_actions_db[]" value="Editar">Mostrar botón Editar</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox buttons_actions_db" disabled="disabled" name="buttons_actions_db[]" value="Eliminar">Mostrar botón Eliminar</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox buttons_actions_db" disabled="disabled" name="buttons_actions_db[]" value="Guardar">Ocultar botón Guardar</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox buttons_actions_db" disabled="disabled" name="buttons_actions_db[]" value="Guardar y regresar">Ocultar botón Guardar y regresar</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox buttons_actions_db" disabled="disabled" name="buttons_actions_db[]" value="Regresar">Ocultar botón Regresar</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox buttons_actions_db" disabled="disabled" name="buttons_actions_db[]" value="Cancelar">Ocultar botón Cancelar</label>
												<label class="checkbox-inline">
													<input type="checkbox" class="pdocrud-form-control pdocrud-checkbox buttons_actions_db" disabled="disabled" name="buttons_actions_db[]" value="Personalizado PDF">Mostrar botón Personalizado PDF</label>
											</div>
										</td>
										<td>
											<a href="javascript:;" class="pdocrud-actions btn btn-danger" data-action="delete_row"><i class="fa fa-remove"></i> Remover</a>
										</td>
									</tr>
								</tbody>
							</table>
							</div>

							<div class="row mt-4">
								<div class="col-md-12 text-center">
									<button type="button" class="btn btn-danger pdocrud-form-control pdocrud-button pdocrud-back" name="pdocrud_submit_19MsSO3Edq_back" data-action="back">Regresar</button> 
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
								<p class="pdocrud_help_block help-block form-text with-errors"></p>
							</div>
						</div>	
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Subir Logo PDF:</label>
							{logo_pdf}
							<p class="pdocrud_help_block help-block form-text with-errors"></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="form-label">Subir Marca de Agua PDF:</label>
							{marca_de_agua_pdf}
							<p class="pdocrud_help_block help-block form-text with-errors"></p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label">Consulta de Base de Datos PDF:</label>
							{consulta_pdf}
							<p class="pdocrud_help_block help-block form-text with-errors"></p>
						</div>
					</div>	
				</div>

				<div class="row mt-4">
					<div class="col-md-12 text-center">
						<button type="button" class="btn btn-danger pdocrud-form-control pdocrud-button pdocrud-back" name="pdocrud_submit_19MsSO3Edq_back" data-action="back">Regresar</button> 
						<a href="javascript:;" class="btn btn-primary anterior"><i class="fa fa-arrow-left"></i> Anterior</a>
						<a href="javascript:;" class="btn btn-primary siguiente_2">Siguiente <i class="fa fa-arrow-right"></i></a>
					</div>
				</div>
		
			</div>

			<div class="tab-pane fade" id="Api" role="tabpanel" aria-labelledby="Api-tab">

				<div class="row mt-4">
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label">Activar Api:</label>
							{activate_api}
							<p class="pdocrud_help_block help-block form-text with-errors"></p>
						</div>
					</div>	
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-label">Tipo de APi:</label>
							{api_type}
							<p class="pdocrud_help_block help-block form-text with-errors"></p>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-label">Generar JWT Token Api:</label>
							{generate_token_jwt}
							<p class="pdocrud_help_block help-block form-text with-errors"></p>
							<a href="javascript:;" class="btn btn-info generar_token_api d-none">Generar Token</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label class="form-label">Autenticar JWT Token Api:</label>
							{autenticate_jwt_token}
							<p class="pdocrud_help_block help-block form-text with-errors"></p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label class="form-label">Consulta de Base de Datos Api:</label>
							{consulta_api}
							<p class="pdocrud_help_block help-block form-text with-errors"></p>
						</div>
					</div>
				</div>


				<div class="form-group mt-4 text-center">
					<a href="javascript:;" class="btn btn-primary mb-3 atras"><i class="fa fa-arrow-left"></i> Anterior</a>
                	<input type="submit" class="btn btn-primary pdocrud-form-control pdocrud-submit mb-3" name="pdocrud_submit_19MsSO3Edq" data-action="insert" value="Guardar"> 
					<button type="button" class="btn btn-danger pdocrud-form-control pdocrud-button mb-3 pdocrud-back" name="pdocrud_submit_19MsSO3Edq_back" data-action="back">Regresar</button> 
					<button type="reset" class="btn btn-danger pdocrud-form-control pdocrud-button mb-3 pdocrud-cancel-btn" name="pdocrud_cancel_19MsSO3Edq">Cancelar</button>
				</div>

			</div>
		</div>

		</div>
		</div>
		';
		$artify->set_template($html_template);
		$artify->setLangData("no_data", "No Hay Módulos creados");
		$artify->formFieldValue("active_popup", "No");
		$artify->formFieldValue("add_menu", "Si");
		$artify->formFieldValue("active_filter", "No");
		$artify->formFieldValue("clone_row", "No");
		$artify->formFieldValue("button_add", "Si");
		$artify->formFieldValue("activate_deleteMultipleBtn", "No");
		$artify->formFieldValue("active_search", "No");
		$artify->fieldNotMandatory("actions_buttons_grid");
		$artify->fieldNotMandatory("buttons_actions");
		$artify->formFieldValue("activate_nested_table", "No");
		$artify->formFieldValue("activate_pdf", "No");
		$artify->formFieldValue("activate_api", "No");
		$artify->formFieldValue("generate_token_jwt", "No");
		$artify->formFieldValue("refrescar_grilla", "No");
		$artify->formFieldValue("selected_theme", "bootstrap4");
		$artify->formFieldValue("selected_skin", "fair");

		$artify->fieldNotMandatory("modify_query");
		$artify->fieldTypes("logo_pdf", "select");
		$artify->fieldTypes("marca_de_agua_pdf", "select");

		$artify->fieldDataAttr("logo_pdf", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("marca_de_agua_pdf", array("disabled"=>"disabled"));

		$artify->fieldDataAttr("generate_token_jwt", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("api_type", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("autenticate_jwt_token", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("consulta_api", array("disabled"=>"disabled"));
		$artify->fieldDataAttr("consulta_pdf", array("disabled"=>"disabled"));

		$artify->fieldTypes("refrescar_grilla", "select");
		$artify->fieldDataBinding("refrescar_grilla", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("generate_token_jwt", "select");
		$artify->fieldDataBinding("generate_token_jwt", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("selected_theme", "select");
		$artify->fieldDataBinding("selected_theme", array("bootstrap4" => "bootstrap4", "bootstrap" => "bootstrap", "pure" => "pure"), "", "", "array");

		$artify->fieldTypes("selected_skin", "select");
		$artify->fieldDataBinding("selected_skin", array("fair" => "fair", "advance" => "advance", "default" => "default", "pure" => "pure"), "", "", "array");

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
		$artify->fieldDataBinding("actions_buttons_grid", array("Imprimir" => "Imprimir", "PDF" => "PDF", "CSV" => "CSV", "Excel" => "Excel"), "", "", "array");

		$artify->fieldTypes("api_type", "checkbox");
		$artify->fieldDataBinding("api_type", array("Obtener" => "Obtener", "Insertar" => "Insertar", "Actualizar" => "Actualizar", "Eliminar" => "Eliminar"), "", "", "array");

		$artify->fieldTypes("activate_nested_table", "select");
		$artify->fieldDataBinding("activate_nested_table", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("button_add", "select");
		$artify->fieldDataBinding("button_add", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activate_pdf", "select");
		$artify->fieldDataBinding("activate_pdf", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activate_api", "select");
		$artify->fieldDataBinding("activate_api", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("activate_deleteMultipleBtn", "select");
		$artify->fieldDataBinding("activate_deleteMultipleBtn", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("active_search", "select");
		$artify->fieldDataBinding("active_search", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("active_popup", "select");
		$artify->fieldDataBinding("active_popup", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("active_filter", "select");
		$artify->fieldDataBinding("active_filter", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldTypes("clone_row", "select");
		$artify->fieldDataBinding("clone_row", array("Si" => "Si", "No" => "No"), "", "", "array");

		$artify->fieldCssClass("crud_type", array("crud_type"));
		$artify->fieldCssClass("tabla", array("tabla"));
		$artify->fieldCssClass("id_tabla", array("id_tabla"));
		$artify->fieldCssClass("query", array("query"));
		$artify->fieldCssClass("name_view", array("name_view"));
		$artify->fieldCssClass("controller_name", array("controller_name"));
		$artify->fieldCssClass("columns_table", array("columns_table"));
		$artify->fieldCssClass("modify_query", array("modify_query"));
		$artify->fieldCssClass("activate_nested_table", array("activate_nested_table"));
		$artify->fieldCssClass("consulta_api", array("consulta_api"));
		$artify->fieldCssClass("consulta_pdf", array("consulta_pdf"));

		$artify->fieldCssClass("api_type", array("api_type"));
		$artify->fieldCssClass("generate_token_jwt", array("generate_token_jwt"));
		$artify->fieldCssClass("activate_api", array("activate_api"));
		$artify->fieldCssClass("autenticate_jwt_token", array("autenticate_jwt_token"));

		$artify->fieldAttributes("consulta_pdf", array("placeholder"=> "Ejemplo: SELECT id as item FROM tabla", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldAttributes("consulta_api", array("placeholder"=> "Ejemplo: SELECT id as item FROM tabla", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldAttributes("consulta_crear_tabla", array("placeholder"=> "Rellena los campos de abajo para completar estos valores o ingresalos manualmente. Ejemplo: id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255)", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldAttributes("query", array("placeholder"=> "Ejemplo: SELECT id as ID, name as Name FROM demo", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldAttributes("modify_query", array("placeholder"=> "Ejemplo: DROP COLUMN categoria, ADD COLUMN edad INT(3)", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldAttributes("columns_table", array("placeholder"=> "Rellena los campos de abajo para completar estos valores o ingresalos manualmente. Ejemplo: id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255)", "style"=> "min-height: 200px; max-height: 200px;"));
		$artify->fieldGroups("Name2",array("name_view","add_menu"));
		$artify->tableHeading("Generador de Módulos");
		
		$artify->setSearchCols(array("selected_theme", "selected_skin", "consulta_api", "consulta_pdf", "refrescar_grilla", "autenticate_jwt_token", "activate_api", "api_type", "generate_token_jwt", "marca_de_agua_pdf", "activate_pdf", "id_modulos", "tabla", "id_tabla", "crud_type", "query", "controller_name", "columns_table", "name_view", "add_menu", "template_fields", "active_filter", "clone_row", "active_popup", "active_search", "activate_deleteMultipleBtn", "button_add", "actions_buttons_grid", "activate_nested_table", "buttons_actions"));
		$artify->formFields(array("selected_theme", "selected_skin", "consulta_api", "consulta_pdf", "refrescar_grilla", "autenticate_jwt_token", "logo_pdf", "activate_api", "api_type", "generate_token_jwt", "marca_de_agua_pdf", "activate_pdf", "tabla", "id_tabla", "crud_type", "query", "controller_name", "columns_table", "name_view", "add_menu", "template_fields", "active_filter", "clone_row", "active_popup", "active_search", "activate_deleteMultipleBtn", "button_add", "actions_buttons_grid", "activate_nested_table", "buttons_actions"));
		$artify->editFormFields(array("selected_theme", "selected_skin", "consulta_api", "consulta_pdf", "refrescar_grilla", "autenticate_jwt_token", "logo_pdf", "activate_api", "api_type", "generate_token_jwt", "marca_de_agua_pdf", "activate_pdf", "tabla", "id_tabla", "crud_type", "query", "controller_name", "columns_table", "name_view", "add_menu", "template_fields", "active_filter", "clone_row", "active_popup", "active_search", "activate_deleteMultipleBtn", "button_add", "actions_buttons_grid","modify_query", "activate_nested_table", "buttons_actions"));

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
		$artify->colRename("selected_theme", "Seleccionar Tema");

		$artify->colRename("active_filter", "Activar Filtro de Busqueda");
		$artify->colRename("clone_row", "Clonar Fila");
		
		$artify->colRename("template_fields", "Usar Plantilla Formulario HTML");

		$artify->fieldConditionalLogic("crud_type", "CRUD", "=", "query", "hide");
		$artify->fieldConditionalLogic("crud_type", "CRUD", "!=", "query", "show");

		$artify->fieldConditionalLogic("crud_type", "Modulo de Inventario", "=", "query", "hide");

		$artify->fieldConditionalLogic("crud_type", "CRUD", "=", "id_tabla", "hide");
		$artify->fieldConditionalLogic("crud_type", "CRUD", "!=", "id_tabla", "show");

		$artify->fieldConditionalLogic("crud_type", "Modulo de Inventario", "=", "id_tabla", "hide");
		
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
			"Modulo de Inventario" => "Modulo de Inventario"
		), "", "","array");

		$artify->fieldTypes("add_menu", "select");
		$artify->fieldDataBinding("add_menu", array("Si"=> "Si"), "", "","array");

		$artify->fieldTypes("template_fields", "select");
		$artify->fieldDataBinding("template_fields", array("Si"=> "Si", "No"=> "No"), "", "","array");

		$artify->buttonHide("submitBtnSaveBack");
		$artify->setSettings("template", "modulos");
		$artify->setSettings("viewbtn", false);
		$artify->setSettings("refresh", false);
		$artify->setSettings("printBtn", false);
		$artify->setSettings("editbtn", true);
		$artify->setSettings("delbtn", true);
		$artify->setSettings("pdfBtn", false);
		$artify->setSettings("csvBtn", false);
		$artify->setSettings("excelBtn", false);
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
		
		//$artify->joinTable("anidada", "anidada.id_modulos = modulos.id_modulos", "LEFT JOIN");
		$render = $artify->dbTable("modulos")->render();


		$config = DB::ArtifyCrud(true);
		$config->formDisplayInPopup();
		$config->setSettings("refresh", false);
		$config->fieldTypes("logo_pdf", "FILE_NEW");
		$config->fieldTypes("marca_agua_pdf", "FILE_NEW");
		$config->buttonHide("submitBtnSaveBack");
		$config->buttonHide("cancel");
		$render_conf = $config->dbTable("configuraciones_modulos")->render();

		View::render(
			"modulos",
			['render' => $render, 'render_conf' => $render_conf]
		);
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


	public function obtenerTablaActual(){
		$request = new Request();

		if ($request->getMethod() === 'POST') {
			$tabla = $request->post('tabla');

			$artify = DB::ArtifyCrud();
			$pdomodel = $artify->getQueryfyObj();
			$columnDB = $pdomodel->tableFieldInfo($tabla);

			echo json_encode(['columnas_tabla' => $columnDB]);
		}
	}

	public function actualizar_orden_menu(){

		$request = new Request();

		if ($request->getMethod() === 'POST') {

			$order = $request->post('order');
			if (isset($order) && is_array($order)) {
				$newOrder = $order;

				foreach ($newOrder as $position => $itemId) {
					$position++;
					$artify = DB::ArtifyCrud();
					$pdomodel = $artify->getQueryfyObj();
					$pdomodel->where("id_menu", $itemId);
					$pdomodel->update("menu", array("orden_menu" => $position));
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
					$pdomodel = $artify->getQueryfyObj();
					$pdomodel->where("id_submenu", $itemId);
					$pdomodel->update("submenu", array("orden_submenu" => $position));
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
			$pdomodel = $artify->getQueryfyObj();
			$pdomodel->columns = array("icono_menu");
			$pdomodel->where("id_menu", $id);
			$data = $pdomodel->select("menu");

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
			$pdomodel = $artify->getQueryfyObj();
			$pdomodel->columns = array("icono_submenu");
			$pdomodel->where("id_submenu", $id);
			$data = $pdomodel->select("submenu");

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

		$pdomodel = $artify->getQueryfyObj();
		$datamenu = $pdomodel->DBQuery("SELECT MAX(orden_menu) as orden FROM menu");
		$newOrdenMenu = $datamenu[0]["orden"] + 1;

		$datasubmenu = $pdomodel->DBQuery("SELECT MAX(orden_submenu) as orden_submenu FROM submenu");
		$newOrdenSubMenu = $datasubmenu[0]["orden_submenu"] + 1;

		$artify->addWhereConditionActionButtons("delete", "id_menu", "!=", array(4,5,6,7,10,12,19, 141));
		$artify->addWhereConditionActionButtons("edit", "id_menu", "!=", array(4,5,6,7,10,12,19, 141));

		$action = "javascript:;";
		$text = '<i class="fas fa-arrows-alt-v"></i>';
		$attr = array("title"=>"Arrastra para Reordenar Fila");
		$artify->enqueueBtnActions("url btn btn-primary btn-sm reordenar_fila", $action, "url",$text,"orden_menu", $attr);
		$artify->multiTableRelationDisplay("tab", "Menu");
		$artify->setSearchCols(array("nombre_menu","url_menu", "icono_menu", "submenu", "orden_menu"));
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
		$artify->fieldGroups("Name", array("nombre_menu", "url_menu"));
		$artify->crudRemoveCol(array("id_menu"));
		$artify->setSettings("printBtn", false);
		$artify->setSettings("pdfBtn", false);
		$artify->setSettings("csvBtn", false);
		$artify->setSettings("excelBtn", false);
		$artify->setSettings("viewbtn", false);
		$artify->setSettings("refresh", false);
		$artify->setSettings('editbtn', true);    
		$artify->setSettings('delbtn', true);
		$artify->buttonHide("submitBtnSaveBack");

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
