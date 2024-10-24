<?php 

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\Redirect;
use App\core\View;
use App\core\DB;
use App\Models\UserModel;

class LoginController {

    public function __construct()
	{
		SessionManager::startSession();

		if (isset($_SESSION["data"]["usuario"]["usuario"])) {
			$artify = DB::ArtifyCrud();
			$queryfy = $artify->getQueryfyObj();
			$queryfy->where("usuario", $_SESSION["data"]["usuario"]["usuario"]);
			$sesion_users = $queryfy->select("usuario");
			$_SESSION["usuario"] = $sesion_users;
		}

		$Sesusuario = SessionManager::get('usuario');
		if (isset($Sesusuario)) {
			Redirect::to("home/modulos");
		}
	}

    public function index(){
        $artify = DB::ArtifyCrud();
		$artify->fieldDisplayOrder(array("usuario", "password"));
		$artify->fieldRenameLable("email", "Correo");
		$artify->fieldRenameLable("password", "Contraseña");
        $artify->fieldAddOnInfo("usuario", "before", '<div class="input-group-append"><span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span></div>');
        $artify->fieldAddOnInfo("password", "before", '<div class="input-group-append"><span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span></div>');
		$artify->formStaticFields("personalinfo", "html", "
		<label for='license_key'>Código de Licencia:</label>
		<div class='input-group'>
			<div class='input-group-append'><span class='input-group-text' id='basic-addon1'><i class='fas fa-key'></i></span></div>
    		<input type='text' class='form-control artify-form-control artify-text' name='license_key' placeholder='Ingrese su Código de Licencia' required>
		</div>
		");
		$artify->addCallback("before_select", "beforeloginCallback");
		$artify->formFields(array("usuario", "password"));
		$artify->setLangData("login", "Ingresar");
		$login = $artify->dbTable("usuario")->render("selectform");

        View::render('login', ['login' => $login]);
    }

	public function users()
	{
		$users = new UserModel();
		$result = $users->select_users();

		echo json_encode($result);
	}

    public function salir()
	{
		SessionManager::startSession();
		SessionManager::destroy();
		Redirect::to("Login/index");
	}

    public function reset()
	{
		$artify = DB::ArtifyCrud();
		$artify->fieldRenameLable("email", "Correo");
		$artify->fieldAddOnInfo("email", "before", '<div class="input-group-append"><span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope-o"></i></span></div>');
		$artify->addCallback("before_select", "resetloginCallback");
		$artify->formFields(array("email"));
		$artify->setLangData("login", "Recuperar");
		$reset = $artify->dbTable("usuario")->render("selectform");

		View::render('reset', ['reset' => $reset]);
	}
}