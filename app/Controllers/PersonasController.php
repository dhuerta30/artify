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
                
                        $artify->setSearchCols(array("1"));
                    
                        $artify->crudTableCol(array("1"));
                    
                        $artify->formFields(array("1"));
                    
                        $artify->editFormFields(array("1"));
                    
                                    $artify->addFilter('filterAdd1', 'Filtrar por 1', '1', '1');
                                    $artify->setFilterSource('filterAdd1', 'personas', '1', '1 as pl', 'db');
                                
                                $artify->colRename("1", "1");
                            
                                $artify->fieldRenameLable("1", "1");
                            
                $artify->tableHeading('1');
            
                $artify->setSettings("actionFilterPosition", "left");
            
                $artify->dbOrderBy("1", "1");
            
                $artify->currentPage(1);
            
                $artify->setSettings("actionBtnPosition", "right");
            
                $artify->formDisplayInPopup();
            
                $artify->setSettings('inlineEditbtn', true);
            
                $artify->setSettings('hideAutoIncrement', false);
            
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
            
                $artify->setSettings('totalRecordsInfo', true);
            
                $artify->recordsPerPage(1);
            
            $artify->setSettings('template', 'template_personas');
            $render = $artify->dbTable('personas')->render();

            View::render('personas', ['render' => $render]);
        }

        }