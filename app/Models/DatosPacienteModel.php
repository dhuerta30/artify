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
		$Queryfy = DB::Queryfy();
		$Queryfy->insert($this->tabla, $data);
		return $Queryfy;
	}

	public function PacientePorRut($rut){
		$Queryfy = DB::Queryfy();
		$Queryfy->where("rut", $rut);
		$data = $Queryfy->select($this->tabla);
		return $data;
	}

	public function PacientePorId($id){
		$Queryfy = DB::Queryfy();
		$Queryfy->where("id_datos_paciente", $id);
		$data = $Queryfy->select($this->tabla);
		return $data;
	}
}
