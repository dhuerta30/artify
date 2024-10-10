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
                
                        $artify->setSearchCols(array("id", "nombre"));
                    
                        $artify->crudTableCol(array("id", "nombre"));
                    
                        $artify->formFields(array("nombre"));
                    
                        $artify->editFormFields(array("id", "nombre"));
                    

                        $valuesArray = array("nombre");

                        foreach ($valuesArray as $column) {
                            $columnName = ucfirst(str_replace('_', ' ', $column));
                            
                            $artify->addFilter('filterAdd'.$column, 'Filtrar por '.$columnName.' ', '', 'dropdown');
                            $artify->setFilterSource('filterAdd'.$column, 'personas', $column, $column.' as pl', 'db');
                        }
                    
                $artify->dbOrderBy("id", "ASC");
            
                $artify->currentPage(1);
            
                $artify->setSettings("actionBtnPosition", "left");
            
                    $artify->setSettings('editbtn', true);
                
                    $artify->setSettings('delbtn', true);
                
                    $artify->buttonHide("submitBtnSaveBack");
                
                    $artify->setSettings('printBtn', true);
                
                    $artify->setSettings('pdfBtn', true);
                
                    $artify->setSettings('excelBtn', true);
                
                $artify->setSettings('inlineEditbtn', false);
            
                $artify->setSettings('actionbtn', true);
            
                $artify->setSettings('function_filter_and_search', true);
            
                $artify->setSettings('searchbox', true);
            
                $artify->setSettings('clonebtn', true);
            
                $artify->setSettings('checkboxCol', true);
                $artify->setSettings('deleteMultipleBtn', true);
            
                $artify->setSettings('refresh', true);
            
                $artify->setSettings('addbtn', true);
            
                $artify->setSettings('encryption', false);
            
                $artify->setSettings('required', true);
            
                $artify->setSettings('pagination', true);
            
                $artify->setSettings('numberCol', true);
            
                $artify->setSettings('recordsPerPageDropdown', true);
            
                $artify->recordsPerPage(10);
            
            $artify->setSettings('totalRecordsInfo', true);
            $artify->setSettings('template', 'template_personas');
            $render = $artify->dbTable('personas')->render();

            View::render('personas', ['render' => $render]);
        }}