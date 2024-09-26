<?php

namespace App\Models;

use App\core\DB;

class PageModel
{
    public function PageById($id)
    {
        $Queryfy = DB::Queryfy();
        $Queryfy->where("modulos.tabla", $id);
        $Queryfy->joinTables("campos", "modulos.id_modulos = campos.id_modulos", "LEFT JOIN");
        $data = $Queryfy->select("modulos");

        $arr_campos = [];

        foreach ($data as $campo) {
            $arr_campos[] = [
                'id_modulos' => $campo['id_modulos'],
                'nombre' => $campo['nombre'],
                'nulo' => $campo['nulo'],
                'visibilidad_formulario' => $campo['visibilidad_formulario'],
                'visibilidad_busqueda' => $campo['visibilidad_busqueda'],
                'visibilidad_de_filtro_busqueda' => $campo['visibilidad_de_filtro_busqueda'],
                'visibilidad_grilla' => $campo['visibilidad_grilla'],
                'indice' => $campo['indice'],
                'autoincrementable' => $campo['autoincrementable'],
                'tipo' => $campo['tipo'],
                'longitud' => $campo['longitud'],
                'tipo_de_campo' => $campo['tipo_de_campo'],
            ];
        }

        $tabla = $data[0]['tabla'];

        $arr_result = [
            'modulos' => [
                'tabla' =>  $tabla,
                'activar_filtro_de_busqueda' => $data[0]['activar_filtro_de_busqueda'],
                'botones_de_accion' => $data[0]['botones_de_accion'],
                'activar_buscador' => $data[0]['activar_buscador'],
                'botones_de_exportacion' => $data[0]['botones_de_exportacion'],
                'activar_eliminacion_multiple' => $data[0]['activar_eliminacion_multiple'],
                'activar_modo_popup' => $data[0]['activar_modo_popup'],
                'seleccionar_skin' => $data[0]['seleccionar_skin'],
                'seleccionar_template' => $data[0]['seleccionar_template'],
                'nombre_funcion_antes_de_insertar' => $data[0]['nombre_funcion_antes_de_insertar'],
                'nombre_funcion_despues_de_insertar' => $data[0]['nombre_funcion_despues_de_insertar'],
                'nombre_funcion_antes_de_actualizar' => $data[0]['nombre_funcion_antes_de_actualizar'],
                'nombre_funcion_despues_de_actualizar' => $data[0]['nombre_funcion_despues_de_actualizar'],
                'nombre_funcion_antes_de_eliminar' => $data[0]['nombre_funcion_antes_de_eliminar'],
                'nombre_funcion_despues_de_eliminar' => $data[0]['nombre_funcion_despues_de_eliminar'],
                'nombre_funcion_antes_de_actualizar_gatillo' => $data[0]['nombre_funcion_antes_de_actualizar_gatillo'],
                'nombre_funcion_despues_de_actualizar_gatillo' => $data[0]['nombre_funcion_despues_de_actualizar_gatillo'],
                'script_js' => $data[0]['script_js']
            ],
            'campos' => $arr_campos,
        ];

        return $arr_result;
    }
}
