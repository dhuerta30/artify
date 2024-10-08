<?php

        namespace App\Controllers;

        use App\core\SessionManager;
        use App\core\Token;
        use App\core\DB;
        use App\core\View;
        use App\core\Redirect;
        use Docufy;

        class EmpleadosController
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
                $columnDB = $queryfy->columnNames('empleados');
                unset($columnDB[0]);

                
                        $artify->setSearchCols(array("id_empleados", "nombre_empleado", "apellido_empleado", "fecha_nacimiento_empleado"));
                    
                        $artify->crudTableCol(array("id_empleados", "nombre_empleado", "apellido_empleado", "fecha_nacimiento_empleado"));
                    
                        $artify->formFields(array("nombre_empleado", "apellido_empleado", "fecha_nacimiento_empleado"));
                    
                        $artify->editFormFields(array("nombre_empleado", "apellido_empleado", "fecha_nacimiento_empleado"));
                    
                $artify->tableHeading('Módulo de Empleados');
            
                $artify->dbOrderBy("id_empleados", "ASC");
            
                $artify->currentPage(1);
            
                $artify->setSettings("actionBtnPosition", "right");
            
                    $artify->setSettings('viewbtn', true);
                
                    $artify->setSettings('editbtn', true);
                
                    $artify->setSettings('delbtn', true);
                
                    $artify->buttonHide("submitBtnSaveBack");
                
                    $action = $_ENV['BASE_URL'].'Empleados/empleados_pdf/id/{id_empleados}';
                    $text = "<i class='fa fa-file-pdf-o'></i>";
                    $attr = array('title'=> 'Ver PDF', 'target'=> '_blank');
                    $artify->enqueueBtnActions('artify-button-url', $action, 'url', $text, '', $attr);
                
                $artify->setSettings('inlineEditbtn', false);
            
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
            $artify->setSettings('template', 'template_empleados');
            $render = $artify->dbTable('empleados')->render();

            View::render('empleados', ['render' => $render]);
        }
                    public function empleados_pdf(){
                        
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