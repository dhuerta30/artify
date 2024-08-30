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
                $pdocrud->setSettings('encryption', true);
                $pdocrud->setSettings('pagination', true);
                $pdocrud->setSettings('searchbox', true);
                $pdocrud->setSettings('deleteMultipleBtn', true);
                $pdocrud->setSettings('checkboxCol', true);
                $pdocrud->setSettings('recordsPerPageDropdown', true);
                $pdocrud->setSettings('totalRecordsInfo', true);
                $pdocrud->setSettings('addbtn', true);
                $pdocrud->setSettings('editbtn', true);
                $pdocrud->setSettings('delbtn', true);
                $pdocrud->setSettings('actionbtn', true);
                $pdocrud->setSettings('refresh', false);
                $pdocrud->setSettings('numberCol', true);
                $pdocrud->setSettings('printBtn', true);
                $pdocrud->setSettings('pdfBtn', true);
                $pdocrud->setSettings('csvBtn', true);
                $pdocrud->setSettings('excelBtn', true);
                $pdocrud->setSettings('clonebtn', false);
                $pdocrud->buttonHide('submitBtnSaveBack');
                $pdocrud->setSettings('template', 'template_demo');
                $render = $pdocrud->dbTable('demo')->render();

                View::render(
                    'demo', 
                    [
                        'render' => $render
                    ]
                );
            }
        }