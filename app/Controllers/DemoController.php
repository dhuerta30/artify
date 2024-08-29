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

                    $pdomodel = $pdocrud->getPDOModelObj();
                    $columnDB = $pdomodel->columnNames('demo');
                    $id = strtoupper($columnDB[0]);

                    $tabla = $pdocrud->getLangData('demo');
                    $pk = $pdocrud->getLangData($id);
                    $columnVal = $pdocrud->getLangData($id);

                    $pdocrud->enqueueBtnTopActions('Report',  "<i class='fa fa-plus'></i> Agregar", 'javascript:;', array(), 'btn-report');

                    $action = 'http://google.cl';
                    $text = '<i class="fa fa-edit"></i>';
                    $attr = array('title'=> 'Editar');
                    $pdocrud->enqueueBtnActions('url', $action, 'url', $text, $pk, $attr, 'btn-warning', array(array()));

                    $pdocrud->setSettings('encryption', false);
                    $pdocrud->setSettings('addbtn', false);
                    $pdocrud->setSettings('editbtn', false);
                    $pdocrud->setSettings('refresh', false);
                    $pdocrud->setSettings('numberCol', true);
                    $pdocrud->setLangData('no_data', 'Sin Resultados');
                
                    $pdocrud->setLangData('tabla', 'demo')
                        ->setLangData('pk', $pk)
                        ->setLangData('columnVal', $columnVal);
                    $pdocrud->tableHeading('demo');
                    $pdocrud->addCallback('before_delete_selected', 'eliminacion_masiva_tabla');
                    $pdocrud->addCallback('before_sql_data', 'buscador_tabla', array($columnDB));
                    $pdocrud->addCallback('before_delete', 'eliminar_tabla');

                    $pdocrud->setSettings('viewbtn', false);
                    $pdocrud->addCallback('format_sql_col', 'format_sql_col_tabla', array($columnDB));
                    $render = $pdocrud->setQuery('SELECT id as ID, name as Name FROM demo')->render('SQL');

                    View::render(
                        'demo', 
                        [
                            'render' => $render
                        ]
                    );
                }
            }