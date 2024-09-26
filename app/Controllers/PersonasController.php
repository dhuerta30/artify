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

                
                $pdocrud->setSettings('searchbox', false);
            
                $pdocrud->setSettings('clonebtn', false);
            
                $pdocrud->setSettings('checkboxCol', false);
                $pdocrud->setSettings('deleteMultipleBtn', false);
            
                $pdocrud->setSettings('addbtn', true);
            
                $pdocrud->setSettings('encryption', true);
                $pdocrud->setSettings('pagination', true);
                $pdocrud->setSettings('function_filter_and_search', true);
                $pdocrud->setSettings('recordsPerPageDropdown', true);
                $pdocrud->setSettings('totalRecordsInfo', true);
                $pdocrud->setSettings('actionbtn', true);
                $pdocrud->setSettings('refresh', false);
                $pdocrud->setSettings('numberCol', true);
                $pdocrud->buttonHide('submitBtnSaveBack');
                $pdocrud->setSettings('template', 'template_personas');
                $render = $pdocrud->dbTable('personas')->render();

                View::render(
                    'personas', ['render' => $render]
                    );
                }
            }