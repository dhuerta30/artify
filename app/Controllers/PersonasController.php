<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\DB;
        use App\core\View;
        use App\core\Redirect;
        use Docufy;

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
                $artify = DB::ArtifyCrud();
                $queryfy = $artify->getQueryfyObj();
                $columnDB = $queryfy->columnNames('personas');
                unset($columnDB[0]);

                
                        $artify->setSearchCols(array("id_personas", "nombre", "apellido", "categoria", "producto"));
                    
                        $artify->crudTableCol(array("id_personas", "nombre", "apellido", "categoria", "producto"));
                    
                        $artify->formFields(array("nombre", "apellido", "categoria", "producto"));
                    
                        $artify->editFormFields(array("nombre", "apellido", "categoria", "producto"));
                    
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
                            <p class="artify_help_block help-block form-text with-errors"></p>
                        </div>
                    </div>';

                    $sizeIndex++;
                }

                $html_template .= '</div></div>';

                $artify->set_template($html_template);
                
                $artify->tableHeading('Módulo de Personas');
            
                $artify->setSettings("actionBtnPosition", "right");
            
                    $artify->setSettings('viewbtn', true);
                
                    $artify->setSettings('editbtn', true);
                
                    $artify->setSettings('delbtn', true);
                
                    $artify->setSettings('csvBtn', true);
                
                    $artify->setSettings('excelBtn', true);
                
                $artify->setSettings('inlineEditbtn', true);
            
                $artify->setSettings('actionbtn', true);
            
                $artify->setSettings('function_filter_and_search', true);
            
                $artify->setSettings('searchbox', true);
            
                $artify->setSettings('clonebtn', true);
            
                $artify->setSettings('checkboxCol', true);
                $artify->setSettings('deleteMultipleBtn', true);
            
                $artify->setSettings('refresh', true);
            
                $artify->setSettings('addbtn', true);
            
                $artify->setSettings('encryption', true);
            
                $artify->setSettings('required', true);
            
                $artify->setSettings('pagination', true);
            
                $artify->setSettings('numberCol', false);
            
                $artify->setSettings('recordsPerPageDropdown', true);
            
                $artify->recordsPerPage(10);
            
            $artify->setSettings('totalRecordsInfo', true);
            $artify->setSettings('template', 'template_personas');
            $render = $artify->dbTable('personas')->render();

            View::render('personas', ['render' => $render]);
        }}