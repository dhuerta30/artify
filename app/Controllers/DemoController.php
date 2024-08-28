<?php

            namespace App\Controllers;

            use App\core\SessionManager;
            use App\core\Token;
            use App\core\DB;
            use App\core\View;
            use App\core\Redirect;

            class DemoController
            {
                public $token;

                public function __construct()
                {
                    SessionManager::startSession();
                    $Sesusuario = SessionManager::get('usuario');
                    if (!isset($Sesusuario)) {
                        Redirect::to('login/index');
                    }
                    $this->token = Token::generateFormToken('send_message');
                }

                public function index()
                {
                    $pdocrud = DB::PDOCrud();
                    $tabla = $pdocrud->getLangData('demo');
                    //$pk = $pdocrud->getLangData();
                    //$columnVal = $pdocrud->getLangData();

                    $pdocrud->setSettings('encryption', false);
                    //$pdocrud->setSettings('template', 'demo');
                    $pdocrud->setLangData('no_data', 'Sin Resultados');
                
                    $pdocrud->setLangData('tabla', 'demo')
                        ->setLangData('pk', '')
                        ->setLangData('columnVal', '');
                    $pdocrud->tableHeading('demo');
                    $pdocrud->addCallback('before_delete_selected', 'eliminacion_masiva_tabla');

                    $pdomodel = $pdocrud->getPDOModelObj();
                    $columnDB = $pdomodel->columnNames('demo');

                    $pdocrud->addCallback('format_sql_col', 'format_sql_col_tabla', [$columnDB]);
                    $render = $pdocrud->setQuery('SELECT id as ID, name as Name FROM demo')->render('SQL');

                    View::render(
                        'demo', 
                        [
                            'render' => $render
                        ]
                    );
                }
            }