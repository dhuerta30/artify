<?php

namespace App\core;

class RequestApi
{
    private $data = [];
    private $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        // Almacena los datos de $_POST si la solicitud es un POST
        if ($this->method === 'POST') {
            $this->data = $_POST;
            $this->data = $this->getContentFromJson();
        } else {
            $this->data = $this->getContentFromJson();
        }
    }

    public function post($key)
    {
        // Solo permite obtener datos de $_POST si la solicitud es un POST
        return ($this->method === 'POST' && isset($this->data[$key])) ? $this->data[$key] : null;
    }

    public function get($key)
    {
        // Permite obtener datos de los segmentos de la URL
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function all()
    {
        return $this->data;
    }

    public function getContentFromJson()
    {
        header('Content-Type: application/json');
        $json = file_get_contents('php://input');
        return json_decode($json, true);
    }
}
