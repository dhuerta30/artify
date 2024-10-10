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
                
                        $artify->setSearchCols(array("id_personas", "nombre", "apellido", "fecha_nacimiento", "descripcion"));
                    
                        $artify->crudTableCol(array("id_personas", "nombre", "apellido", "fecha_nacimiento", "descripcion"));
                    
                        $artify->formFields(array("nombre", "apellido", "fecha_nacimiento", "descripcion"));
                    
                        $artify->editFormFields(array("id_personas", "nombre", "apellido", "fecha_nacimiento", "descripcion"));
                    
                                //$artify->addFilter('filterAddnombre', 'Filtrar por Nombre', '', 'radio');
                                //$artify->setFilterSource('filterAddnombre', 'personas', 'nombre', 'nombre as pl', 'db');
                            
                                $artify->addFilter('FilterApellido', 'Filtrar por Apellido', '', 'dropdown');
                                $artify->setFilterSource('FilterApellido', 'personas', 'apellido', 'apellido as pl', 'db');
                            
                                $artify->colRename("id_personas", "id");
                            
                                $artify->fieldRenameLable("id_personas", "id");
                            
                $artify->tableHeading('Módulo de Personas');
            
                $artify->dbOrderBy("id_personas", "ASC");
            
                $artify->currentPage(1);
            
                $artify->setSettings("actionBtnPosition", "right");
            
                    $artify->setSettings('editbtn', true);
                
                    $artify->setSettings('delbtn', true);
                
                    $artify->buttonHide("submitBtnSaveBack");
                
                    $artify->setSettings('printBtn', true);
                
                    $artify->setSettings('excelBtn', true);
                
                $artify->setSettings('inlineEditbtn', false);
            
                $artify->setSettings('hideAutoIncrement', false);
            
                $artify->setSettings('actionbtn', true);
            
                $artify->setSettings('function_filter_and_search', true);
            
                $artify->setSettings('searchbox', true);
            
                $artify->setSettings('clonebtn', false);
            
                $artify->setSettings('checkboxCol', true);
                $artify->setSettings('deleteMultipleBtn', true);
            
            $artify->setSettings('refresh', false);
        
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
        }

        }