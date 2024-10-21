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
                <img src="<?=$_ENV["BASE_URL"]?>theme/img/avatar.jpg" class="img-circle avatar elevation-2">
             </div>
             <div class="info">
                 <a href="#" class="d-block nombre_usuario"></a>
             </div>
         </div>

         <!-- Sidebar Menu -->

            <?php
                $current_url = $_SERVER['REQUEST_URI'];
                $menu = App\Controllers\HomeController::Obtener_menus();
            ?>

            <div class="menu_generator">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                    <?php foreach ($menu as $item): ?>
                        <?php if (($item["nombre_menu"] != "usuarios") && $item["visibilidad_menu"] != "Ocultar" ): ?>
                            <?php
                                // Obtiene submenús
                                $submenus = App\Controllers\HomeController::Obtener_submenus($item['id_menu']);
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

                    </ul>
                </nav>
            </div>

         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>