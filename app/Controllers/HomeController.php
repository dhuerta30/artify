<?php

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\Request;
use App\core\View;
use App\core\Redirect;
use App\core\DB;
use Xinvoice;
use Coderatio\SimpleBackup\SimpleBackup;
use App\Models\DatosPacienteModel;
use App\Models\PageModel;
use App\Models\UsuarioMenuModel;
use App\Models\UserModel;
use App\Models\ProcedimientoModel;
use App\Models\UsuarioSubMenuModel;

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
				$pdocrud = DB::PDOCrud();
				$pdomodel = $pdocrud->getPDOModelObj();

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
		$pdocrud = DB::PDOCrud();
		$pdocrud->colRename("idrol", "Rol");
		$pdocrud->colRename("id", "ID");
		$pdocrud->relatedData('idrol','rol','idrol','nombre_rol');
		$pdocrud->tableColFormatting("avatar", "html",array("type" =>"html","str"=>'<img width="50" src="'.$_ENV["BASE_URL"].'app/libs/script/uploads/{col-name}">'));
		$pdocrud->crudRemoveCol(array("rol","estatus","password", "token", "token_api", "expiration_token"));
		$pdocrud->setSearchCols(array("id","nombre","email", "usuario", "idrol"));
		$pdocrud->setSettings("addbtn", false);
		$pdocrud->setSettings("viewbtn", false);
		$pdocrud->setSettings("delbtn", false);
		$pdocrud->setSettings("printBtn", false);
		$pdocrud->setSettings("pdfBtn", false);
		$pdocrud->setSettings("csvBtn", false);
		$pdocrud->setSettings("excelBtn", false);
		$pdocrud->setSettings("template", "acceso_usuarios_menus");
		$pdocrud->setSettings("deleteMultipleBtn", false);
		$pdocrud->setSettings("checkboxCol", false);
		$render = $pdocrud->dbTable("usuario")->render();

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
			$pdocrud = DB::PDOCrud();
			$pdocrud->fieldCssClass("id", array("d-none"));
			$pdocrud->tableHeading("Lista de usuarios");
            $pdocrud->formStaticFields("token_form", "html", "<input type='hidden' name='auth_token' value='" . $token . "' />");
			$pdocrud->tableColFormatting("avatar", "html",array("type" =>"html","str"=>'<img width="80" src="'.$_ENV["BASE_URL"].'app/libs/script/uploads/{col-name}">'));
			$pdocrud->fieldDataAttr("password", array("value"=>"", "placeholder" => "*****", "autocomplete" => "new-password"));
			$pdocrud->formDisplayInPopup();
			$pdocrud->fieldGroups("Name",array("nombre","email"));
			$pdocrud->fieldGroups("Name2",array("usuario","password"));
			$pdocrud->fieldGroups("Name3",array("idrol","avatar"));
			$pdocrud->setSettings("required", false);
			$pdocrud->setSettings("checkboxCol", false);
			$pdocrud->setSettings("refresh", false);
			$pdocrud->setSettings("deleteMultipleBtn", false);
			$pdocrud->colRename("id", "ID");
			$pdocrud->colRename("idrol", "Rol");
			$pdocrud->colRename("email", "Correo");
			$pdocrud->fieldHideLable("id");
			$pdocrud->addCallback("before_insert", "insetar_usuario");
			$pdocrud->addCallback("before_update", "editar_usuario");
			$pdocrud->crudRemoveCol(array("rol","estatus","password", "token", "token_api", "expiration_token"));
			$pdocrud->setSearchCols(array("id","nombre","email", "usuario", "idrol"));
			$pdocrud->where("estatus", 1);
			$pdocrud->recordsPerPage(5);
			$pdocrud->fieldTypes("avatar", "FILE_NEW");
			$pdocrud->fieldTypes("password", "password");
			$pdocrud->fieldRenameLable("nombre", "Nombre Completo");
			$pdocrud->fieldRenameLable("email", "Correo electrónico");
			$pdocrud->fieldRenameLable("password", "Clave de acceso");
			$pdocrud->fieldRenameLable("idrol", "Tipo Usuario");
			$pdocrud->setSettings("viewbtn", false);
			$pdocrud->setSettings("hideAutoIncrement", false);
			$pdocrud->setSettings("template", "usuarios");
			$pdocrud->buttonHide("submitBtnSaveBack");
			$pdocrud->formFields(array("id","nombre","email","password","usuario", "idrol", "avatar"));
			$pdocrud->setRecordsPerPageList(array(5, 10, 15, 'All'=> 'Todo'));
			$pdocrud->setSettings("printBtn", false);
			$pdocrud->setSettings("pdfBtn", false);
			$pdocrud->setSettings("csvBtn", false);
			$pdocrud->setSettings("excelBtn", false);
			$pdocrud->relatedData('idrol','rol','idrol','nombre_rol');
			$render = $pdocrud->dbTable("usuario")->render();

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
		$respaldos = DB::PDOCrud();
        $respaldos->tableHeading("Respaldos");
        $respaldos->fieldTypes("file", "file");
        $respaldos->dbOrderBy("hora desc");
		$respaldos->tableColFormatting("fecha", "date",array("format" =>"d/m/Y"));
		$respaldos->setSearchCols(array("usuario", "fecha", "hora"));
        $respaldos->tableColFormatting("archivo", "html", array("type" => "html", "str" => "<a class='btn btn-success btn-sm' href=\"".$_ENV["BASE_URL"]."app/libs/script/uploads/{col-name}\" data-attribute=\"abc-{col-name}\"><i class=\"fa fa-download\"></i> Descargar Respaldo</a>"));
        $respaldos->setSettings("addbtn", false);
		$respaldos->setSettings("editbtn", false);
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

			$pdocrud = DB::PDOCrud();
			$pdomodel = $pdocrud->getPDOModelObj();
			$id = $pdomodel->select("backup");

			$exportDirectory = realpath(__DIR__ . '/../libs/script/uploads');

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
		$pdocrud = DB::PDOCrud();
		$pdomodel = $pdocrud->getPDOModelObj();
		$pdomodel->orderBy(array("orden_menu asc"));
		$data = $pdomodel->select("menu");
		return $data;
	}

	public static function submenuDB($idMenu){
		$pdocrud = DB::PDOCrud();
		$pdomodel = $pdocrud->getPDOModelObj();
		$pdomodel->where("id_menu", $idMenu, "=");
		$pdomodel->orderBy(array("orden_submenu asc")); // Ajusta el nombre de la columna de ordenación si es diferente
		$data = $pdomodel->select("submenu");
		return $data;
	}	

	public function modulos()
	{
		$id_sesion_usuario = $_SESSION['usuario'][0]["id"];

		$pdocrud = DB::PDOCrud();
		$html_template = '<div class="form">
			<h5>Agregar Módulo</h5>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Tipo de Crud:</label>
						{crud_type}
						<p class="pdocrud_help_block help-block form-text with-errors"></p>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Nombre Tabla Base de Datos:</label>
						{tabla}
						<p class="pdocrud_help_block help-block form-text with-errors"></p>
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
						<label class="form-label">Consulta DB:</label>
						{query}
						<p class="pdocrud_help_block help-block form-text with-errors"></p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Nombre del Controlador:</label>
						{controller_name}
						<p class="pdocrud_help_block help-block form-text with-errors"></p>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Columnas de La Tabla:</label>
						{columns_table}
						<p class="pdocrud_help_block help-block form-text with-errors"></p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label">Nombre de La Vista:</label>
						{name_view}
						<p class="pdocrud_help_block help-block form-text with-errors"></p>
					</div>
				</div>
				<div class="col-md-4 d-none">
					<div class="form-group">
						<label class="form-label">Agregar Al Menú Principal:</label>
						{add_menu}
						<p class="pdocrud_help_block help-block form-text with-errors"></p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="form-label">Usar Plantilla Formulario HTML:</label>
						{template_fields}
						<p class="pdocrud_help_block help-block form-text with-errors"></p>
					</div>
				</div>
			</div>
		</div>';
		$pdocrud->set_template($html_template);
		//$pdocrud->formDisplayInPopup();
		$pdocrud->formFieldValue("add_menu", "Si");

		$pdocrud->fieldTypes("tipo_de_campo", "select");
		$pdocrud->fieldDataBinding("tipo_de_campo", array("Imagen" => "Imagen", "Combobox" => "Combobox", "Input" => "Input", "Campo de Texto" => "Campo de Texto"), "", "", "array");

		$pdocrud->fieldCssClass("crud_type", array("crud_type"));
		$pdocrud->fieldCssClass("id_tabla", array("id_tabla"));
		$pdocrud->fieldCssClass("query", array("query"));

		$pdocrud->fieldTypes("autoincrementable", "select");
		$pdocrud->fieldDataBinding("autoincrementable", array("Si" => "Si", "No" => "No"), "", "", "array");
		
		$pdocrud->fieldTypes("tipo", "select");
		$pdocrud->fieldDataBinding("tipo", array("Numerico" => "Numerico", "Caracteres" => "Caracteres", "Contenido" => "Contenido", "Fecha" => "Fecha"), "", "", "array");

		$pdocrud->fieldTypes("nulo", "select");
		$pdocrud->fieldDataBinding("nulo", array("Si" => "Si", "No" => "No"), "", "", "array");

		$pdocrud->fieldTypes("indice", "select");
		$pdocrud->fieldDataBinding("indice", array("Primario" => " Primario"), "", "", "array");
		$pdocrud->fieldRenameLable("nombre", "Nombre campo");
		$pdocrud->fieldRenameLable("nulo", "Campo con Valor Vacio");
		$pdocrud->formFieldValue("query", "SELECT id as ID, name as Name FROM demo");
		$pdocrud->formFieldValue("columns_table", "id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255)");
		$pdocrud->fieldAttributes("query", array("placeholder"=> "Ejemplo: SELECT id as ID, name as Name FROM demo", "style"=> "min-height: 200px; max-height: 200px;"));
		$pdocrud->fieldAttributes("columns_table", array("placeholder"=> "Ejemplo: id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(255)", "style"=> "min-height: 200px; max-height: 200px;"));
		$pdocrud->fieldGroups("Name2",array("name_view","add_menu"));
		$pdocrud->tableHeading("Generador de Módulos");
		$pdocrud->fieldDisplayOrder(array("crud_type","tabla","id_tabla", "query", "controller_name", "columns_table", "name_view", "add_menu", "nombre", "tipo_de_campo", "nulo", "indice", "autoincrementable", "tipo", "longitud"));
		$pdocrud->setSearchCols(array("tabla", "id_tabla", "crud_type", "query", "controller_name", "columns_table", "name_view", "add_menu", "template_fields"));
		$pdocrud->formFields(array("tabla", "id_tabla", "crud_type", "query", "controller_name", "columns_table", "name_view", "add_menu", "template_fields", "nombre", "tipo_de_campo", "nulo", "indice", "autoincrementable", "tipo", "longitud"));
		$pdocrud->crudRemoveCol(array("id_modulos", "id_menu", "query", "columns_table"));
		$pdocrud->colRename("tabla", "Nombre Tabla Base de Datos");
		$pdocrud->colRename("id_tabla", "ID Tabla Base de Datos");
		$pdocrud->colRename("crud_type", "Tipo de Crud");
		$pdocrud->joinTable("campos", "campos.id_modulos = modulos.id_modulos", "LEFT JOIN");
		$pdocrud->colRename("template_fields", "Usar Plantilla Formulario HTML");
		$pdocrud->fieldConditionalLogic("crud_type", "CRUD", "=", "query", "hide");
		$pdocrud->fieldConditionalLogic("crud_type", "CRUD", "!=", "query", "show");

		$pdocrud->fieldConditionalLogic("crud_type", "CRUD", "=", "id_tabla", "hide");
		$pdocrud->fieldConditionalLogic("crud_type", "CRUD", "!=", "id_tabla", "show");
		
		$pdocrud->colRename("query", "Consulta BD");
		$pdocrud->colRename("controller_name", "Nombre del Controlador");
		$pdocrud->colRename("columns_table", "Columnas de la Tabla");
		$pdocrud->colRename("name_view", "Nombre de la Vista");
		$pdocrud->colRename("add_menu", "Agregar Al Menú Principal");
		$pdocrud->fieldDesc("nombre_funcion_antes_de_insertar", "Campo opcional");

		$pdocrud->fieldTypes("crud_type", "select");
		$pdocrud->fieldDataBinding("crud_type", array("CRUD"=> "CRUD (Mantenedor a base de una tabla)", "SQL"=> "SQL (Mantenedor a base de una consulta)"), "", "","array");

		$pdocrud->fieldTypes("add_menu", "select");
		$pdocrud->fieldDataBinding("add_menu", array("Si"=> "Si"), "", "","array");

		$pdocrud->fieldTypes("template_fields", "select");
		$pdocrud->fieldDataBinding("template_fields", array("Si"=> "Si", "No"=> "No"), "", "","array");

		$pdocrud->buttonHide("submitBtnSaveBack");
		$pdocrud->setSettings("viewbtn", false);
		$pdocrud->setSettings("refresh", false);
		$pdocrud->setSettings("printBtn", false);
		$pdocrud->setSettings("editbtn", false);
		$pdocrud->setSettings("pdfBtn", false);
		$pdocrud->setSettings("csvBtn", false);
		$pdocrud->setSettings("excelBtn", false);
		$pdocrud->addCallback("before_insert", "insertar_modulos", array($id_sesion_usuario));
		$pdocrud->addCallback("before_delete", "eliminar_modulos");

		$action = $_ENV["BASE_URL"] . "{controller_name}/index";
		$text = '<i class="fa fa-table" aria-hidden="true"></i>';
		$attr = array("title" => "Ver módulo", "target"=> "_blank");
		$pdocrud->enqueueBtnActions("url btn btn-default btn-sm ", $action, "url", $text, "", $attr);

		$render = $pdocrud->dbTable("modulos")->render();

		View::render(
			"modulos",
			['render' => $render]
		);
	}

	public function actualizar_orden_menu(){

		$request = new Request();

		if ($request->getMethod() === 'POST') {

			$order = $request->post('order');
			if (isset($order) && is_array($order)) {
				$newOrder = $order;

				foreach ($newOrder as $position => $itemId) {
					$position++;
					$pdocrud = DB::PDOCrud();
					$pdomodel = $pdocrud->getPDOModelObj();
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
					$pdocrud = DB::PDOCrud();
					$pdomodel = $pdocrud->getPDOModelObj();
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

			$pdocrud = DB::PDOcrud();
			$pdomodel = $pdocrud->getPDOModelObj();
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

			$pdocrud = DB::PDOcrud();
			$pdomodel = $pdocrud->getPDOModelObj();
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
		$pdocrud = DB::PDOCrud();

		$pdomodel = $pdocrud->getPDOModelObj();
		$datamenu = $pdomodel->DBQuery("SELECT MAX(orden_menu) as orden FROM menu");
		$newOrdenMenu = $datamenu[0]["orden"] + 1;

		$datasubmenu = $pdomodel->DBQuery("SELECT MAX(orden_submenu) as orden_submenu FROM submenu");
		$newOrdenSubMenu = $datasubmenu[0]["orden_submenu"] + 1;

		$action = "javascript:;";
		$text = '<i class="fas fa-arrows-alt-v"></i>';
		$attr = array("title"=>"Arrastra para Reordenar Fila");
		$pdocrud->enqueueBtnActions("url btn btn-primary btn-sm reordenar_fila", $action, "url",$text,"orden_menu", $attr);
		$pdocrud->multiTableRelationDisplay("tab", "Menu");
		$pdocrud->setSearchCols(array("nombre_menu","url_menu", "icono_menu", "submenu", "orden_menu"));
		$pdocrud->fieldHideLable("orden_menu");
		$pdocrud->fieldDataAttr("orden_menu", array("style"=>"display:none"));
		$pdocrud->fieldHideLable("submenu");
		$pdocrud->fieldDataAttr("submenu", array("style"=>"display:none"));
		$pdocrud->formFieldValue("orden_menu", $newOrdenMenu);
		$pdocrud->formFieldValue("submenu", "No");
		$pdocrud->addPlugin("select2");
		$pdocrud->dbOrderBy("orden_menu asc");
		$pdocrud->addCallback("format_table_data", "formatTableMenu");
		$pdocrud->addCallback("after_insert", "agregar_menu");
		$pdocrud->addCallback("before_delete", "eliminar_menu");
		$pdocrud->fieldTypes("icono_menu", "select");
		$pdocrud->fieldCssClass("icono_menu", array("icono_menu"));
		$pdocrud->fieldCssClass("submenu", array("submenu"));
		$pdocrud->fieldGroups("Name", array("nombre_menu", "url_menu"));
		$pdocrud->crudRemoveCol(array("id_menu"));
		$pdocrud->setSettings("printBtn", false);
		$pdocrud->setSettings("pdfBtn", false);
		$pdocrud->setSettings("csvBtn", false);
		$pdocrud->setSettings("excelBtn", false);
		$pdocrud->setSettings("viewbtn", false);
		$pdocrud->setSettings("refresh", false);
		$pdocrud->buttonHide("submitBtnSaveBack");

		$submenu = DB::PDOCrud(true);
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
		$submenu->setSettings("csvBtn", false);
		$submenu->setSettings("excelBtn", false);
		$submenu->setSettings("viewbtn", false);
		$submenu->fieldTypes("icono_submenu", "select");
		$submenu->fieldCssClass("icono_submenu", array("icono_submenu"));
		$submenu->buttonHide("submitBtnSaveBack");
		$pdocrud->multiTableRelation("id_menu", "id_menu", $submenu);
		$select2 = $pdocrud->loadPluginJsCode("select2",".icono_menu, .icono_submenu");
		$render = $pdocrud->dbTable("menu")->render();

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
		$pdocrud = DB::PDOCrud();
		$pdocrud->fieldHideLable("id");
		$pdocrud->fieldCssClass("id", array("d-none"));
		$pdocrud->setSettings("hideAutoIncrement", false);
		$pdocrud->setSettings("required", false);
		$pdocrud->addCallback("before_update", "editar_perfil");
		$pdocrud->fieldGroups("Name",array("nombre","email"));
		$pdocrud->fieldGroups("Name2",array("usuario","password"));
		$pdocrud->fieldGroups("Name3",array("idrol","avatar"));
		$pdocrud->fieldTypes("avatar", "FILE_NEW");
		$pdocrud->fieldTypes("password", "password");
		$pdocrud->fieldRenameLable("nombre", "Nombre Completo");
		$pdocrud->fieldRenameLable("email", "Correo electrónico");
		$pdocrud->fieldRenameLable("password", "Clave de acceso");
		$pdocrud->fieldRenameLable("idrol", "Tipo Usuario");
		$pdocrud->relatedData('idrol','rol','idrol','nombre_rol');
		$pdocrud->formFields(array("id","nombre","email","password","usuario", "idrol", "avatar"));
        $pdocrud->formStaticFields("token_form", "html", "<input type='hidden' name='auth_token' value='" . $token . "' />");
		$pdocrud->fieldDataAttr("password", array("value"=> "", "placeholder" => "*****", "autocomplete" => "new-password"));
		$pdocrud->setPK("id");
		$render = $pdocrud->dbTable("usuario")->render("editform", array("id" => $id));

		View::render(
			"perfil",
			['render' => $render]
		);
	}

	public function dashboard_custom(){
		$pdocrud = DB::PDOCrud();
		$pdocrud->addPlugin("select2");
		$pdocrud->formStaticFields("div", "html", "<div class='mostrar_click'></div>");
		$pdocrud->fieldTypes("cantidad_columnas", "select");
		$pdocrud->fieldDataBinding("cantidad_columnas", array(
			"1" => 1,
			"2" => 2,
			"3" => 3,
			"4" => 4,
			"5" => 5,
			"6" => 6
		), "", "","array");
		$pdocrud->fieldNotMandatory("titulo");
		$pdocrud->fieldNotMandatory("icono");
		$pdocrud->fieldNotMandatory("url");
		$pdocrud->setLangData("title_left_join", "Opciones configuración Panel");
		$pdocrud->setLangData("add_row", "Agregar");
		$pdocrud->fieldTypes("icono", "select");
		$pdocrud->fieldCssClass("icono", array("icono"));
		$pdocrud->fieldCssClass("titulo", array("titulo"));
		$pdocrud->fieldCssClass("cantidad_columnas", array("cantidad_columnas"));
		$pdocrud->formFields(array("cantidad_columnas","titulo","icono", "url"));
		$pdocrud->setSettings("template", "dashboard_custom");
		$pdocrud->colRename("id_creador_de_panel", "ID");
		$pdocrud->setSettings("printBtn", false);
		$pdocrud->setSettings("pdfBtn", false);
		$pdocrud->setSettings("csvBtn", false);
		$pdocrud->setSettings("excelBtn", false);
		$pdocrud->setSettings("refresh", false);
		$pdocrud->buttonHide("submitBtnSaveBack");
		$pdocrud->joinTable("custom_panel", "custom_panel.id_creador_de_panel = creador_de_panel.id_creador_de_panel", "LEFT JOIN");
		$render = $pdocrud->dbTable("creador_de_panel")->render();
		$select2 = $pdocrud->loadPluginJsCode("select2",".icono");
		View::render('dashboard_custom', [
			'render' => $render,
			'select2' => $select2
		]);
	}
}
