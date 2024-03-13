<?php

namespace App\Models;

use App\core\DB;

class UsuarioMenuModel
{
	protected $table;
    protected $id;

    public function __construct()
    {
        $this->table = 'usuario_menu';
        $this->id = 'id_usuario_menu';
    }

    public function Obtener_menu_por_id_usuario($id)
    {
        $pdomodel = DB::PDOModel();
		$query = "SELECT *
				FROM menu
				INNER JOIN ".$this->table." ON menu.id_menu = {$this->table}.id_menu
				INNER JOIN usuario ON {$this->table}.id_usuario = usuario.id
				WHERE {$this->table}.id_usuario = :userId ORDER BY orden_menu asc";

		$data = $pdomodel->executeQuery($query, [':userId' => $id]);
		return $data;
    }
}