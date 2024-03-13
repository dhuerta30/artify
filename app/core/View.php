<?php

namespace App\core;

class View
{
    public static function render($viewName, array $data = [])
    {
        $viewFile = __DIR__ . '/../Views/' . $viewName . '.php';

        if (file_exists($viewFile)) {
            // Extraer variables con asignación por lista (list()) en lugar de extract()
            foreach ($data as $key => $value) {
                $$key = $value;
            }

            ob_start();
            include $viewFile;
            $content = ob_get_clean();
            echo $content;
        } else {
            echo 'Vista no encontrada';
        }
    }
}

?>