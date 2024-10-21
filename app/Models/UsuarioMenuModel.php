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

    public function Obtener_menus()
    {
        $Queryfy = DB::Queryfy();
		$query = "SELECT DISTINCT menu.id_menu, menu.nombre_menu, menu.url_menu, menu.icono_menu, menu.orden_menu, menu.submenu, usuario_menu.visibilidad_menu
				FROM menu
				INNER JOIN ".$this->table." ON menu.id_menu = {$this->table}.id_menu
				INNER JOIN usuario ON {$this->table}.id_usuario = usuario.id
                WHERE menu.area_protegida_menu != 'Si'
                ORDER BY orden_menu asc";

		$data = $Queryfy->DBQuery($query);
		return $data;
    }

    public function Obtener_menu_por_id_usuario($id)
    {
        $Queryfy = DB::Queryfy();
		$query = "SELECT *
				FROM menu
				INNER JOIN ".$this->table." ON menu.id_menu = {$this->table}.id_menu
				INNER JOIN usuario ON {$this->table}.id_usuario = usuario.id
				WHERE {$this->table}.id_usuario = :userId AND menu.area_protegida_menu != 'No' 
                ORDER BY orden_menu asc";

		$data = $Queryfy->DBQuery($query, [':userId' => $id]);
		return $data;
    }
}