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

                $html_template = '<div class="form">
                <h5>Agregar Módulo</h5>
                <hr>
                <div class="row">';

                $columnSizes = [
                    'col-md-4',
                    'col-md-4',
                    'col-md-4',
                    'col-md-12'
                ];

                $sizeIndex = 0;

                foreach ($columnDB as $column) {
                    $columnName = ucfirst(str_replace('_', ' ', $column));
                    
                    $colClass = $columnSizes[$sizeIndex % count($columnSizes)];
                    
                    $html_template .= '
                    <div class="' . $colClass . '">
                        <div class="form-group">
                            <label class="form-label">' . $columnName . ':</label>
                            {' . $column . '}
                            <p class="pdocrud_help_block help-block form-text with-errors"></p>
                        </div>
                    </div>';

                    $sizeIndex++;

                    $pdocrud->addFilter('filterAdd'.$columnName, 'Filtrar por '.$columnName.' ', '', 'dropdown');
                    $pdocrud->setFilterSource('filterAdd'.$columnName, 'personas', $columnName, $columnName.' as pl', 'db');
                }

                $html_template .= '</div></div>';

                $pdocrud->set_template($html_template);

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
                $pdocrud->setSettings('clonebtn', true);
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