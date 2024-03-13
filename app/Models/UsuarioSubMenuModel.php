<?php

        namespace App\Models;

        use App\core\DB;
        
        class UsuarioSubMenuModel
        {
            private $table;

            public function __construct()
            {
                $this->table = 'usuario_submenu';
            }

            public function Obtener_submenu_por_id_menu($id_menu, $id_usuario)
            {
                $pdomodel = DB::PDOModel();
                $query = "SELECT * FROM {$this->table} 
                    INNER JOIN submenu ON submenu.id_submenu = {$this->table}.id_submenu 
                    WHERE {$this->table}.id_menu = {$id_menu} AND id_usuario = {$id_usuario}";
                $data = $pdomodel->executeQuery($query);
                return $data;
            }

        }