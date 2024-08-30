<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\DB;
        use App\core\Request;
        use App\core\View;
        use App\core\Redirect;

        class PruebaController
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
                $columnDB = $pdomodel->columnNames('prueba');
                $id = strtoupper($columnDB[0]);

                $tabla = $pdocrud->getLangData('prueba');
                $pk = $pdocrud->getLangData($id);
                $columnVal = $pdocrud->getLangData($pk);

                $pdocrud->enqueueBtnTopActions('Report',  "<i class='fa fa-plus'></i> Agregar", $_ENV['BASE_URL'].'Prueba/agregar', array(), 'btn-report');

                $action = $_ENV['BASE_URL'].'Prueba/editar/id/{ID}';
                $text = '<i class="fa fa-edit"></i>';
                $attr = array('title'=> 'Editar');
                $pdocrud->enqueueBtnActions('url', $action, 'url', $text, $pk, $attr, 'btn-warning', array(array()));

                $pdocrud->setSettings('encryption', false);
                $pdocrud->setSettings('pagination', true);
                $pdocrud->setSettings('searchbox', true);
                $pdocrud->setSettings('deleteMultipleBtn', true);
                $pdocrud->setSettings('checkboxCol', true);
                $pdocrud->setSettings('recordsPerPageDropdown', true);
                $pdocrud->setSettings('totalRecordsInfo', true);
                $pdocrud->setSettings('addbtn', false);
                $pdocrud->setSettings('editbtn', false);
                $pdocrud->setSettings('delbtn', true);
                $pdocrud->setSettings('actionbtn', true);
                $pdocrud->setSettings('refresh', false);
                $pdocrud->setSettings('numberCol', true);
                $pdocrud->setSettings('printBtn', true);
                $pdocrud->setSettings('pdfBtn', true);
                $pdocrud->setSettings('csvBtn', true);
                $pdocrud->setSettings('excelBtn', true);
                $pdocrud->setSettings('clonebtn', false);
                $pdocrud->setSettings('template', 'template_prueba');
                $pdocrud->setLangData('no_data', 'Sin Resultados');
            
                $pdocrud->setLangData('tabla', 'prueba')
                    ->setLangData('pk', $pk)
                    ->setLangData('columnVal', $columnVal);
                $pdocrud->tableHeading('prueba');
                $pdocrud->addCallback('before_delete_selected', 'eliminacion_masiva_tabla');
                $pdocrud->addCallback('before_sql_data', 'buscador_tabla', array($columnDB));
                $pdocrud->addCallback('before_delete', 'eliminar_tabla');

                $pdocrud->setSettings('viewbtn', false);
                $pdocrud->addCallback('format_sql_col', 'format_sql_col_tabla', array($columnDB));
                $render = $pdocrud->setQuery('SELECT id as ID, name as Name FROM prueba')->render('SQL');

                View::render(
                    'prueba', 
                    [
                        'render' => $render
                    ]
                );
            }

            public function agregar(){
                $pdocrud = DB::PDOCrud();
                $pdocrud->buttonHide('submitBtn');
                $pdocrud->buttonHide('cancel');
                $pdocrud->setSettings('template', 'template_prueba');
                $pdocrud->formStaticFields('botones', 'html', '
                    <div class="col-md-12 text-center">
                        <input type="submit" class="btn btn-primary pdocrud-form-control pdocrud-submit" data-action="insert" value="Guardar"> 
                        <a href="'.$_ENV['BASE_URL'].'Prueba/index" class="btn btn-danger">Regresar</a>
                    </div>
                ');
                $render = $pdocrud->dbTable('prueba')->render('insertform');
                View::render(
                    'agregar_prueba',
                    [
                        'render' => $render
                    ]
                );
            }

            public function editar(){
                $request = new Request();
                $id = $request->get('id');

                $pdocrud = DB::PDOCrud();

                $pdomodel = $pdocrud->getPDOModelObj();
                $columnDB = $pdomodel->columnNames('prueba');
                $id_tabla = strtoupper($columnDB[0]);

                $pdocrud->setPK($id_tabla);
                $pdocrud->setSettings('template', 'template_prueba');
                $pdocrud->buttonHide('submitBtn');
                $pdocrud->buttonHide('cancel');
                $pdocrud->formStaticFields('botones', 'html', '
                    <div class="col-md-12 text-center">
                        <input type="submit" class="btn btn-primary pdocrud-form-control pdocrud-submit" data-action="insert" value="Guardar"> 
                        <a href="'.$_ENV['BASE_URL'].'Prueba/index" class="btn btn-danger">Regresar</a>
                    </div>
                ');
                $render = $pdocrud->dbTable('prueba')->render('editform', array('id' => $id));

                View::render(
                    'editar_prueba',
                    [
                        'render' => $render
                    ]
                );
            }
        }