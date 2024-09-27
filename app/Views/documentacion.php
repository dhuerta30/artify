
<?php require "layouts/header.php"; ?>
<?php require "layouts/sidebar.php"; ?>
<div class="content-wrapper">
    <section class="content">
        <div class="card mt-4">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="artify-tab" data-toggle="tab" href="#artify" role="tab" aria-controls="artify" aria-selected="true"><i class="fa fa-table"></i> ArtifyCrud</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="queryfy-tab" data-toggle="tab" href="#queryfy" role="tab" aria-controls="queryfy" aria-selected="false"><i class="fa fa-database"></i> Queryfy</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="docufy-tab" data-toggle="tab" href="#docufy" role="tab" aria-controls="docufy" aria-selected="false"><i class="far fa-file"></i> Docufy</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="api-tab" data-toggle="tab" href="#api" role="tab" aria-controls="api" aria-selected="false"><i class="fa fa-key"></i> Apify</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade p-4 show active" id="artify" role="tabpanel" aria-labelledby="artify-tab">

                                <h5>Generador de Mantendores Crud</h5>
                                <pre class="brush: php;">
                                    &lt;?php 
                                        // Para inicializar Artify Crud use
                                        $artify = DB::ArtifyCrud();

                                        // Para usar una Plantilla personalizada para las vistas de formulario use
                                        $html_template = '&lt;div class="order-form"&gt;
                                            &lt;h2&gt;Products&lt;/h2&gt;
                                            &lt;div class="row"&gt;
                                                &lt;div class="col-md-6"&gt;
                                                    &lt;div class="form-group"&gt;
                                                        &lt;label class="form-label"&gt;Product Id:&lt;/label&gt;
                                                        {product_id}
                                                        &lt;p class="pdocrud_help_block help-block form-text with-errors"&gt;&lt;/p&gt;
                                                    &lt;/div&gt;
                                                &lt;/div&gt;
                                                &lt;div class="col-md-6"&gt;
                                                    &lt;div class="form-group"&gt;
                                                        &lt;label class="form-label"&gt;Product Name:&lt;/label&gt;
                                                        {product_name}
                                                        &lt;p class="pdocrud_help_block help-block form-text with-errors"&gt;&lt;/p&gt;
                                                    &lt;/div&gt;
                                                &lt;/div&gt;
                                            &lt;/div&gt;
                                            &lt;div class="row"&gt;
                                                &lt;div class="col-md-6"&gt;
                                                    &lt;div class="form-group"&gt;
                                                        &lt;label class="form-label"&gt;Product Price:&lt;/label&gt;
                                                        {product_price}
                                                        &lt;p class="pdocrud_help_block help-block form-text with-errors"&gt;&lt;/p&gt;
                                                    &lt;/div&gt;
                                                &lt;/div&gt;
                                                &lt;div class="col-md-6"&gt;
                                                    &lt;div class="form-group"&gt;
                                                        &lt;label class="form-label"&gt;Product Sell Price:&lt;/label&gt;
                                                        {product_sell_price}
                                                        &lt;p class="pdocrud_help_block help-block form-text with-errors"&gt;&lt;/p&gt;
                                                    &lt;/div&gt;
                                                &lt;/div&gt;
                                            &lt;/div&gt;
                                        &lt;/div&gt;';
                                        $artify->set_template($html_template);

                                        // Para ocultar realizar logica de visualización en un boton de ver, editar o eliminar use
                                        $artify->addWhereConditionActionButtons("edit", $colname_where,"!=", array(76778));

                                        // Para renombrar una columna de la grilla use
                                        $artify->colRename("campo_BD", "nuevo nombre");

                                        // Para definir que campos usar en el buscador use
                                        $artify->setSearchCols(array("id","first_name"));

                                        // Para definir que columnas se mostraran en la grilla use
                                        $artify->crudTableCol(array("first_name","last_name","user_name","gender"));

                                        // Para realizar LEFT JOIN use
                                        $artify->joinTable("user_meta", "user_meta.user_id = users.user_id", "LEFT JOIN");

                                        // Para realizar INNER JOIN use
                                        $artify->joinTable("user_meta", "user_meta.user_id = users.user_id", "INNER JOIN");

                                        // Para crear un combobox use
                                        $artify->relatedData('class_id','class','class_id','class_name');

                                        // Para Ocultar La Paginación use
                                        $artify->setSettings("pagination", false);

                                        // Para Ocultar la busqueda use
                                        $artify->setSettings("searchbox", false);

                                        // Para ocultar el boton de eliminación masiva use
                                        $artify->setSettings("deleteMultipleBtn", false);

                                        // Para ocultar el boton de refrescar use
                                        $artify->setSettings("refresh", false);

                                        // Para Ocultar los registros por Página use
                                        $artify->setSettings("recordsPerPageDropdown", false);

                                        // Para Ocultar la información de cantidad de registros totales use
                                        $artify->setSettings("totalRecordsInfo", false);

                                        // Para Ocultar el botón de agregar use
                                        $artify->setSettings("addbtn", false);

                                        // Para Ocultar el botón de editar use
                                        $artify->setSettings("editbtn", false);

                                        // Para Ocultar el Botón de ver use
                                        $artify->setSettings("viewbtn", false);

                                        // Para Ocultar el botón de eliminar use
                                        $artify->setSettings("delbtn", false);

                                        // Para Ocultar la columna Acciones de la grilla use
                                        $artify->setSettings("actionbtn", false);

                                        // Para ocultar los checkbox de la eliminación masiva use
                                        $artify->setSettings("checkboxCol", false);

                                        // Para Ocultar la columna # use
                                        $artify->setSettings("numberCol", false);

                                        // Para Ocultar el botón de exportación imprimir de la grilla use
                                        $artify->setSettings("printBtn", false);

                                        // Para Ocultar el botón de exportación pdf de la grilla use
                                        $artify->setSettings("pdfBtn", false);

                                        // Para Ocultar el botón de exportación csv de la grilla use
                                        $artify->setSettings("csvBtn", false);

                                        // Para Ocultar el botón de exportación excel de la grilla use
                                        $artify->setSettings("excelBtn", false);

                                        // Para usar una Plantilla Personalizada use
                                        $artify->setSettings("template", "nombre_plantilla");

                                        // Para Ocultar una o mas columnas de la grilla use
                                        $artify->crudRemoveCol(array("user_id"));

                                        // Para usar Filtros de Buqueda use
                                        $artify->addFilter("product_cat_filter", "Product Category", "product_cat", "radio");
                                        $artify->setFilterSource("product_cat_filter", array("Electronic" => "Electronic", "Fashion" => "Fashion"), "", "", "array");
                                        
                                        $artify->addFilter("ProductLineFilter", "Product Line", "product_line", "dropdown");
                                        $artify->setFilterSource("ProductLineFilter", "products", "product_line", "product_line as pl", "db");
                                        
                                        $artify->addFilter("ProductVendorFilter", "Vendor", "ProductVendor", "text");
                                        $artify->setFilterSource("ProductVendorFilter", "", "", "", "");

                                        // Para renderizar la grilla y pasar el nombre de la tabla use
                                        echo $artify->dbTable("users")->render();
                                    ?&gt;
                                </pre>
                                                    
                            </div>
                            <div class="tab-pane fade p-4" id="queryfy" role="tabpanel" aria-labelledby="queryfy-tab">

                                <h5>Generador de Consultas de Base de Datos</h5>
                                <pre class="brush: php;">
                                    &lt;?php 

                                        // Para inicializar Queryfy use
                                        $queryfy = DB::Queryfy();
                                        $queryfy->columns = array("empId", "firstName", "lastName");
                                        $result =  $queryfy->select("emp");

                                        $queryfy->where("age",30,">=");
                                        $result = $queryfy->select("emp");

                                        $queryfy->where("status", 1);
                                        $queryfy->where("age",30,">=");
                                        $queryfy->openBrackets = "(";
                                        $queryfy->where("firstName", 'John');
                                        $queryfy->andOrOperator = "OR";
                                        $queryfy->where("firstName", 'bob');
                                        $queryfy->closedBrackets = ")";
                                        $result =  $queryfy->select("emp");
                                    ?&gt;
                                </pre>

                            </div>
                            <div class="tab-pane fade p-4" id="docufy" role="tabpanel" aria-labelledby="docufy-tab">

                                <h5>Generador de Documentos HTML y PDF</h5>
                                <pre class="brush: php;">
                                    &lt;?php 

                                        // Para inicializar Docufy use
                                        $docufy = DB::Docufy();

                                        // Para usar una plantilla de Documento use
                                        $docufy->setTemplateName("invoice/invoice_2.php");

                                        // Renderizar el Documento como PDF
                                        echo $docufy->render();

                                        // Renderizar el Documento como HTML
                                        echo $docufy->render("HTML");
                                    ?&gt;
                                </pre>

                            </div>
                            <div class="tab-pane fade p-4" id="api" role="tabpanel" aria-labelledby="api-tab">

                                <h5>Generador de Api</h5>
                                <pre class="brush: php;">
                                    &lt;?php

                                        // Para seleccionar los datos en formato json Apify use

                                        namespace App\Controllers;

                                        use App\core\SessionManager;
                                        use App\core\Token;
                                        use App\core\Request;
                                        use App\core\View;
                                        use App\core\Redirect;
                                        use App\core\DB;
                                        use GuzzleHttp\Client;
                                        use GuzzleHttp\Exception\ClientException;

                                        class DocumentacionController
                                        {
                                            public function index()
                                            {
                                                View::render("documentacion");
                                            }

                                            public function ejemplo(){
                                                try {
                                                    $client = new Client();
                                                    $response = $client->get("http://tudominio.com/". $_ENV["BASE_URL"].'/api/usuario/');
                                                    $result = $response->getBody()->getContents();
                                                    print_r($result);

                                                } catch (ClientException $e) {
                                                    if ($e->getResponse()->getStatusCode() == 401) {
                                                        echo $e->getResponse()->getBody()->getContents() . PHP_EOL;
                                                    }
                                                }
                                            }
                                        }
                        
                                    ?&gt;
                                </pre>

                            </div>
                        </div>

                    
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<script src="<?=$_ENV["BASE_URL"]?>app/libs/artify/js/jquery.min.js"></script>
<?php require "layouts/footer.php"; ?>
