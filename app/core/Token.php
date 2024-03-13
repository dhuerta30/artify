<?php

namespace App\core;

class Token
{
    public static function generateFormToken($form)
    {
        $secret = $_ENV['CSRF_SECRET'];
        $sid = session_id();
        $token = password_hash($secret . $sid . $form, PASSWORD_DEFAULT);
        return $token;
    }

    public static function verifyFormToken($form, $token)
    {
        $secret = $_ENV['CSRF_SECRET'];
        $sid = session_id();
        if (password_verify($secret . $sid . $form, $token)) {
            return $token;
        }
    }
}
