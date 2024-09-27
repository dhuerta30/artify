<?php

namespace App\Controllers;

use App\core\SessionManager;
use App\core\Token;
use App\core\Request;
use App\core\View;
use App\core\Redirect;
use App\core\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class DocumentacionController
{
    public function index()
    {
        View::render("documentacion");
    }

    public function ejemplo(){
        try {
            $client = new Client();
            $response = $client->get("http://localhost/". $_ENV["BASE_URL"].'/api/usuario/');
            $result = $response->getBody()->getContents();
            print_r($result);

        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                echo $e->getResponse()->getBody()->getContents() . PHP_EOL;
            }
        }
    }

    public function generarToken(){
        try {
            $data = array("data" => array("usuario" => "admin", "password" => "123"));
            $data = json_encode($data);
        
            $client = new Client();
            $response = $client->post("http://localhost/". $_ENV["BASE_URL"]."/api/usuario/?op=jwtauth", [
                'body' => $data,
            ]);

            $result = $response->getBody()->getContents();
            print_r($result);

        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 404) {
                echo $e->getResponse()->getBody()->getContents() . PHP_EOL;
            }
        }
    }

    public function insertar_datos(){
        try {
            $data = array("data" => array("cantidad_columnas" => 3));
            $data = json_encode($data);

            $client = new Client();
            $response = $client->post("http://localhost/". $_ENV["BASE_URL"]."/api/creador_de_panel/", [
                'body' => $data,
            ]);

            $result = $response->getBody()->getContents();
            print_r($result);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 404) {
                echo $e->getResponse()->getBody()->getContents() . PHP_EOL;
            }
        }
    }

    public function actualizar_datos(){
        try {
            $data = array("data" => array("cantidad_columnas" => 9));
            $data = json_encode($data);

            $client = new Client();
            $response = $client->put("http://localhost/". $_ENV["BASE_URL"]."/api/creador_de_panel/3", [
                'body' => $data,
            ]);

            $result = $response->getBody()->getContents();
            print_r($result);

        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 500) {
                echo $e->getResponse()->getBody()->getContents() . PHP_EOL;
            }
        }
    }
}