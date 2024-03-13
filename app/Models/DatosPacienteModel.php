<?php

namespace App\Models;

use App\core\DB;

class DatosPacienteModel
{
	private $tabla;

	function __construct() {
		
		$this->tabla = "datos_paciente";
	}

	public function insertar_datos_paciente($data = array())
	{
		$pdomodel = DB::PDOModel();
		$pdomodel->insert($this->tabla, $data);
		return $pdomodel;
	}

	public function PacientePorRut($rut){
		$pdomodel = DB::PDOModel();
		$pdomodel->where("rut", $rut);
		$data = $pdomodel->select($this->tabla);
		return $data;
	}

	public function PacientePorId($id){
		$pdomodel = DB::PDOModel();
		$pdomodel->where("id_datos_paciente", $id);
		$data = $pdomodel->select($this->tabla);
		return $data;
	}
}
