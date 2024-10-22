<?php

namespace App\Controllers;

use App\core\DB;
use App\core\RequestApi;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;

class TokenController
{
    private $secretKey;

    public function __construct()
    {
        $this->secretKey = $_ENV['CSRF_SECRET'];
    }

    public function generarToken()
    {
        $request = new RequestApi();

        if ($request->getMethod() === 'POST') {
            $email = $request->post('email');
            $password = $request->post('password');

            $usuario = new UserModel();
            $data = $usuario->select_userBy_email($email);

            // Validar si se encontró algún usuario con ese email
            if (!empty($data)) {
                // Validar la contraseña
                if (password_verify($password, $data[0]["password"])) {
                    $tokenData = [
                        'id' => $data[0]["id"],
                        'email' => $data[0]["email"],
                        'timestamp' => time(),
                        'exp' => time() + (60 * 60) // Expira en 1 hora
                    ];

                    $token = JWT::encode($tokenData, $this->secretKey, 'HS256');

                    // Actualizar token en la base de datos
                    $usuario->update_userBy_email($data[0]["email"], array("token_api" => $token));
                    echo json_encode(['token' => $token]);
                } else {
                    echo json_encode(['error' => 'La contraseña no es válida']);
                }
            } else {
                echo json_encode(['error' => 'Usuario no encontrado']);
            }
        }
    }

    public function validarToken($jwt)
    {
        if (!empty($jwt)) {
            try {
                $decoded = JWT::decode($jwt, new Key($this->secretKey, 'HS256'));
                return $decoded; // Retorna los datos decodificados si es válido
            } catch (\Firebase\JWT\ExpiredException $e) {
                return false; // El token ha expirado
            } catch (Exception $e) {
                return false; // Token inválido
            }
        }
        return false; // Token vacío
    }

    public function listar()
    {
        $request = new RequestApi();

        if ($request->getMethod() === 'GET') {
            // Obtener el token del encabezado Authorization
            $jwt = "";
            if (isset($_SERVER["HTTP_AUTHORIZATION"])) {
                $authorizationHeader = $_SERVER["HTTP_AUTHORIZATION"];
                $bearerPrefix = 'Bearer ';
                if (strpos($authorizationHeader, $bearerPrefix) !== false) {
                    $jwt = trim(substr($authorizationHeader, strlen($bearerPrefix)));
                }
            }

            // Validar el token
            $usuario = new UserModel();
            if ($this->validarToken($jwt)) {
                $data = $usuario->select_userBy_token($jwt); // Asegúrate de que tu método acepte el token

                if ($data) {
                    echo json_encode(['data' => $data]);
                } else {
                    echo json_encode(['error' => 'No se encontraron datos para el token proporcionado']);
                }
            } else {
                echo json_encode(['error' => 'Token inválido, no tiene permisos para acceder a esta Api']);
            }
        }
    }
}
