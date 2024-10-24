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
                    $settings["script_url"] = $_ENV['URL_ArtifyCrud'];
                    $_ENV["url_artify"] = "artify/functions.php";
                    $settings["url_artify"] = $_ENV["url_artify"];
                    $settings["downloadURL"] = $_ENV['DOWNLOAD_URL'];
                    $settings["hostname"] = $_ENV['DB_HOST'];
                    $settings["database"] = $_ENV['DB_NAME'];
                    $settings["username"] = $_ENV['DB_USER'];
                    $settings["password"] = $_ENV['DB_PASS'];
                    $settings["dbtype"] = $_ENV['DB_TYPE'];
                    $settings["characterset"] = $_ENV["CHARACTER_SET"];

                    $artify = DB::ArtifyCrud(false, "", "",  $settings);
                    $queryfy = $artify->getQueryfyObj();
                
                                $artify->addCallback("before_insert", "before_insert_personas");
                            
                                $artify->addCallback("after_insert", "after_insert_personas");
                            
                                $artify->addCallback("before_update", "before_update_personas");
                            
                        $artify->setSearchCols(array("id_personas", "nombre", "apellido", "fecha_nacimiento", "adjunto"));
                    
                        $artify->crudTableCol(array("id_personas", "nombre", "apellido", "fecha_nacimiento", "adjunto"));
                    
                                            $artify->fieldTypes("nombre", "input");
                                        
                                            $artify->fieldTypes("apellido", "input");
                                        
                                            $artify->fieldTypes("fecha_nacimiento", "date");
                                        
                                            $artify->fieldTypes("adjunto", "FILE");
                                        
                        $artify->formFields(array("nombre", "apellido", "fecha_nacimiento", "adjunto"));
                    
                        $artify->editFormFields(array("id_personas", "nombre", "apellido", "fecha_nacimiento", "adjunto"));
                    
                                    $artify->addFilter('filterAddnombre', 'Filtrar por Nombre', 'nombre', 'dropdown');
                                    $artify->setFilterSource('filterAddnombre', 'personas', 'nombre', 'nombre as pl', 'db');
                                
                                    $artify->addFilter('filterAddapellido', 'Filtrar por Apellido', 'apellido', 'dropdown');
                                    $artify->setFilterSource('filterAddapellido', 'personas', 'apellido', 'apellido as pl', 'db');
                                
                                    $artify->addFilter('filterAddfecha_nacimiento', 'Filtrar por Fecha nacimiento', 'fecha_nacimiento', 'date');
                                    $artify->setFilterSource('filterAddfecha_nacimiento', 'personas', 'fecha_nacimiento', 'fecha_nacimiento as pl', 'db');
                                
                                $artify->colRename("id_personas", "id");
                            
                                $artify->fieldRenameLable("id_personas", "id");
                            
                $artify->tableHeading('Módulo de Personas');
            
                $artify->setSettings("actionFilterPosition", "top");
            
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
            
                $artify->setSettings('encryption', false);
            
                $artify->setSettings('required', true);
            
                $artify->setSettings('pagination', true);
            
                $artify->setSettings('numberCol', false);
            
                $artify->setSettings('recordsPerPageDropdown', true);
            
                $artify->setSettings('totalRecordsInfo', true);
            
                $artify->recordsPerPage(10);
            
            $artify->setSettings('template', 'template_personas');
            $render = $artify->dbTable('personas')->render();

            View::render('personas', ['render' => $render]);
        }

        }