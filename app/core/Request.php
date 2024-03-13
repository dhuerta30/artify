<?php

namespace App\core;

class Request
{
    private $data = [];
    private $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];

        // Almacena los datos de $_POST si la solicitud es un POST
        if ($this->method === 'POST') {
            $this->data = $_POST;
        } else {
            // Almacena los datos de los segmentos de la URL en lugar de $_GET
            $this->data = $this->parseUrlSegments();
        }
    }

    // Método para obtener los segmentos de la URL y convertirlos en parámetros
    private function parseUrlSegments()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestUri = str_replace($_ENV["BASE_URL"], '', $requestUri);
        $segments = explode('/', $requestUri);

        // Filtrar segmentos vacíos
        $segments = array_filter($segments, function ($segment) {
            return !empty($segment);
        });

        // Crear un array asociativo de parámetros
        $params = [];
        $numSegments = count($segments);
        
        if($numSegments < 4){
            echo die("Error Proporcione los parámetros Faltantes en la url ya que es de Tipo GET");
        } else {
            for ($i = 0; $i < $numSegments; $i += 2) {
                $key = isset($segments[$i]) ? $segments[$i] : null;
                $value = isset($segments[$i + 1]) ? $segments[$i + 1] : null;

                // Asociar el nombre del parámetro al valor
                if ($key !== null && $value !== null) {
                    $params[$key] = $value;
                }
            }
        }

        return $params;
    }


    public function post($key)
    {
        // Solo permite obtener datos de $_POST si la solicitud es un POST
        return ($this->method === 'POST' && isset($this->data[$key])) ? $this->data[$key] : null;
    }

    public function get($key)
    {
        // Permite obtener datos de los segmentos de la URL
        return ($this->method === 'GET' && isset($this->data[$key])) ? $this->data[$key] : null;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function all()
    {
        return $this->data;
    }
}
