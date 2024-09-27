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
use GuzzleHttp\Exception\ServerException;

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
            $response = $client->put("http://localhost/". $_ENV["BASE_URL"]."/api/creador_de_panel/5", [
                'body' => $data,
            ]);

            $result = $response->getBody()->getContents();
            print_r($result);

        } catch (ServerException $e) {
            if ($e->getResponse()->getStatusCode() == 500) {
                echo $e->getResponse()->getBody()->getContents() . PHP_EOL;
            }
        }
    }

    public function eliminar_datos(){
        try {

            $data = array("data" => array("id_creador_de_panel" => 3));
            $data = json_encode($data);
            
            $client = new Client();
            $response = $client->delete("http://localhost/". $_ENV["BASE_URL"]."/api/creador_de_panel/", [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => $data
            ]);

            $result = $response->getBody()->getContents();
            print_r($result);

        } catch (ServerException $e) {
            if ($e->getResponse()->getStatusCode() == 500) {
                echo $e->getResponse()->getBody()->getContents() . PHP_EOL;
            }
        }
    }

    public function autenticar_con_token(){
        try {
            $client = new Client();
            $response = $client->get("http://localhost/". $_ENV["BASE_URL"]."/api/usuario/", [
                'headers' => [
                    'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE3Mjc0NjAwMTEsImlzcyI6ImxvY2FsaG9zdCIsImV4cCI6MTcyNzQ2MDA3MSwidXNlcklkIjoiMSJ9.PmAue48gybbNw2IO9Jg3yfTd6IYNkVV2c5MB2zkjSsU',
                    'Content-Type' => 'application/json',
                ],
            ]);
            $result = $response->getBody()->getContents();
            print_r($result);

        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                echo $e->getResponse()->getBody()->getContents() . PHP_EOL;
            }
        }
    }
}