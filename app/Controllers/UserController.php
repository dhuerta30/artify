<?php

namespace App\Controllers;

use App\core\DB;
use App\core\View;
use App\core\Request;

class UserController
{
    public function index()
    {
        $request = new Request();

        // Obtener un parámetro de la URL
        $parametro = $request->get('id');

        $artify = DB::ArtifyCrud();
        if(isset($parametro)){
            $artify->where("id", $parametro, "=");
        }
        $render = $artify->dbTable("usuario")->render();

        View::render('index', ['render' => $render]);
    }

    public function edit()
    {
        View::render('product');
        
    }
}
