<?php

namespace App\Models;

use App\core\DB;

class ProcedimientoModel
{
	private $table;

	public function __construct()
	{
		$this->table = "procedimiento";
	}

    public function insertar_procedimiento($data = array())
    {
        $Queryfy = DB::Queryfy();
        $Queryfy->insert($this->table, $data);
        return $Queryfy;
    }
}