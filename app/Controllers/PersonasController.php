<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\DB;
        use App\core\View;
        use App\core\Redirect;

        class PersonasController
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
                $columnDB = $pdomodel->columnNames('personas');
                unset($columnDB[0]);

                
                foreach ($columnDB as $column) {
                    $columnName = ucfirst(str_replace('_', ' ', $column));
                    
                    $pdocrud->addFilter('filterAdd'.$columnName, 'Filtrar por '.$columnName.' ', '', 'dropdown');
                    $pdocrud->setFilterSource('filterAdd'.$columnName, 'personas', $columnName, $columnName.' as pl', 'db');
                }
                
                $pdocrud->setSettings('encryption', true);
                $pdocrud->setSettings('pagination', true);
                $pdocrud->setSettings('searchbox', true);
                $pdocrud->setSettings('function_filter_and_search', true);
                $pdocrud->setSettings('deleteMultipleBtn', true);
                $pdocrud->setSettings('checkboxCol', true);
                $pdocrud->setSettings('recordsPerPageDropdown', true);
                $pdocrud->setSettings('totalRecordsInfo', true);
                $pdocrud->setSettings('addbtn', true);
                $pdocrud->setSettings('editbtn', true);
                $pdocrud->setSettings('viewbtn', false);
                $pdocrud->setSettings('delbtn', true);
                $pdocrud->setSettings('actionbtn', true);
                $pdocrud->setSettings('refresh', false);
                $pdocrud->setSettings('numberCol', true);
                $pdocrud->setSettings('printBtn', true);
                $pdocrud->setSettings('pdfBtn', true);
                $pdocrud->setSettings('csvBtn', true);
                $pdocrud->setSettings('excelBtn', true);
                if ('Si' == 'Si') {
                    $pdocrud->setSettings('clonebtn', true);
                }
                $pdocrud->buttonHide('submitBtnSaveBack');
                $pdocrud->setSettings('template', 'template_personas');
                $render = $pdocrud->dbTable('personas')->render();

                View::render(
                    'personas', 
                    [
                        'render' => $render
                    ]
                );
            }
        }