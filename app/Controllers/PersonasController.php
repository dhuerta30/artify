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

                
                        $artify->setSearchCols(array("nombre", "apellido", "categoria", "producto"));
                    
                        $artify->recaptcha("6LdYUwgUAAAAAMvuaWvL6esSCd-9TvjVD3NIWcF6", "6LdYUwgUAAAAAEBHn34n37p2qM44Ppj-fCUqB5wg");
                    
                        $artify->crudTableCol(array("id_personas", "nombre", "apellido", "categoria", "producto"));
                    
                        $artify->formFields(array("nombre", "apellido", "categoria", "producto"));
                    
                foreach ($columnDB as $column) {
                    $columnName = ucfirst(str_replace('_', ' ', $column));
                    
                    $artify->addFilter('filterAdd'.$column, 'Filtrar por '.$columnName.' ', '', 'dropdown');
                    $artify->setFilterSource('filterAdd'.$column, 'personas', $column, $column.' as pl', 'db');
                }
                
                    $artify->setSettings('editbtn', true);
                
                    $artify->setSettings('delbtn', true);
                
                    $artify->buttonHide("submitBtnSaveBack");
                
                    $action = $_ENV['BASE_URL'].'Personas/personas_pdf/id/{id_personas}';
                    $text = "<i class='fa fa-file-pdf-o'></i>";
                    $attr = array('title'=> 'Ver PDF', 'target'=> '_blank');
                    $artify->enqueueBtnActions('artify-button-url', $action, 'url', $text, '', $attr);
                
                    $artify->setSettings('printBtn', true);
                
                    $artify->setSettings('pdfBtn', true);
                
                    $artify->setSettings('csvBtn', true);
                
                    $artify->setSettings('excelBtn', true);
                
                $artify->formDisplayInPopup();
            
                $artify->setSettings('searchbox', true);
            
                $artify->setSettings('clonebtn', true);
            
                $artify->setSettings('checkboxCol', true);
                $artify->setSettings('deleteMultipleBtn', true);
            
                $artify->setSettings('refresh', true);
            
                $artify->setSettings('addbtn', true);
            
                $artify->setSettings('encryption', false);
            
            $artify->setSettings('pagination', true);
            $artify->setSettings('function_filter_and_search', true);
            $artify->setSettings('recordsPerPageDropdown', true);
            $artify->setSettings('totalRecordsInfo', true);
            $artify->setSettings('actionbtn', true);
            $artify->setSettings('numberCol', true);
            $artify->setSettings('template', 'template_personas');
            $render = $artify->dbTable('personas')->render();

            View::render('personas', ['render' => $render]);
                   }
                    public function personas_pdf(){
                        
                        $docufy = DB::Docufy();
                        $docufy->setInvoiceDisplaySettings("header", "", false);
                        $docufy->setInvoiceDisplaySettings("to", "", false);
                        $docufy->setInvoiceDisplaySettings("from", "", false);
                        $docufy->setInvoiceDisplaySettings("footer",  "", false);
                        $docufy->setInvoiceDisplaySettings("payment", "", false);
                        $docufy->setInvoiceDisplaySettings("message", "", false);
                        $docufy->setInvoiceDisplaySettings("total", "subtotal", false);
                        $docufy->setInvoiceDisplaySettings("total", "discount", false);
                        $docufy->setInvoiceDisplaySettings("total", "tax", false);
                        $docufy->setInvoiceDisplaySettings("total", "shipping", false);
                        $docufy->setInvoiceDisplaySettings("total", "grandtotal", false);
                        echo $docufy->render();
                    }
                }
                