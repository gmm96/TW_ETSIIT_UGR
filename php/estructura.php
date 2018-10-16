<?php

// Muestra el header
function displayHeader() {
    echo "
        <header>
            <div class='container-fluid'>
                <div class='row'>
    
                    <div class='col-xs-12 col-sm-8 col-md-5 col-md-offset-1 col-lg-5 col-lg-offset-2 vcenter'>
                        <h1 class='text-uppercase vertical-align title'><a href='index.php' class='container-fluid'>Innotechmon</a></h1>
                    </div>
        
                    <div class='col-xs-12 col-sm-4 col-md-5 col-lg-3 vcenter'>
        ";

    if ( isset( $_SESSION['email'] ) ) {
        echo <<< HTML
        <div class="">
        <div class="welcome">
            <p>Bienvenido {$_SESSION['name']}</p>
            <a href="index.php?p=logout" target="_self"><i class="fa fa-sign-out"></i> Desconectar</a>
        </div>
</div>
HTML;

    }
    else {
        echo "
                        <div class='login'>
                            <form method='POST' action='index.php?p=login'>
                                <p>Usted no se ha identificado.</p>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                                    <input id='email' type='text' class='form-control' name='email' placeholder='Email'>
                                </div>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>
                                    <input id='password' type='password' class='form-control' name='password' placeholder='Password'>
                                </div>
                                <input type='submit' class='btn btn-info' value='Login'>
                            </form>
                        </div>";
    }

    echo "
                    </div>

                </div>
            </div>
        </header>
    ";
}

// Muestra el aside
function displayAside(){
    echo "
                <aside class='col-xs-12 col-sm-12 col-md-3 col-lg-2 sidenav aside'>
                    <div class='panel-group' id='panels'>
                        <div class='panel panel-default' id='sections'>
                            <div class='panel-heading' id='collapse1-heading'>
                                <h4 class='panel-title'>
                                    <a data-toggle='collapse' data-parent='#panels' href='#collapse1'><span class=\"glyphicon glyphicon-collapse-down\"></span> Secciones</a>
                                </h4>
                            </div>
                            <div id='collapse1' class='panel-collapse collapse in'>
                                <ul class='nav nav-pills nav-stacked'>
                                    <li><a href='index.php'>Inicio</a></li>
                                    <li><a href='index.php?p=users'>Miembros</a></li>
                                    <li><a href='index.php?p=projects'>Proyectos</a></li>
                                    <li><a href='index.php?p=posts'>Publicaciones</a></li>
                                    <li><a href='documentacion.pdf' target='_blank'>Documentación</a></li>
                                </ul>
                            </div>
                        </div>


    ";

    if ( isset($_SESSION['email']) and isset($_SESSION['user_id']) ) {
        echo "    
    
                        <div class='panel panel-default' id='member'>
                            <div class='panel-heading panel-heading-with-bottom-border' id='collapse2-heading'>
                                <h4 class='panel-title'>
                                    <a data-toggle='collapse' data-parent='#panels' href='#collapse2'><span class=\"glyphicon glyphicon-collapse-down\"></span> Investigación</a>
                                </h4>
                            </div>
                            <div id='collapse2' class='panel-collapse collapse'>
                                <ul class='nav nav-pills nav-stacked list-group'>
                                    <li><a href='index.php?p=add_project'>Añadir proyecto</a></li>
                                    <li><a href='index.php?p=edit_project'>Editar proyecto</a></li>
                                    <li><a href='index.php?p=remove_project'>Borrar proyecto</a></li>
                                </ul>

                                <ul class='nav nav-pills nav-stacked list-group'>
                                    <li class='light-orange'><a href='index.php?p=add_post'>Añadir publicación</a></li>
                                    <li><a href='index.php?p=edit_post'>Editar publicación</a></li>
                                    <li><a href='index.php?p=remove_post'>Borrar publicación</a></li>
                                </ul>
                            </div>
                        </div>
        ";
    }

    if ( isset( $_SESSION['admin'] ) and ($_SESSION['admin'] == 1) and isset($_SESSION['user_id']) ) {
        echo "
                        <div class='panel panel-default' id='admin'>
                            <div class='panel-heading panel-heading-with-bottom-border' id='collapse3-heading'>
                                <h4 class='panel-title'>
                                    <a data-toggle='collapse' data-parent='#panels' href='#collapse3'><span class=\"glyphicon glyphicon-collapse-down\"></span> Administración</a>
                                </h4>
                            </div>
                            <div id='collapse3' class='panel-collapse collapse'>
                                <ul class='nav nav-pills nav-stacked list-group'>
                                    <li><a href='index.php?p=add_user'>Añadir miembro</a></li>
                                    <li><a href='index.php?p=edit_user'>Editar miembro</a></li>
                                    <li><a href='index.php?p=remove_user'>Borrar miembro</a></li>
                                </ul>
                                <ul class='nav nav-pills nav-stacked list-group'>
                                    <li><a href='index.php?p=log'>Log</a></li>
                                    <li><a href='index.php?p=make_backup'>Hacer backup</a></li>
                                    <li><a href='index.php?p=restore_backup'>Restaurar backup</a></li>
                                    <li><a href='index.php?p=uninstall'>Desinstalar</a></li>

                                </ul>
                            </div>
                        </div>
                    </div>
        ";
    }
    echo "</aside>";
}

// Muestra el footer
function displayFooter() {
    echo '
            <footer>
                <footer class="footer-top">
                    <div class="container">
                        <div class="row">
            
                            <div class="col-xs-0 col-sm-0 col-md-1 col-lg-1">
            
                            </div>
            
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <ul class="list-unstyled clear-margins">
                                    <li class="widget-container widget_nav_menu">
                                        <h1 class="title-widget">Mapa del sitio</h1>
                                        <ul class="adding-margin-bottom">
                                            <li><a  href="index.php"><i class="fa fa-angle-double-right"></i> Inicio</a></li>
                                            <li><a  href="index.php?p=users"><i class="fa fa-angle-double-right"></i> Miembros</a></li>
                                            <li><a  href="index.php?p=projects"><i class="fa fa-angle-double-right"></i> Proyectos</a></li>
                                            <li><a  href="index.php?p=posts"><i class="fa fa-angle-double-right"></i> Publicaciones</a></li>
                                            <li><a  href="doc.pdf"><i class="fa fa-angle-double-right"></i> Documentación</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
            
                            <div class="col-xs-0 col-sm-0 col-md-2 col-lg-2">
            
                            </div>
            
                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <ul class="list-unstyled clear-margins">
                                    <li class="widget-container widget_recent_news">
                                        <h1 class="title-widget">Contacto</h1>
                                        <div class="footerp">
                                            <h2 class="title-median">Innotechmon Ltd.</h2>
                                            <p><span class="bold">Email:</span> <a href="mailto:info@innotechmon.com">info@innotechmon.com</a></p>
                                            <p><span class="bold">Horario de oficina:</span> Lunes - Viernes, 9:00 - 19:00 </p>
                                            <p><span class="bold">Teléfono:</span> +34 000 000 000</p>
                                            <p><span class="bold">Fax:</span> +34 000 000 000</p>
                                            <p><span class="bold">Oficina:</span> 742 Evergreen Terrace, 65239, Atlantis City</p>
                                        </div>
            
                                        <div class="social-icons">
                                            <div class="nomargin">
                                                <a target="_blank" href="https://www.facebook.com/innotechmon"><i class="fa fa-facebook-square fa-3x social-fb" id="social"></i></a>
                                                <a target="_blank" href="https://twitter.com/innotechmon"><i class="fa fa-twitter-square fa-3x social-tw" id="social"></i></a>
                                                <a target="_blank" href="https://plus.google.com/+Innotechmon-page"><i class="fa fa-google-plus-square fa-3x social-gp" id="social"></i></a>
                                                <a target="_blank" href="mailto:info@innotechmon.com"><i class="fa fa-envelope-square fa-3x social-em" id="social"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
            
                            <div class="col-xs-0 col-sm-0 col-md-1 col-lg-1">
            
                            </div>
            
                        </div>
                    </div>
                </footer>
            
            
                <footer class="footer-bottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="copyright">
                                    &copy; 2017, Guillermo Montes Martos, All rights reserved
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="design">
                                    Tecnologías Web | UGR
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            
            </footer>  
    ';
}

?>