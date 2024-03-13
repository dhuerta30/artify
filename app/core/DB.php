<?php

namespace App\core;
use PDOCrud;

class DB {
    public static function PDOCrud($multi = false, $template = "", $skin = "", $settings = array())
    {
        $settings["script_url"] = $_ENV['URL_PDOCRUD'];
        $settings["uploadURL"] = $_ENV['UPLOAD_URL'];
        $settings["downloadURL"] = $_ENV['DOWNLOAD_URL'];
        $settings["hostname"] = $_ENV['DB_HOST'];
        $settings["database"] = $_ENV['DB_NAME'];
        $settings["username"] = $_ENV['DB_USER'];
        $settings["password"] = $_ENV['DB_PASS'];
        $settings["dbtype"] = $_ENV['DB_TYPE'];
        $settings["characterset"] = $_ENV["CHARACTER_SET"];

        $pdocrud = new PDOCrud($multi, $template, $skin, $settings);
        return $pdocrud;
    }

	public static function evalBool($value)
	{
		return (strcasecmp($value, 'true') ? false : true);
	}

    public static function PDOModel()
    {
        $pdocrud = DB::PDOCrud();
        $pdomodel = $pdocrud->getPDOMOdelObj();
        $pdomodel->fetchType = "OBJ";
        return $pdomodel;
    }

    public static function PHPMail($hacia, $desde, $asunto, $mensaje){
		$pdocrud = DB::PDOCrud();
		// Parámetros para el correo electrónico
		$to = array(
			$hacia => 'Nombre Destinatario 1'
		);
		$subject = $asunto;
		$message = $mensaje;
		$from = array($desde => 'Hospital');
		$altMessage = 'Este es el mensaje alternativo';
		$cc = array();
		$bcc = array();
		$attachments = array();
		$mode = 'SMTP';
		$smtp = array(
			'host' => $_ENV['MAIL_HOST'],
			'port' => $_ENV['MAIL_PORT'],
			'SMTPAuth' => DB::evalBool($_ENV['SMTP_AUTH']),
			'username' => $_ENV['MAIL_USERNAME'],
			'password' => $_ENV['MAIL_PASSWORD'],
			'SMTPSecure' => $_ENV['SMTP_SECURE'],
			'SMTPKeepAlive' => DB::evalBool($_ENV['SMTP_KEEP_ALIVE'])
		);
		$isHTML = true;
		return $pdocrud->sendEmail($to, $subject, $message, $from, $altMessage, $cc, $bcc, $attachments, $mode, $smtp, $isHTML);
	}

	public static function performPagination($registros_por_pagina, $pagina_actual, $tabla, $id, $parametro)
    {
        $pdomodel = DB::PDOModel();

        $totalRegistros = $pdomodel->executeQuery("SELECT COUNT(*) as total FROM $tabla");
        $pagination = $pdomodel->simplepagination($pagina_actual, $totalRegistros[0]["total"], $registros_por_pagina, 'index.php', $parametro);
    
        $inicio = max(0, ($pagina_actual - 1) * $registros_por_pagina);
        $query = "SELECT * FROM $tabla LIMIT $inicio, $registros_por_pagina";
        $resultados = $pdomodel->executeQuery($query);
		
        return ['output' => $pagination, 'resultados' => $resultados];
    }
}