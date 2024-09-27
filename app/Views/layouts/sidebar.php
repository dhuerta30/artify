 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="<?=$_ENV["BASE_URL"]?>" class="brand-link text-center" style="background-color:#fff;">
         <img src="<?=$_ENV["BASE_URL"]?>theme/img/artify.png" alt="AdminLTE Logo" width="55">
         <span class="brand-text font-weight-light"></span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <?php if(!isset($_SESSION["usuario"][0]["avatar"])): ?>
                    <img src="<?=$_ENV["BASE_URL"]?>theme/img/avatar.jpg" class="img-circle avatar elevation-2">
                 <?php else: ?>
                    <img src="<?=$_ENV["BASE_URL"]?>app/libs/script/uploads/<?=$_SESSION["usuario"][0]["avatar"]?>" class="img-circle avatar elevation-2">
                 <?php endif; ?>
             </div>
             <div class="info">
                 <a href="#" class="d-block nombre_usuario"><?=$_SESSION['usuario'][0]["nombre"]?></a>
             </div>
         </div>

         <!-- Sidebar Menu -->

         <?php
            $current_url = $_SERVER['REQUEST_URI'];
            $id_sesion_usuario = $_SESSION["usuario"][0]["id"];
            $menu = App\Controllers\HomeController::obtener_menu_por_id_usuario($id_sesion_usuario);
            ?>

            <div class="menu_generator">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <?php foreach ($menu as $item): ?>
                        <?php if (($_SESSION["usuario"][0]["idrol"] == 1 || $item["nombre_menu"] != "usuarios") && $item["visibilidad_menu"] != "Ocultar" ): ?>
                            <?php
                                // Obtiene submenús
                                $submenus = App\Controllers\HomeController::Obtener_submenu_por_id_menu($item['id_menu'], $id_sesion_usuario);
                                $tieneSubmenus = ($item["submenu"] == "Si");
                                $subMenuAbierto = false;

                                // Verifica si algún submenú está activo
                                foreach ($submenus as $submenu) {
                                    if (strpos($current_url, $submenu['url_submenu']) !== false) {
                                        $subMenuAbierto = true;
                                        break;
                                    }
                                }
                            ?>
                            <li class="nav-item<?= ($subMenuAbierto) ? ' menu-is-opening menu-open' : ''; ?>">
                                <?php if ($tieneSubmenus): ?>
                                    <a href="javascript:;" class="nav-link <?= (strpos($current_url, $submenu['url_submenu']) !== false) ? 'active' : ''; ?>">
                                        <i class="<?= $item['icono_menu'] ?>"></i>
                                        <p>
                                            <?= $item['nombre_menu'] ?>
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview" style="<?= ($subMenuAbierto) ? 'display: block;' : ''; ?>">
                                        <?php foreach ($submenus as $submenu): ?>
                                            <?php if($submenu["visibilidad_submenu"] != "Ocultar"): ?>
                                            <li class="nav-item">
                                                <a href="<?= rtrim($_ENV["BASE_URL"], '/') . $submenu['url_submenu'] ?>" class="nav-link <?= (strpos($current_url, $submenu['url_submenu']) !== false) ? 'active' : ''; ?>">
                                                    <i class="<?= $submenu['icono_submenu'] ?>"></i>
                                                    <p><?= $submenu['nombre_submenu'] ?></p>
                                                </a>
                                            </li>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <a href="<?= rtrim($_ENV["BASE_URL"], '/') . $item['url_menu'] ?>" class="nav-link <?= (strpos($current_url, $item['url_menu']) !== false) ? 'active' : ''; ?>">
                                        <i class="<?= $item['icono_menu'] ?>"></i>
                                        <p><?= $item['nombre_menu'] ?></p>
                                    </a>
                                <?php endif; ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <li class="nav-item">
                        <a href="javascript:;" class="nav-link" data-toggle="modal" data-target="#Documentation"><i class="fa fa-book"></i> Documentación</a>
                    </li>

                    </ul>
                </nav>
            </div>

         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>



 <div class="modal fade" id="Documentation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-book"></i> Documentación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="columns_search-tab" data-toggle="tab" href="#columns_search" role="tab" aria-controls="columns_search" aria-selected="true">ArtifyCrud</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Queryfy</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Docufy</a>
            </li>
        </ul>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="columns_search" role="tabpanel" aria-labelledby="columns_search-tab">

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
                        $pdocrud->set_template($html_template);

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

                        // Para renderizar la grilla y pasar el nombre de la tabla use
                        echo $artify->dbTable("users")->render();
                    ?&gt;
                </pre>
                                    
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                <pre class="brush: php;">
                    &lt;?php 
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
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>