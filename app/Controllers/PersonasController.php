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

                
                    $artify->setSettings('editbtn', true);
                
                    $artify->setSettings('delbtn', true);
                
                    $artify->buttonHide("submitBtnSaveBack");
                
                    $action = $_ENV['BASE_URL'].'Personas/personas_invoice_pdf/id/{id_personas}';
                    $text = "<i class='fa fa-file-pdf-o'></i>";
                    $attr = array('title'=> 'Ver PDF', 'target'=> '_blank');
                    $artify->enqueueBtnActions('artify-button-url', $action, 'url', $text, '', $attr);
                
                $artify->formDisplayInPopup();
            
                $artify->setSettings('searchbox', true);
            
                $artify->setSettings('clonebtn', true);
            
                $artify->setSettings('checkboxCol', true);
                $artify->setSettings('deleteMultipleBtn', true);
            
                $artify->setSettings('refresh', true);
            
                $artify->setSettings('addbtn', true);
            
            $artify->setSettings('encryption', true);
            $artify->setSettings('pagination', true);
            $artify->setSettings('function_filter_and_search', true);
            $artify->setSettings('recordsPerPageDropdown', true);
            $artify->setSettings('totalRecordsInfo', true);
            $artify->setSettings('actionbtn', true);
            $artify->setSettings('numberCol', true);
            $artify->buttonHide('submitBtnSaveBack');
            $artify->setSettings('template', 'template_personas');
            $render = $artify->dbTable('personas')->render();

            View::render(
                'personas', ['render' => $render]
                );
            }
        
        public function personas_invoice_pdf(){
            
            /*$docufy = DB::Docufy();
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
            $docufy->setInvoiceDisplaySettings("total", "grandtotal", false);*/
            echo "1";
        }
    }
                