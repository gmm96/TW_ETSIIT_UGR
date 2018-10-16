<?php

// Variable global para el subtipo de publicación
$pub_subtypes = ['Article'=>'Artículo', 'Book'=>'Libro', 'BookChapter'=>'Capítulo de libro', 'Conference'=>'Conferencia'];



//////////////////////////////////////////////////////
/// SECCIONES
///

// Página de inicio
function displayIndex() {
    echo '        
            <h1>INICIO</h1>
            <hr>
            <h3>Introducción</h3>
            <p class="text-justify"> Innotechmon es uno de los grupos de investigación informática más importantes de
                todo el mundo, famoso por sus colaboraciones con distintas universidades de alrededor del planeta, desde
                la facultad de Oxford, Inglaterra, hasta la de Princenton, Nueva Jersey, Estados Unidos. Numerosos
                premios y años de investigación avalan nuestro éxito a nivel internacional.
            </p>
            <h3>Intereses</h3>
            <p> Este grupo de investigación destaca por su amplio campo de intereses, desde base de datos hasta la
                la computación a más alto nivel. Podríamos resumir los campos de investigación en la siguiente lista:
            </p>
            <ul>
                <li>Bases de datos</li>
                <li>Computación de altas prestaciones</li>
                <li>Paralelismo</li>
                <li>Computación distribuida</li>
                <li>Orientación a objetos</li>
                <li>Nuevos lenguajes de programación</li>
                <li>Desarrollo de nuevos sistemas hardware</li>
                <li>Sistemas empotrados</li>
                <li>Inteligencia artificial</li>
            </ul>
            <img src="img/html/innova.jpg" class="img-responsive adding-vertical-padding">
            <h3>Historia</h3>
            <p> Este grupo de investigación informática nace en 2007, a partir de dos jovenes estudiantes de la
                universidad de Granada, los cuales pasan a colaborar con las investigaciones de la UGR de manera
                retribuida. Sus éxitos desde el primer momento y su continua constancia, les llevo a constituirse
                empresa en 2010 y empezar a colaborar con otras universidades a nivel nacional.
            </p>
            <p> En 2011 y, tras 4 años desde la primera investigación realizada por el grupo, la empresa ya contaba con
                16 investigadores. Estos fueron los encargados de la primera investigación en conjunto con una
                universidad extranjera, concretamente con la universidad de Brno, República Checa. Su cometido no fue
                otro que un proyecto de inteligencia artificial aplicada a robots de ayuda doméstica.
            </p>
            <p> Su participación exitosa en esta investigación los catapultó a nivel internacional, de manera que
                comenzaron las colaboraciones internacionales con universidades del prestigio de Oxford (Inglaterra) o
                Princenton (Nueva Jersey, Estados Unidos).
            </p>
            <p> Actualmente, a pesar de la situación económica que vive el país, la empresa cuenta con 5 departamentos
                en función del campo de investigación. Estos lo forman un total de 121 investigadores de todo el mundo
                especializados en distintos campos del mundo de la informática.
            </p>
            
    ';
}

// Página de miembros
function displayUsers() {
    echo "<h1>USUARIOS</h1> <hr>";

    require_once 'php/db.php';
    $users = DB_execute('select * from `User` order by `surname` asc');

    if ($users) { // Si no hay error
        if (count($users) > 0) { // Si hay alguna tupla de respuesta

            for ($i = 0; $i < count($users); $i++) {
                $is_admin = ($users[$i]['admin'] == 1)? 'Sí':'No';
                $is_director = ($users[$i]['director'] == 1)? 'Sí':'No';

                // Solo se muestra qué usuario está bloqueado si el usuario logueado es administrador
                $blocked_if_admin_is_logged_in = '';
                if (isset($_SESSION['admin'])) {
                    $is_blocked = ($users[$i]['blocked'] == 1) ? 'Sí':'No';
                    $blocked_if_admin_is_logged_in = "<tr><td class='bold'>Bloqueado</td><td>$is_blocked</td></tr>";
                }

                echo <<< HTML
                
                <div class='row user'> 
                    <div class='col-xs-12 col-sm-12 col-md-4 col-lg-4'> 
                        <img src='{$users[$i]['photo']}' class='img-responsive' id='user-img'> 
                    </div>
            
                    <div class='col-xs-12 col-sm-12 col-md-8 col-lg-8' id='ficha'>
                        <table class='table table-hover table-condensed section-table'>
                            <tr>
                                <td class='bold'>Nombre</td>
                                <td>{$users[$i]['name']}</td>
                            </tr>
                            <tr>
                                <td class='bold'>Apellidos</td>
                                <td>{$users[$i]['surname']}</td>
                            </tr>
                            <tr>
                                <td class='bold'>Categoría</td>
                                <td>{$users[$i]['category']}</td>
                            </tr>
                            <tr>
                                <td class='bold'>Email</td>
                                <td><a href='mailto:{$users[$i]['email']}' target='_blank'>{$users[$i]['email']}</a></td>
                            </tr>
                            <tr>
                                <td class='bold'>Dirección Web</td>
                                <td><a href='{$users[$i]['url']}' target='_blank'>{$users[$i]['url']}</a></td>
                            </tr>
                            <tr>
                                <td class='bold'>Departamento</td>
                                <td>{$users[$i]['department']}</td>
                            </tr>
                            <tr>
                                <td class='bold'>Centro</td>
                                <td>{$users[$i]['center']}</td>
                            </tr>
                            <tr>
                                <td class='bold'>Universidad</td>
                                <td>{$users[$i]['university']}</td>
                            </tr>
                            <tr>
                                <td class='bold'>Dirección postal</td>
                                <td>{$users[$i]['address']}</td>
                            </tr>
                            <tr>
                                <td class='bold'>Administrador</td>
                                <td>$is_admin</td>
                            </tr>
                            <tr>
                                <td class='bold'>Director del grupo</td>
                                <td>$is_director</td>
                            </tr>
                            $blocked_if_admin_is_logged_in
                        </table>
                    </div>
                </div>

HTML;
            }
        }
    }

}

// Página de proyectos
function displayProjects() {
    echo "<h1>PROYECTOS</h1> <hr class='decrease-margin-bottom'>";

    require_once 'php/db.php';
    $projects = DB_execute('select * from `Project-Investigate` order by `ini-date` desc');

    if ($projects) { // Si no hay error
        if (count($projects) > 0) { // Si hay alguna tupla de respuesta

            for ($i = 0; $i < count($projects); $i++) {
                $ini_date = date("d/m/Y", strtotime($projects[$i]['ini-date']));
                $fin_date = date("d/m/Y", strtotime($projects[$i]['fin-date']));

                // Obtenemos el investigador principal (perteneciente al grupo o no)
                $main_invest = "";
                if ($projects[$i]['main-invest-email'] !== null and $projects[$i]['main-invest-email'] !== '' and $projects[$i]['main-invest-email'] != 'NULL'){
                    $res = DB_execute("select `name`,`surname` from `User` where `email`='{$projects[$i]['main-invest-email']}'");
                    if ($res !== false and count($res)>0) {
                        $main_invest .= $res[0]['name'] . " " . $res[0]['surname'];
                    }
                }
                else{
                    $main_invest = $projects[$i]['non-group-main-invest'];
                }


                // Obtenemos los investigadores colaboladores (pertenecientes al grupo o no)
                $group_collabs = DB_execute("select `collab-invest-email` from `Collaborate` where `project_cod`='{$projects[$i]['cod']}'");
                $collab_invests = "";
                for ($k=0; $k<count($group_collabs); $k++) {
                    $users = DB_execute("select `name`,`surname` from `User` where `email`='{$group_collabs[$k]['collab-invest-email']}'");
                    $collab_invests .= $users[0]['name'] . " " . $users[0]['surname'] . ", ";
                }
                if ($projects[$i]['non-group-collabs'] != 'NULL')
                    $collab_invests .= $projects[$i]['non-group-collabs'];
                removeFinalComma($collab_invests);

                // Obtenemos la publicaciones asociadas
                $pubs = DB_execute("select `title` from `Publication-Have` where `project_cod`='{$projects[$i]['cod']}'");
                $pub_rows = "<tr> <td class='bold'>Publicaciones asociadas</td> <td> <ul class='decrease-padding-left'>";
                for ($k=0; $k<count($pubs); $k++) {
                    $pub_rows .= "<li>{$pubs[$k]['title']}</li>";
                }
                $pub_rows .= "</ul> </td> </tr>";


                echo <<< HTML
                
                <div class="row post">
                    <h3>{$projects[$i]['title']}</h3>
                    <table class='table table-hover table-condensed section-table'>
                        <tr>
                            <td class='bold'>Código</td>
                            <td>{$projects[$i]['cod']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Descripción</td>
                            <td>{$projects[$i]['description']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Fecha de inicio</td>
                            <td>$ini_date</td>
                        </tr>
                        <tr>
                            <td class='bold'>Fecha de final</td>
                            <td>$fin_date</td>
                        </tr>
                        <tr>
                            <td class='bold'>Entidades colaboradoras</td>
                            <td>{$projects[$i]['associates']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Cuantía concedida</td>
                            <td>{$projects[$i]['amount']}€</td>
                        </tr>
                        <tr>
                            <td class='bold'>URL</td>
                            <td><a href="{$projects[$i]['url']}" target="_blank">{$projects[$i]['url']}</a></td>
                        </tr>
                        <tr>
                            <td class='bold'>Investigador principal</td>
                            <td>$main_invest</td>
                        </tr>
                        <tr>
                            <td class='bold'>Investigadores colaboradores</td>
                            <td>$collab_invests</td>
                        </tr>
HTML;
                echo $pub_rows . "</table> </div>";
            }
        }
    }



}

// Pagína de publicaciones
function displayPosts($search=false) {
    global $pub_subtypes;

    echo "<h1>PUBLICACIONES</h1> <hr class='decrease-margin-bottom'>";

    echo <<< HTML
    <div class="row search-posts">
        <form class="" action="index.php" method="get">
            <fieldset>
                <legend class="col-xs-12 col-sm-12 col-md-12 col-lg-12">Formulario de búsqueda</legend>
                <input type="hidden" name="p" value="searchpub">
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4" for="search-post-subtype">Tipo:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <select name="subtype" id="search-post-subtype" class="form-control">
                            <option value="Article">Artículo</option>
                            <option value="BookChapter">Capítulo de libro</option>
                            <option value="Conference">Conferencia</option>
                            <option value="Book">Libro</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4" for="search-post-author">Autor:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <input type="text" name="author" class="form-control" id="search-post-author" placeholder="Introduzca un autor">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4" for="search-post-date">Fecha:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <input type="date" name="date" id="search-post-date" class="form-control">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4" for="search-post-keywords">Palabras clave:</label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                        <input type="text" name="keywords" id="search-post-keywords" class="form-control" placeholder="Introduzca palabras clave">
                    </div>
                </div>
                <div class="form-group col-xs-12 col-sm-12 col-md-6 col-lg-6">        
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
HTML;

    require_once 'php/db.php';
    $query = "";
    $db = DB_connection();

    if (!$search)   // si no hay búsqueda
        $query = 'select * from `Publication-Have` order by `date` desc';
    else {          // si hay búsqueda, filtramos los resultados de la BBDD por todos los campos menos autores
        DB_escape($db, $_GET);

        $query = "select * from `Publication-Have` where `subtype`='{$_GET['subtype']}'"
            . (($_GET['date'] != "") ? " and `date`='{$_GET['date']}'" : "")
            . (($_GET['keywords'] != "") ? " and `keywords` like '%{$_GET['keywords']}%'" : "")
            . " order by `date` desc";
    }

    $posts = DB_query($db, $query, true);
    DB_disconnection($db);

    // si hubo búsqueda, filtramos los resultados según los autores
    if ($search and $_GET['author'] != '') {
        $results_to_remove = array();
        // Group all authors in just a var
        for ($x = 0; $x < count($posts); $x++) {
            $possible_authors = DB_execute("SELECT `User`.`name`, `User`.`surname` from `User`, `Edit`, `Publication-Have` 
                                              WHERE `Edit`.`pub-doi`=`Publication-Have`.`doi` and `User`.`email`=`Edit`.`author-email` 
                                              and `Edit`.`pub-doi`='{$posts[$x]['doi']}'");

            // buscamos el autor en los miembros del grupo
            $encontrado = false;
            if ($possible_authors !== false and count($possible_authors) > 0) {
                while (list($key, $val) = each($possible_authors) and !$encontrado)
                    if ( (strpos($val['name'], $_GET['author']) !== false) or (strpos($val['surname'], $_GET['author']) !== false))
                        $encontrado = true;

            }

            if ( (strpos($posts[$x]['non-group-authors'], $_GET['author']) !== false) and !$encontrado)
                $encontrado = true;

            if (!$encontrado)
                $results_to_remove[] = $x;

        }
        // Remove results that doesn't match with author from $_GET
        for ($y=0; $y<count($results_to_remove); $y++) {
            unset($posts[$results_to_remove[$y]]);
        }
        $posts = array_values($posts);
    }


    if ($posts !== false) { // Si no hay error
        if (count($posts) > 0) { // Si hay alguna tupla de respuesta

            for ($i = 0; $i < count($posts); $i++) {
                // Obtenemos los nombres de los autores
                $group_emails = DB_execute("select `author-email` from `Edit` where `pub-doi`='{$posts[$i]['doi']}'");
                $group_authors = array();
                for ($k=0; $k<count($group_emails); $k++){
                    $group_authors[] = DB_execute("select `name`, `surname` from `User` where `email`='{$group_emails[$k]['author-email']}'");
                }

                // Proyecto asociado
                $project = DB_execute("select `title` from `Project-Investigate` where `cod`='{$posts[$i]['project_cod']}'");

                $date = date("d/m/Y", strtotime($posts[$i]['date']));

                echo <<< HTML
                
                <div class='row post'>
                    <h3>{$posts[$i]['title']}</h3>
                    <table class='table table-hover table-condensed section-table'>
                        <tr>
                            <td class='bold'>DOI</td>
                            <td>{$posts[$i]['doi']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Fecha</td>
                            <td>$date</td>
                        </tr>
                        <tr>
                            <td class='bold'>Proyecto asociado</td>
                            <td>{$project[0]['title']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Abstract</td>
                            <td>{$posts[$i]['abstract']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Palabras clave</td>
                            <td>{$posts[$i]['keywords']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>URL</td>
                            <td><a href='{$posts[$i]['url']}' target='_blank'>{$posts[$i]['url']}</a></td>
                        </tr>
                        <tr>
                            <td class='bold'>Autores</td>
                            <td>
HTML;
                $authors = "";
                for ($k=0; $k<count($group_authors); $k++) {
                    $authors .= "{$group_authors[$k][0]['name']} {$group_authors[$k][0]['surname']}, ";
                }
                $authors .= $posts[$i]['non-group-authors'];
                removeFinalComma($authors);
                echo $authors;

                echo <<< HTML
                    
                        </td>
                        </tr>
                        <tr>
                            <td class='bold'>Tipo de publicación</td>
                            <td>{$pub_subtypes[$posts[$i]['subtype']]}</td>
                        </tr>
HTML;

                switch ($posts[$i]['subtype']){
                    case 'Article':
                        displayArticleData($posts[$i]['doi']);
                        break;
                    case 'Book':
                        displayBookData($posts[$i]['doi']);
                        break;
                    case 'BookChapter':
                        displayBookChapterData($posts[$i]['doi']);
                        break;
                    case 'Conference':
                        displayConferenceData($posts[$i]['doi']);
                        break;

                }

                echo "</table> </div>";
            }
        }
        else
            echo "<h4 class='text-center'>No se encontraron resultados con los parámetros establecidos.</h4>";
    }
    else {
        echo "<h4 class='text-center'>No se encontraron resultados con los parámetros establecidos.</h4>";
    }


}
function searchPosts() {
    displayPosts(true);
}
// Muestra la información adicional correspondiente a cada tipo de publicación
function displayArticleData ($doi) {
    $data = DB_execute("select * from `Article` where `doi`='$doi'");
    echo <<< HTML
    
                        <tr>
                            <td class='bold'>Revista</td>
                            <td>{$data[0]['journal']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Volumen</td>
                            <td>{$data[0]['volume']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Páginas</td>
                            <td>{$data[0]['pages']}</td>
                        </tr>
HTML;
}
function displayBookData ($doi) {
    $data = DB_execute("select * from `Book` where `doi`='$doi'");
    echo <<< HTML
    
                        <tr>
                            <td class='bold'>Editorial</td>
                            <td>{$data[0]['publisher']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Editor</td>
                            <td>{$data[0]['editors']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>ISBN</td>
                            <td>{$data[0]['isbn']}</td>
                        </tr>
HTML;
}
function displayBookChapterData ($doi) {
    $data = DB_execute("select * from `BookChapter` where `doi`='$doi'");
    echo <<< HTML
    
                        <tr>
                            <td class='bold'>Título</td>
                            <td>{$data[0]['book-title']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Editorial</td>
                            <td>{$data[0]['publisher']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Editor</td>
                            <td>{$data[0]['editors']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>ISBN</td>
                            <td>{$data[0]['isbn']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Páginas</td>
                            <td>{$data[0]['pages']}</td>
                        </tr>
HTML;
}
function displayConferenceData ($doi) {
    $data = DB_execute("select * from `Conference` where `doi`='$doi'");
    echo <<< HTML
    
                        <tr>
                            <td class='bold'>Nombre</td>
                            <td>{$data[0]['name']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Lugar</td>
                            <td>{$data[0]['place']}</td>
                        </tr>
                        <tr>
                            <td class='bold'>Reseña</td>
                            <td>{$data[0]['review']}</td>
                        </tr>

HTML;
}

///
/// SECCIONES
//////////////////////////////////////////////////////



//////////////////////////////////////////////////////
/// INVESTIGACIÓN
///

// Muestra el formulario para añadir proyectos
function displayAddingProject() {
    echo <<< HTML

<h1>Nuevo proyecto</h1>
<hr>

<div class="row">
    <form class="form-horizontal" action="index.php?p=add_project" method="post" name="project" onsubmit="return validateProject()">
        <input type="hidden" name="store" value="yes">
        <div class="form-group">
            <label class="control-label col-sm-2" for="cod">Código</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="cod" placeholder="Introduce código" name="cod" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="title">Título</label>
            <div class="col-sm-10">          
                <input type="text" class="form-control" id="title" placeholder="Introduce título" name="title" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="description">Descripción</label>
            <div class="col-sm-10">          
                <textarea class="form-control" id="description" placeholder="Introduce una descripción" name="description"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="ini-date">Fecha de inicio</label>
            <div class="col-sm-10">          
                <input type="date" class="form-control" id="ini-date" name="ini-date" required>
            </div>
        </div>        
        <div class="form-group">
            <label class="control-label col-sm-2" for="fin-date">Fecha de final</label>
            <div class="col-sm-10">          
                <input type="date" class="form-control" id="fin-date" name="fin-date" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="associates">Entidades colaboradoras</label>
            <div class="col-sm-10">          
                <input type="text" class="form-control" id="associates" placeholder="Introduce entidades separadas por comas" name="associates">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="amount">Cuantía concedida (&euro;)</label>
            <div class="col-sm-10">          
                <input type="number" class="form-control" id="amount" placeholder="Introduce una cantidad en euros" name="amount">
            </div>
        </div>        
        <div class="form-group">
            <label class="control-label col-sm-2" for="url">Web</label>
            <div class="col-sm-10">          
                <input type="url" class="form-control" id="url" placeholder="Introduce una web" name="url">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="main-invest">Investigador principal</label>
            <div class="col-sm-10">          
                <input type="text" class="form-control" id="main-invest" placeholder="Apellidos, Nombre" name="main-invest" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="collab-invests">Investigadores colaboradores</label>
            <div class="col-sm-10">          
                <textarea class="form-control" id="collab-invests" placeholder="Apellido1, Nombre1; Apellido2, Nombre2..." name="collab-invests"></textarea>
            </div>
        </div>
        <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success">Añadir</button>
            </div>
        </div>
    </form>

</div> 
HTML;

}
// Guarda el proyecto en la BBDD
function storeProject () {
    require_once 'php/db.php';
    $db = DB_connection();
    DB_escape($db, $_POST);     // mysqli_real_escape_string
    $checking_project_cod = DB_query($db,"select `cod` from `Project-Investigate` where `cod`='{$_POST['cod']}'", true);
    DB_disconnection($db);

    $non_group_main_invest = "NULL";
    $main_invest_email = 'NULL';
    if ($checking_project_cod !== false and count($checking_project_cod)==0){

        // Getting main investigator
        if ( isset( $_POST['main-invest'] ) and strlen( $_POST['main-invest'] ) > 0 ) {
            $main_invest = explode(",", $_POST['main-invest']);
            for ($i = 0; $i < count($main_invest); $i++)
                $main_invest[$i] = trim($main_invest[$i]);
            $checking_main_invest = DB_execute("select `email` from `User` where `name`='{$main_invest[1]}' and `surname`='$main_invest[0]'");
            if ($checking_main_invest !== false and count($checking_main_invest) > 0){
                $main_invest_email = "'{$checking_main_invest[0]['email']}'";
            }
            else{
                $non_group_main_invest = "'" . $main_invest[1] . " " . $main_invest[0] . "'";
            }
        }

        // Getting research collaborators
        $non_group_collab_invests = "NULL";
        $collab_invests_email = array();
        if ( isset( $_POST['collab-invests'] ) and strlen( $_POST['collab-invests'] ) > 0 ) {
            $collab_invests = explode(";", $_POST['collab-invests']);
            foreach ($collab_invests as $i) {
                if ($i != '') {
                    $invest = explode(",", $i);
                    for ($k = 0; $k < count($invest); $k++)
                        $invest[$k] = trim($invest[$k]);
                    $checking_collab_invest = DB_execute("select `email` from `User` where `name`='{$invest[1]}' and `surname`='$invest[0]'");
                    if ($checking_collab_invest !== false and count($checking_collab_invest) > 0) {       // If collaborator is in the group
                        $collab_invests_email[] = $checking_collab_invest[0]['email'];
                    } else {                              // If collaborator isn't in the group
                        if ($non_group_collab_invests == "NULL") {      // First collaborator that isn't in group
                            $non_group_collab_invests = $invest[1] . " " . $invest[0] . ", ";
                        } else {                                          // Anyone else
                            $non_group_collab_invests .= $invest[1] . " " . $invest[0] . ", ";
                        }
                    }
                }
            }

            removeFinalComma($non_group_collab_invests);
            if ($non_group_collab_invests != 'NULL')
                $non_group_collab_invests = "'$non_group_collab_invests'";
        }

        $query_project = "insert into `Project-Investigate`(`cod`, `title`, `description`, `ini-date`, `fin-date`, 
                         `associates`, `amount`, `url`, `non-group-main-invest`, `non-group-collabs`, `main-invest-email`) 
                         values ('{$_POST['cod']}', '{$_POST['title']}', '{$_POST['description']}', '{$_POST['ini-date']}',
                         '{$_POST['fin-date']}', '{$_POST['associates']}', '{$_POST['amount']}', '{$_POST['url']}',
                         $non_group_main_invest,  $non_group_collab_invests, $main_invest_email)";

        $result = DB_execute($query_project, false);

        if (count($collab_invests_email) > 0){
            foreach ($collab_invests_email as $collab){
                $checking_collab_email = DB_execute("select * from `Collaborate` where `collab-invest-email`='$collab'and `project_cod`='{$_POST['cod']}'");
                if ($checking_collab_email !== false and count($checking_collab_email)==0) {
                    $query_collab = "INSERT INTO `Collaborate` (`collab-invest-email`, `project_cod`) VALUES ('$collab','{$_POST['cod']}')";
                    $result = $result and DB_execute($query_collab, false);
                }
            }
        }

        if ($result !== false){
            echo "<h1>Nuevo proyecto</h1> <hr> <p>Proyecto almacenado correctamente.</p>";
            writeLog("Se ha registrado el proyecto \"{$_POST['title']}\" ({$_POST['cod']}).");
        }
        else {
            echo "<h1>Nuevo proyecto</h1> <hr> <p>Error: no se pudo almacenar el proyecto.</p>";
        }

    }
    else {
        echo "<h1>Nuevo proyecto</h1> <hr> <p>Error: ya existe un proyecto con el mismo código.</p>";
    }
}

// Muestra el formulario para la edición de proyectos
function displayEditingProject($form = false) {

    if (!$form) {   // Seleccionar proyecto
        require_once 'php/db.php';
        $projects = DB_execute("select * from `Project-Investigate`");


        echo <<< HTML

        <h1>Modificar proyecto</h1>
        <hr>
        
        <div class="row">
            <form class="form-horizontal" action="index.php?p=edit_project" method="post">
                <input type="hidden" name="edit" value="no">
                <div class="form-group">
                    <label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="tomodify">Proyecto a modificar:</label>
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <select name="cod" id="tomodify" class="form-control" required>
HTML;

        if ($projects !== false and count($projects) > 0) {
            foreach ($projects as $p) {
                $text = $p['title'] . " (" . $p['cod'] . ")";
                echo "<option value='{$p['cod']}'>$text</option>";
            }
        } else {
            echo "<option value='none'>No hay proyectos creados</option>";
        }

        echo <<< HTML
                        </select>
                    </div>
                </div>
                <div class="form-group">        
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </div>
                </div>
            </form>
        </div>
HTML;

    }
    else {          // Formulario de modificación de proyectos
        if ($_POST['cod'] != 'none') {
            echo <<< HTML

            <h1>Modificar proyecto</h1>
            <hr>
            
            <div class="row">
                <form class="form-horizontal" action="index.php?p=edit_project" method="post">
                    <input type="hidden" name="edit" value="yes">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cod">Código</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="cod" placeholder="Introduce código" name="cod" value="{$_POST['cod']}" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Título</label>
                        <div class="col-sm-10">          
                            <input type="text" class="form-control" id="title" placeholder="Introduce título" name="title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="description">Descripción</label>
                        <div class="col-sm-10">          
                            <textarea class="form-control" id="description" placeholder="Introduce una descripción" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="ini-date">Fecha de inicio</label>
                        <div class="col-sm-10">          
                            <input type="date" class="form-control" id="ini-date" name="ini-date" required>
                        </div>
                    </div>        
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="fin-date">Fecha de final</label>
                        <div class="col-sm-10">          
                            <input type="date" class="form-control" id="fin-date" name="fin-date" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="associates">Entidades colaboradoras</label>
                        <div class="col-sm-10">          
                            <input type="text" class="form-control" id="associates" placeholder="Introduce entidades separadas por comas" name="associates">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="amount">Cuantía concedida (&euro;)</label>
                        <div class="col-sm-10">          
                            <input type="number" class="form-control" id="amount" placeholder="Introduce una cantidad en euros" name="amount">
                        </div>
                    </div>        
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="url">Web</label>
                        <div class="col-sm-10">          
                            <input type="url" class="form-control" id="url" placeholder="Introduce una web" name="url">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="main-invest">Investigador principal</label>
                        <div class="col-sm-10">          
                            <input type="text" class="form-control" id="main-invest" placeholder="Apellidos, Nombre" name="main-invest" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="collab-invests">Investigadores colaboradores</label>
                        <div class="col-sm-10">          
                            <textarea class="form-control" id="collab-invests" placeholder="Apellido1, Nombre1; Apellido2, Nombre2..." name="collab-invests"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Modificar</button>
                        </div>
                    </div>
                </form>
            
            </div> 
HTML;

        }
        else{
            echo "<h1>Modificar proyecto</h1> <hr> <p>Error: no se ha seleccionado ningún proyecto.</p>";
        }
    }

}
// Modifica el proyecto en la BBDD
function editProject() {
    require_once 'php/db.php';

    $db = DB_connection();
    DB_escape($db, $_POST);

    $non_group_main_invest = "NULL";
    $main_invest_email = "NULL";
    // Getting main investigator
    if ( isset( $_POST['main-invest'] ) and strlen( $_POST['main-invest'] ) > 0 ) {
        $main_invest = explode(",", $_POST['main-invest']);
        for ($i = 0; $i < count($main_invest); $i++)
            $main_invest[$i] = trim($main_invest[$i]);
        $checking_main_invest = DB_query($db,"select `email` from `User` where `name`='{$main_invest[1]}' and `surname`='$main_invest[0]'",true);
        if ($checking_main_invest !== false and count($checking_main_invest) > 0){
            $main_invest_email = "'{$checking_main_invest[0]['email']}'";
        }
        else{
            $non_group_main_invest = "'" . $main_invest[1] . " " . $main_invest[0] . "'";
        }
    }

    $non_group_collab_invests = "NULL";
    $collab_invests_email = array();
    // Getting research collaborators
    if ( isset( $_POST['collab-invests'] ) and strlen( $_POST['collab-invests'] ) > 0 ) {
        $collab_invests = explode(";", $_POST['collab-invests']);
        foreach ($collab_invests as $i) {
            if ($i != '') {
                $invest = explode(",", $i);
                for ($i = 0; $i < count($invest); $i++)
                    $invest[$i] = trim($invest[$i]);
                $checking_collab_invest = DB_query($db,"select `email` from `User` where `name`='{$invest[1]}' and `surname`='$invest[0]'", true);
                if ($checking_collab_invest !== false and count($checking_collab_invest) > 0) {       // If collaborator is in the group
                    $collab_invests_email[] = $checking_collab_invest[0]['email'];
                } else {                              // If collaborator isn't in the group
                    if ($non_group_collab_invests == "NULL") {      // First collaborator that isn't in group
                        $non_group_collab_invests = $invest[1] . " " . $invest[0] . ", ";
                    } else {                                          // Anyone else
                        $non_group_collab_invests .= $invest[1] . " " . $invest[0] . ", ";
                    }
                }
            }
        }

        removeFinalComma($non_group_collab_invests);
        if ($non_group_collab_invests != 'NULL')
            $non_group_collab_invests = "'$non_group_collab_invests'";
    }

    $query_project = "update `Project-Investigate` set `title`='{$_POST['title']}', `description`='{$_POST['description']}', 
                      `ini-date`='{$_POST['ini-date']}', `fin-date`='{$_POST['fin-date']}', `associates`='{$_POST['associates']}', 
                      `amount`='{$_POST['amount']}', `url`='{$_POST['url']}', `non-group-main-invest`=$non_group_main_invest, 
                      `non-group-collabs`=$non_group_collab_invests, `main-invest-email`=$main_invest_email where `cod`='{$_POST['cod']}'";

    $result = DB_query($db,$query_project, false);

    // Es necesario borrar las entradas de la tabla Collaborate porque ambos registros (código del proyecto, email del
    // investigador) son claves primarias. Además, consiste en la solución más lógica dado el diseño de la BBDD.
    $deleting = DB_query($db,"delete from `Collaborate` where `project_cod`='{$_POST['cod']}'", false);
    if ($deleting !== false) {
        if (count($collab_invests_email) > 0) {
            foreach ($collab_invests_email as $collab) {
                $checking_collab_email = DB_query($db,"select * from `Collaborate` where `collab-invest-email`='$collab'and `project_cod`='{$_POST['cod']}'", true);
                if ($checking_collab_email !== false and count($checking_collab_email) == 0) {
                    $query_collab = "INSERT INTO `Collaborate` (`collab-invest-email`, `project_cod`) VALUES ('$collab','{$_POST['cod']}')";
                    $result = $result and DB_query($db, $query_collab, false);
                }
            }
        }
    }

    DB_disconnection($db);

    if ($result !== false){
        echo "<h1>Modificar proyecto</h1> <hr> <p>Proyecto modificado correctamente.</p>";
        writeLog("Se ha modificado el proyecto \"{$_POST['title']}\" ({$_POST['cod']}).");
    }
    else {
        echo "<h1>Modificar proyecto</h1> <hr> <p>Error: no se pudo modificar el proyecto.</p>";
    }

}

// Muestra el formulario para el borrado de proyectos
function displayRemovingProject() {
    require_once 'php/db.php';
    $projects = DB_execute("select * from `Project-Investigate`");


    echo <<< HTML

    <h1>Borrar proyecto</h1>
    <hr>
    
    <div class="row">
        <form class="form-horizontal" action="index.php?p=remove_project" method="post">
            <input type="hidden" name="remove" value="yes">
            <div class="form-group">
                <label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="toremove">Proyecto a eliminar:</label>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <select name="cod" id="toremove" class="form-control" required>
HTML;
    if ($projects !== false and count($projects)>0) {
        foreach ($projects as $p) {
            $text = $p['title'] . " (" . $p['cod'] . ")";
            echo "<option value='{$p['cod']}'>$text</option>";
        }
    }
    else {
        echo "<option value='none'>No hay proyectos creados</option>";
    }

    echo <<< HTML
                    </select>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </div>
            </div>
        </form>
    </div>
HTML;

}
// Borra el proyecto de la BBDD
function removeProject() {
    if ($_POST['cod'] != 'none') {
        require_once 'php/db.php';

        $data = DB_execute("select `cod`,`title` from `Project-Investigate` WHERE `cod`='{$_POST['cod']}'");
        $result = DB_execute("delete from `Project-Investigate` where `cod`='{$_POST['cod']}'", false);

        if ($result !== false) {
            echo "<h1>Borrar proyecto</h1> <hr> <p>Proyecto borrado correctamente.</p>";
            writeLog("Se ha eliminado el proyecto \"{$data[0]['title']}\" ({$data[0]['cod']}).");
        } else {
            echo "<h1>Borrar proyecto</h1> <hr> <p>Error: no se pudo borrar el proyecto seleccionado.</p>";
        }
    }
    else{
        echo "<h1>Borrar proyecto</h1> <hr> <p>Error: No se ha seleccionado ningún proyecto.</p>";
    }
}

//////////////////////////////////////////////////////

// Muestra el formulario para añadir publicaciones
function displayAddingPost() {
    require_once 'php/db.php';
    $result = DB_execute("select `cod`,`title` from `Project-Investigate`");

    // Obtenemos los proyectos disponibles
    $project_codes = "";
    foreach ($result as $r){
        $project_codes .= "<option value='{$r['cod']}'>{$r['title']} ({$r['cod']})</option>\n";
    }

    echo <<< HTML

<h1>Nueva publicación</h1>
<hr>

<div class="row">
    <form class="form-horizontal" action="index.php?p=add_post" method="post">
        <input type="hidden" name="store" value="yes">
        <div class="form-group">
            <label class="control-label col-sm-2" for="cod">DOI</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="doi" placeholder="Introduce DOI" name="doi" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="title">Título</label>
            <div class="col-sm-10">          
                <input type="text" class="form-control" id="title" placeholder="Introduce título" name="title" required>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="date">Fecha de publicación</label>
            <div class="col-sm-10">          
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
        </div>     
        <div class="form-group">
            <label class="control-label col-sm-2" for="project_cod">Proyecto asociado</label>
            <div class="col-sm-10">          
                <select class="form-control" id="project_cod" name="project_cod" required>
                    $project_codes
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="abstract">Abstract</label>
            <div class="col-sm-10">          
                <textarea class="form-control" id="abstract" placeholder="Introduce un abstract" name="abstract"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="keywords">Keywords</label>
            <div class="col-sm-10">          
                <input type="text" class="form-control" id="keywords" placeholder="Introduce keywords separadas por comas" name="keywords">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="url">Web</label>
            <div class="col-sm-10">          
                <input type="url" class="form-control" id="url" placeholder="Introduce una web" name="url" required>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="authors">Autores</label>
            <div class="col-sm-10">          
                <textarea class="form-control" id="authors" placeholder="Apellido1, Nombre1; Apellido2, Nombre2..." name="authors" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="subtype">Tipo de publicación</label>
            <div class="col-sm-10">          
                <select class="form-control" id="subtype" name="subtype" onchange="showSubtypeInputs(this.value)" required>
                    <option value="">Elige una opción</option>
                    <option value="Article">Artículo</option>
                    <option value="BookChapter">Capítulo de libro</option>
                    <option value="Conference">Conferencia</option>
                    <option value="Book">Libro</option>
                </select>
            </div>
        </div>
        <div id="ajax"></div>
        
        <!-- AJAX -->
        <!-- Se muestran distintos inputs según el tipo de publicación escogida en el select anterior -->
        <script>
            function showSubtypeInputs(choice) {
                var xhttp;
                if (choice == "") {
                    document.getElementById("ajax").innerHTML = "";
                    return;
                }
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("ajax").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "html/" + choice + ".html", true);
                xhttp.send();
            }
        </script>
        <!-- AJAX -->

        <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success">Añadir</button>
            </div>
        </div>
    </form>

</div> 
HTML;

}
// Guarda la publicación en la BBDD
function storePost () {
    require_once 'php/db.php';
    $db = DB_connection();
    DB_escape($db,$_POST);

    $checking_pub_doi = DB_query($db,"select `doi` from `Publication-Have` where `doi`='{$_POST['doi']}'", true);

    $non_group_authors = "NULL";
    $author_email = array();
    if ($checking_pub_doi !== false and count($checking_pub_doi)==0){
        if ( isset( $_POST['authors'] ) and strlen( $_POST['authors'] ) > 0 ) {     // Getting authors
            $author_list = explode(";", $_POST['authors']);
            foreach ($author_list as $a) {
                if ($a != '') {
                    $author = explode(",", $a);
                    for ($i = 0; $i < count($author); $i++)
                        $author[$i] = trim($author[$i]);
                    $checking_author = DB_query($db,"select `email` from `User` where `name`='{$author[1]}' and `surname`='$author[0]'");
                    if ($checking_author !== false and count($checking_author) > 0) {       // If author is in the group
                        $author_email[] = $checking_author[0]['email'];
                    } else {                              // If author isn't in the group
                        if ($non_group_authors == "NULL") {      // First author that isn't in group
                            $non_group_authors = $author[1] . " " . $author[0] . ", ";
                        } else {                                          // Anyone else
                            $non_group_authors .= $author[1] . " " . $author[0] . ", ";
                        }
                    }
                }
            }

            removeFinalComma($non_group_authors);
            $non_group_authors = "'$non_group_authors'";
        }

        $query_pub = "insert into `Publication-Have`(`doi`, `title`, `date`, `project_cod`, `abstract`, 
                          `keywords`, `url`, `non-group-authors`, `subtype`) values ('{$_POST['doi']}', '{$_POST['title']}', 
                          '{$_POST['date']}','{$_POST['project_cod']}' ,'{$_POST['abstract']}', '{$_POST['keywords']}', 
                          '{$_POST['url']}', $non_group_authors, '{$_POST['subtype']}')";

        $result = DB_query($db, $query_pub, false);

        if (count($author_email) > 0){
            foreach ($author_email as $author){
                $checking_author_email = DB_query($db,"select * from `Edit` where `author-email`='$author'and `pub-doi`='{$_POST['doi']}'");
                if ($checking_author_email !== false and count($checking_author_email)==0) {
                    $query_author = "INSERT INTO `Edit` (`author-email`, `pub-doi`) VALUES ('$author','{$_POST['doi']}')";
                    $result = $result and DB_query($db, $query_author, false);
                }
            }
        }

        switch ($_POST['subtype']){
            case 'Article':
                $result = $result and DB_query($db, "INSERT INTO `Article` (`doi`, `journal`, `volume`, `pages`) VALUES 
                                                        ('{$_POST['doi']}', '{$_POST['journal']}', '{$_POST['volume']}', 
                                                        '{$_POST['pages']}')", false);
                break;
            case 'Book':
                $result = $result and DB_query($db, "INSERT INTO `Book` (`doi`, `publisher`, `editors`, `isbn`) 
                                                        VALUES ('{$_POST['doi']}', '{$_POST['publisher']}', '{$_POST['editors']}',
                                                        '{$_POST['isbn']}')", false);
                break;
            case 'BookChapter':
                $result = $result and DB_query($db, "INSERT INTO `BookChapter` (`doi`, `book-title`, `publisher`, `editors`, 
                                                        `isbn`, `pages`) VALUES ('{$_POST['doi']}', '{$_POST['book-title']}', 
                                                        '{$_POST['publisher']}', '{$_POST['editors']}', '{$_POST['isbn']}', 
                                                        '{$_POST['pages']}')", false);
                break;
            case 'Conference':
                $result = $result and DB_query($db, "INSERT INTO `Conference` (`doi`, `name`, `place`, `review`) VALUES (
                                                        '{$_POST['doi']}', '{$_POST['name']}', '{$_POST['place']}', 
                                                        '{$_POST['review']}')", false);
                break;
        }

        DB_disconnection($db);

        if ($result !== false){
            echo "<h1>Nueva publicación</h1> <hr> <p>Publicación almacenada correctamente.</p>";
            writeLog("Se ha registrado la publicación \"{$_POST['title']}\" ({$_POST['doi']}).");
        }
        else {
            echo "<h1>Nueva publicación</h1> <hr> <p>Error: no se pudo almacenar la publicación.</p>";
        }

    }
    else {
        echo "<h1>Nueva publicación</h1> <hr> <p>Error: ya existe una publicación con el mismo DOI.</p>";
    }
}

// Muestra el formulario para editar publicaciones
function displayEditingPost($form = false) {
    global $pub_subtypes;

    if (!$form) {       // si no se ha seleccionado ninguna publicación
        require_once 'php/db.php';
        $posts = DB_execute("select * from `Publication-Have`");

        echo <<< HTML

    <h1>Modificar publicación</h1>
    <hr>
    
    <div class="row">
        <form class="form-horizontal" action="index.php?p=edit_post" method="post">
            <input type="hidden" name="edit" value="no">
            <div class="form-group">
                <label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="toremove">Publicación a modificar:</label>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <select name="doi" id="toremove" class="form-control" required>
HTML;
        if ($posts !== false and count($posts)>0) {
            foreach ($posts as $p) {
                $text = $p['title'] . " (" . $p['doi'] . ")";
                echo "<option value='{$p['doi']}'>$text</option>";
            }
        }
        else {
            echo "<option value='none'>No hay publicaciones creadas</option>";
        }

        echo <<< HTML
                    </select>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
            </div>
        </form>
    </div>
HTML;

    }
    else {      // se muestra el formulario para la modificación de publicaciones
        if ($_POST['doi'] != 'none') {
            require_once 'php/db.php';
            $result = DB_execute("select `cod`,`title` from `Project-Investigate`");
            $subtype = DB_execute("select `subtype` from `Publication-Have` where `doi`='{$_POST['doi']}'");

            $project_codes = "";
            foreach ($result as $r) {
                $project_codes .= "<option value='{$r['cod']}'>{$r['title']} ({$r['cod']})</option>\n";
            }

            $publication_subtype = "";
            foreach ($pub_subtypes as $english => $spanish){
                $publication_subtype .= "<option value='$english' " . (($subtype[0]['subtype'] == $english)?  "selected" : "") . ">$spanish</option>\n";
            }

            echo <<< HTML
    
            <h1>Modificar publicación</h1>
            <hr>
            
            <div class="row">
                <form class="form-horizontal" action="index.php?p=edit_post" method="post">
                    <input type="hidden" name="edit" value="yes">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cod">DOI</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="doi" placeholder="Introduce DOI" name="doi" value="{$_POST['doi']}" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="title">Título</label>
                        <div class="col-sm-10">          
                            <input type="text" class="form-control" id="title" placeholder="Introduce título" name="title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="date">Fecha de publicación</label>
                        <div class="col-sm-10">          
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                    </div>     
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="project_cod">Proyecto asociado</label>
                        <div class="col-sm-10">          
                            <select class="form-control" id="project_cod" name="project_cod" required>
                                $project_codes
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="abstract">Abstract</label>
                        <div class="col-sm-10">          
                            <textarea class="form-control" id="abstract" placeholder="Introduce un abstract" name="abstract"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="keywords">Keywords</label>
                        <div class="col-sm-10">          
                            <input type="text" class="form-control" id="keywords" placeholder="Introduce keywords separadas por comas" name="keywords">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="url">Web</label>
                        <div class="col-sm-10">          
                            <input type="url" class="form-control" id="url" placeholder="Introduce una web" name="url" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="authors">Autores</label>
                        <div class="col-sm-10">          
                            <textarea class="form-control" id="authors" placeholder="Apellido1, Nombre1; Apellido2, Nombre2..." name="authors" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="subtype">Tipo de publicación</label>
                        <div class="col-sm-10">          
                            <select class="form-control" id="subtype" name="subtype" onchange="showSubtypeInputs(this.value)" required disabled>
                                <option value="">Elige una opción</option>
                                $publication_subtype
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="subtype" value="{$subtype[0]['subtype']}">
HTML;

            require_once 'html/' . $subtype[0]['subtype'] . '.html';

            echo <<< HTML
                    <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Modificar</button>
                        </div>
                    </div>
                </form>
            
            </div> 
HTML;
        }
        else{
            echo "<h1>Modificar publicación</h1> <hr> <p>Error: no se ha seleccionado ninguna publicación.</p>";
        }
    }

}
// Modifica la publicación en la BBDD
function editPost() {
    require_once 'php/db.php';

    $db = DB_connection();
    DB_escape($db, $_POST);

    $non_group_authors = "NULL";
    $author_email = array();
    if ( isset( $_POST['authors'] ) and strlen( $_POST['authors'] ) > 0 ) {     // Getting authors
        $author_list = explode(";", $_POST['authors']);
        foreach ($author_list as $a) {
            if ($a != '') {
                $author = explode(",", $a);
                for ($i = 0; $i < count($author); $i++)
                    $author[$i] = trim($author[$i]);
                $checking_author = DB_query($db,"select `email` from `User` where `name`='{$author[1]}' and `surname`='$author[0]'");
                if ($checking_author !== false and count($checking_author) > 0) {       // If author is in the group
                    $author_email[] = $checking_author[0]['email'];
                } else {                              // If author isn't in the group
                    if ($non_group_authors == "NULL") {      // First author that isn't in group
                        $non_group_authors = $author[1] . " " . $author[0] . ", ";
                    } else {                                          // Anyone else
                        $non_group_authors .= $author[1] . " " . $author[0] . ", ";
                    }
                }
            }
        }

        removeFinalComma($non_group_authors);
        $non_group_authors = "'$non_group_authors'";
    }

    $query_pub = "update `Publication-Have` set `title`='{$_POST['title']}', `date`='{$_POST['date']}', `project_cod`='{$_POST['project_cod']}', 
                  `abstract`='{$_POST['abstract']}', `keywords`='{$_POST['keywords']}', `url`='{$_POST['url']}', 
                  `non-group-authors`=$non_group_authors, `subtype`='{$_POST['subtype']}' where `doi`='{$_POST['doi']}'";

    $result = DB_query($db,$query_pub, false);

    // Es necesario borrar las entradas de la tabla Edit porque ambos registros (doi, email del
    // autor) son claves primarias. Además, consiste en la solución más lógica dado el diseño de la BBDD.
    $deleting_edit = DB_query($db, "delete from `Edit` where `pub-doi`='{$_POST['doi']}'", false);
    if ($deleting_edit !== false) {
        if (count($author_email) > 0) {
            foreach ($author_email as $author) {
                $checking_author_email = DB_query($db, "select * from `Edit` where `author-email`='$author'and `pub-doi`='{$_POST['doi']}'");
                if ($checking_author_email !== false and count($checking_author_email) == 0) {
                    $query_author = "INSERT INTO `Edit` (`author-email`, `pub-doi`) VALUES ('$author','{$_POST['doi']}')";
                    $result = $result and DB_query($db, $query_author, false);
                }
            }
        }
    }

    switch ($_POST['subtype']){
        case 'Article':
            $result = $result and DB_query($db, "update `Article` set `journal`='{$_POST['journal']}', `volume`='{$_POST['volume']}', 
                                                    `pages`='{$_POST['pages']}' where `doi`='{$_POST['doi']}'", false);
            break;
        case 'Book':
            $result = $result and DB_query($db, "update `Book` set `publisher`='{$_POST['publisher']}', `editors`='{$_POST['editors']}', 
                                                    `isbn`='{$_POST['isbn']}' where `doi`='{$_POST['doi']}'", false);
            break;
        case 'BookChapter':
            $result = $result and DB_query($db, "update `BookChapter` set `book-title`='{$_POST['book-title']}', `publisher`='{$_POST['publisher']}', 
                                                    `editors`='{$_POST['editors']}', `isbn`='{$_POST['isbn']}', `pages`='{$_POST['pages']}') 
                                                    where `doi`='{$_POST['doi']}'", false);
            break;
        case 'Conference':
            $result = $result and DB_query($db, "update `Conference` set `name`='{$_POST['name']}', `place`='{$_POST['place']}', 
                                                    `review`='{$_POST['review']}' where `doi`='{$_POST['doi']}'", false);
            break;
    }

    DB_disconnection($db);

    if ($result !== false){
        echo "<h1>Modificar publicación</h1> <hr> <p>Publicación modificada correctamente.</p>";
        writeLog("Se ha modificado la publicación \"{$_POST['title']}\" ({$_POST['doi']}).");

    }
    else {
        echo "<h1>Modificar publicación</h1> <hr> <p>Error: no se pudo modificar la publicación.</p>";
    }

}

// Muestra el formulario para borrar publicaciones
function displayRemovingPost() {
    require_once 'php/db.php';
    $posts = DB_execute("select * from `Publication-Have`", true);

    echo <<< HTML

    <h1>Borrar publicación</h1>
    <hr>
    
    <div class="row">
        <form class="form-horizontal" action="index.php?p=remove_post" method="post">
            <input type="hidden" name="remove" value="yes">
            <div class="form-group">
                <label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="toremove">Publicación a eliminar:</label>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <select name="doi" id="toremove" class="form-control" required>
HTML;
    if ($posts !== false and count($posts)>0) {
        foreach ($posts as $p) {
            $text = $p['title'] . " (" . $p['doi'] . ")";
            echo "<option value='{$p['doi']}'>$text</option>";
        }
    }
    else {
        echo "<option value='none'>No hay publicaciones creadas</option>";
    }

    echo <<< HTML
                    </select>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </div>
            </div>
        </form>
    </div>
HTML;

}
// Borra la publicación de la BBDD
function removePost () {
    if ($_POST['doi'] != 'none') {
        require_once 'php/db.php';

        $data = DB_execute("select `doi`, `title` from `Publication-Have` where `doi`='{$_POST['doi']}'");
        $result = DB_execute("delete from `Publication-Have` where `doi`='{$_POST['doi']}'", false);

        if ($result !== false) {
            echo "<h1>Borrar publicación</h1> <hr> <p>Publicación borrada correctamente.</p>";
            writeLog("Se ha eliminado la publicación \"{$data[0]['title']}\" ({$data[0]['doi']}).");
        } else {
            echo "<h1>Borrar publicación</h1> <hr> <p>Error: no se pudo borrar la publicación seleccionada.</p>";
        }
    }
    else{
        echo "<h1>Borrar publicación</h1> <hr> <p>Error: no se ha seleccionado ninguna publicación.</p>";
    }
}

///
/// INVESTIGACIÓN
//////////////////////////////////////////////////////



//////////////////////////////////////////////////////
/// ADMINISTRACIÓN
///

// Muestra el formulario para añadir usuarios
function displayAddingUser() {
    echo <<< HTML

    <h1>Nuevo usuario</h1>
    <hr>
    
    <div class="row">
        <form class="form-horizontal" action="index.php?p=add_user" method="post" enctype="multipart/form-data" name="user" onsubmit="return validateUser()">
            <input type="hidden" name="store" value="yes">
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Nombre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" placeholder="Introduce nombre" name="name" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="title">Apellidos</label>
                <div class="col-sm-10">          
                    <input type="text" class="form-control" id="surname" placeholder="Introduce apellidos" name="surname" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="category">Categoría</label>
                <div class="col-sm-10">          
                    <input type="text" class="form-control" id="category" placeholder="Catedrático, profesor titular, etc." name="category" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email</label>
                <div class="col-sm-10">          
                    <input type="email" class="form-control" id="email" placeholder="user@innotechmon.com" name="email" onsubmit="validateEmail()" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pass">Contraseña</label>
                <div class="col-sm-10">          
                    <input type="password" class="form-control" id="pass" placeholder="Introduce una contraseña" name="pass" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="phone">Teléfono</label>
                <div class="col-sm-10">          
                    <input type="tel" class="form-control" id="phone" placeholder="Introduce un nº teléfono" name="phone" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="url">Web</label>
                <div class="col-sm-10">          
                    <input type="url" class="form-control" id="url" placeholder="Introduce una web" name="url" required>
                </div>
            </div>        
            <div class="form-group">
                <label class="control-label col-sm-2" for="department">Departamento</label>
                <div class="col-sm-10">          
                    <input type="text" class="form-control" id="department" placeholder="Introduce un departamento" name="department" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="center">Centro</label>
                <div class="col-sm-10">          
                    <input type="text" class="form-control" id="center" placeholder="Introduce un centro" name="center" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="university">Universidad</label>
                <div class="col-sm-10">          
                    <input type="text" class="form-control" id="university" placeholder="Introduce una universidad" name="university" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Dirección postal</label>
                <div class="col-sm-10">          
                    <input type="text" class="form-control" id="address" placeholder="Introduce una dirección postal completa" name="address" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="photo">Foto (JPG o PNG, formato 1x1)</label>
                <div class="col-sm-10">          
                    <input type="file" class="form-control" id="photo" name="photo" required>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label><input type="checkbox" name="director" value="yes" onchange='checkDirector(this);'>Director</label>
                    </div>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label><input type="checkbox" name="admin" value="yes">Administrador</label>
                    </div>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label><input type="checkbox" name="blocked" value="yes">Bloqueado</label>
                    </div>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Añadir</button>
                </div>
            </div>
        </form>
    
    </div> 
HTML;

}
// Guarda el usuario en la BBDD
function storeUser() {
    require_once 'php/db.php';

    $db = DB_connection();
    DB_escape($db, $_POST);

    $checking_user_email = DB_query($db, "select `email` from `User` where `email`='{$_POST['email']}'");

    // comprobar que no existe otro usuario con el mismo email
    if ($checking_user_email !== false and count($checking_user_email)==0) {
        $photo_path = uploadPhoto();

        if ($photo_path) {      // si se ha subido la foto correctamente
            $admin = (isset($_POST['admin'])) ? '1' : '0';
            $director = (isset($_POST['director'])) ? '1' : '0';
            $blocked = (isset($_POST['blocked'])) ? '1' : '0';

            $query = "INSERT INTO `User` (`name`, `surname`, `category`, `email`, `pass`, `phone`, `url`, `department`, `center`, 
             `university`, `address`, `photo`, `admin`, `director`, `blocked`) VALUES ('{$_POST['name']}', '{$_POST['surname']}', 
             '{$_POST['category']}', '{$_POST['email']}', PASSWORD('{$_POST['pass']}'), '{$_POST['phone']}', '{$_POST['url']}',
             '{$_POST['department']}', '{$_POST['center']}', '{$_POST['university']}', '{$_POST['address']}', '$photo_path', 
             $admin, $director, $blocked)";

            $result = DB_query($db, $query, false);

            if ($result !== false) {
                echo "<h1>Nuevo usuario</h1> <hr> <p>Usuario almacenado correctamente.</p>";
                writeLog("Se ha registrado el usuario \"{$_POST['name']} {$_POST['surname']}\" ({$_POST['email']}).");
            } else {
                removePhoto($photo_path);
                echo "<h1>Nuevo usuario</h1> <hr> <p>Error: no se pudo almacenar el usuario.</p>";
            }
        }
        else {
            echo "<h1>Nuevo usuario</h1> <hr> <p>Error: no se ha podido subir el fichero.</p>";
        }

    }
    else {
        echo "<h1>Nuevo usuario</h1> <hr> <p>Error: ya existe un usuario con el mismo email.</p>";
    }

    DB_disconnection($db);
}

// Muestra el formulario para modificar usuarios
function displayEditingUser($form = false) {
    global $pub_subtypes;

    if (!$form) {       // si no se ha seleccionado ningún usuario
        require_once 'php/db.php';
        $users = DB_execute("select * from `User`");

        echo <<< HTML

        <h1>Modificar usuario</h1>
        <hr>
        
        <div class="row">
            <form class="form-horizontal" action="index.php?p=edit_user" method="post">
                <input type="hidden" name="edit" value="no">
                <div class="form-group">
                    <label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="toremove">Usuario a modificar:</label>
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <select name="email" id="toremove" class="form-control" required>
HTML;
        if ($users !== false and count($users)>0) {
            foreach ($users as $u) {
                $text = $u['name'] . " " . $u['surname'] . " (" . $u['email'] . ")";
                echo "<option value='{$u['email']}'>$text</option>";
            }
        }
        else {
            echo "<option value='none'>No hay usuarios creados</option>";
        }

        echo <<< HTML
                        </select>
                    </div>
                </div>
                <div class="form-group">        
                    <div class="col-sm-offset-3 col-sm-10">
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </div>
                </div>
            </form>
        </div>
HTML;

    }
    else {      // si se ha seleccionado algún usuario, se muestra el formulario de modificación
        if ($_POST['email'] != 'none') {
            require_once 'php/db.php';
            $data = DB_execute("select `name`,`surname`,`email` from `User` where `email`='{$_POST['email']}'");

            if ($data !== false and count($data)>0) {
                echo <<< HTML

                <h1>Modificar usuario</h1>
                <hr>
                
                <div class="row">
                    <form class="form-horizontal" action="index.php?p=edit_user" method="post" enctype="multipart/form-data" name="user" onsubmit="return validateUser()"> 
                        <input type="hidden" name="edit" value="yes">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Nombre</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" value="{$data[0]['name']}" name="name" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="title">Apellidos</label>
                            <div class="col-sm-10">          
                                <input type="text" class="form-control" id="surname" value="{$data[0]['surname']}" name="surname" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="category">Categoría</label>
                            <div class="col-sm-10">          
                                <input type="text" class="form-control" id="category" placeholder="Catedrático, profesor titular, etc." name="category" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email</label>
                            <div class="col-sm-10">          
                                <input type="email" class="form-control" id="email" value="{$_POST['email']}" name="email" readonly required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pass">Contraseña</label>
                            <div class="col-sm-10">          
                                <input type="password" class="form-control" id="pass" placeholder="Introduce una contraseña" name="pass" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="phone">Teléfono</label>
                            <div class="col-sm-10">          
                                <input type="tel" class="form-control" id="phone" placeholder="Introduce un nº teléfono" name="phone" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="url">Web</label>
                            <div class="col-sm-10">          
                                <input type="url" class="form-control" id="url" placeholder="Introduce una web" name="url" required>
                            </div>
                        </div>        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="department">Departamento</label>
                            <div class="col-sm-10">          
                                <input type="text" class="form-control" id="department" placeholder="Introduce un departamento" name="department" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="center">Centro</label>
                            <div class="col-sm-10">          
                                <input type="text" class="form-control" id="center" placeholder="Introduce un centro" name="center" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="university">Universidad</label>
                            <div class="col-sm-10">          
                                <input type="text" class="form-control" id="university" placeholder="Introduce una universidad" name="university" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="address">Dirección postal</label>
                            <div class="col-sm-10">          
                                <input type="text" class="form-control" id="address" placeholder="Introduce una dirección postal completa" name="address" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="photo">Foto (JPG o PNG, formato 1x1)</label>
                            <div class="col-sm-10">          
                                <input type="file" class="form-control" id="photo" name="photo" required>
                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="director" value="yes" onchange="checkDirector(this);">Director</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="admin" value="yes">Administrador</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="blocked" value="yes">Bloqueado</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">        
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">Modificar</button>
                            </div>
                        </div>
                    </form>
                
                </div> 
HTML;
            }
        }
        else{
            echo "<h1>Modificar usuario</h1> <hr> <p>Error: no se ha seleccionado ningún usuario.</p>";
        }
    }

}
// Modifica el usuario en la BBDD
function editUser() {
    require_once 'php/db.php';
    $db = DB_connection();
    DB_escape($db, $_POST);

    // Borramos la foto antigua
    $old_photo = DB_query($db, "select `photo` from `User` where `email`='{$_POST['email']}'");
    if ($old_photo !== false and count($old_photo)>0)
        removePhoto($old_photo[0]['photo']);

    $photo_path = uploadPhoto();

    if ($photo_path) {      // si se ha podido subir la foto
        $admin = (isset($_POST['admin'])) ? '1' : '0';
        $director = (isset($_POST['director'])) ? '1' : '0';
        $blocked = (isset($_POST['blocked'])) ? '1' : '0';

        $query = "update `User` set `category`='{$_POST['category']}', `pass`=PASSWORD('{$_POST['pass']}'), `phone`='{$_POST['phone']}', 
                 `url`='{$_POST['url']}', `department`='{$_POST['department']}', `center`='{$_POST['center']}', `university`='{$_POST['university']}', 
                 `address`='{$_POST['address']}', `photo`='$photo_path', `admin`='$admin', `director`='$director', `blocked`='$blocked'
                 where `email`='{$_POST['email']}'";

        $result = DB_query($db, $query, false);

        if ($result !== false) {
            echo "<h1>Modificar usuario</h1> <hr> <p>Usuario modificado correctamente.</p>";
            writeLog("Se ha modificado el usuario \"{$_POST['name']} {$_POST['surname']}\" ({$_POST['email']}).");
        } else {
            removePhoto($photo_path);
            echo "<h1>Modificar usuario</h1> <hr> <p>Error: no se pudo modificar el usuario.</p>";
        }
    }
    else {
        echo "<h1>Modificar usuario</h1> <hr> <p>Error: no se ha podido subir el fichero.</p>";
    }

    DB_disconnection($db);
}

// Muestra el formulario para borrar usuarios
function displayRemovingUser() {
    require_once 'php/db.php';
    $users = DB_execute("select * from `User`");

    echo <<< HTML

    <h1>Borrar usuario</h1>
    <hr>
    
    <div class="row">
        <form class="form-horizontal" action="index.php?p=remove_user" method="post">
            <input type="hidden" name="remove" value="yes">
            <div class="form-group">
                <label class="control-label col-xs-3 col-sm-3 col-md-3 col-lg-3" for="toremove">Usuario a eliminar:</label>
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <select name="email" id="toremove" class="form-control" required>
HTML;
    if ($users !== false and count($users)>0) {
        foreach ($users as $u) {
            $text = $u['name'] . " " . $u['surname'] . " (" . $u['email'] . ")";
            echo "<option value='{$u['email']}'>$text</option>";
        }
    }
    else {
        echo "<option value='none'>No hay usuarios creados</option>";
    }

    echo <<< HTML
                    </select>
                </div>
            </div>
            <div class="form-group">        
                <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </div>
            </div>
        </form>
    </div>
HTML;

}
// Borra el usuario en la BBDD
function removeUser() {
    if ($_POST['email'] != 'none') {
        require_once 'php/db.php';
        $data = DB_execute("select `name`,`surname`,`email`,`photo` from `User` where `email`='{$_POST['email']}'");
        $result = DB_execute("delete from `User` where `email`='{$_POST['email']}'", false);

        if ($result !== false) {
            echo "<h1>Borrar usuario</h1> <hr> <p>Usuario borrado correctamente.</p>";
            removePhoto($data[0]['photo']);
            writeLog("Se ha borrado el usuario \"{$data[0]['name']} {$data[0]['surname']}\" ({$data[0]['email']}).");
            if ($_POST['email'] == $_SESSION['email'])
                logout();
        } else {
            echo "<h1>Borrar usuario</h1> <hr> <p>Error: no se pudo borrar el usuario seleccionado.</p>";
        }
    }
    else{
        echo "<h1>Borrar usuario</h1> <hr> <p>Error: no se ha seleccionado ningún usuario.</p>";
    }

}

// Muestra el log
function displayLog() {
    echo "<h1>Log</h1> <hr>";
    if (file_exists('log.txt') and is_readable('log.txt')) {
        if ( $cads = file("log.txt") ) {
            $cads = array_reverse($cads);
            foreach ($cads as $c) {
                echo $c . "<br>";
            }
        }
        else
            echo "Error: no se pudo leer el log.";
    }
    else {
        echo "Error: no se pudo abrir el fichero.";
    }
}
// Escribe una entrada en el log
function writeLog($string) {
    date_default_timezone_set('Europe/Madrid');
    $date = date('d/m/Y H:i:s', time());
    $string = "[" . $date . "]: " . $string . PHP_EOL;

    if (file_exists('log.txt') and is_writable('log.txt')) {
        if ( ($f = fopen("log.txt","a")) and flock($f, LOCK_EX)) {
            fwrite($f, $string);
            flock($f, LOCK_UN);
            fclose($f);
        }
        else {
            echo "Error: no se pudo abrir el fichero.";
        }
    }
    else{
        echo "Error: no se pudo abrir el fichero.";
    }

}

// Crea un backup de la BBDD
function makeBackup() {
    require_once ('php/db.php');
    $db = DB_connection();

    // Obtener listado de tablas
    $tablas = array();
    $result = mysqli_query($db,'SHOW TABLES');
    while ($row = mysqli_fetch_row($result))
        $tablas[] = $row[0];

    // Damos la vuelta al array para que se mantengan las claves externas
    $tablas = array_reverse($tablas);
    // Establecemos antes la tabla de proyectos que la publicaciones
    $tmp = $tablas[1];
    $tablas[1] = $tablas[2];
    $tablas[2] = $tmp;

    // Make drop at first
    $salida = '';
    foreach (array_reverse($tablas) as $tab){
        $salida .= "DROP TABLE IF EXISTS `$tab`;\n";
    }

    // How to create the table
    foreach ($tablas as $tab){
        $row2 = mysqli_fetch_row(mysqli_query($db,'SHOW CREATE TABLE `'.$tab.'`'));
        $salida .= "\n\n".$row2[1].";\n\n"; // row2[0]=nombre de tabla
    }

    // Salvar cada tabla
    foreach ($tablas as $tab) {
        $result = mysqli_query($db,'SELECT * FROM `'.$tab.'`');
        $num = mysqli_num_fields($result);
        while ($row = mysqli_fetch_row($result)) {
            $salida .= 'INSERT INTO `'.$tab.'` VALUES(';
            for ($j=0; $j<$num; $j++) {
                $row[$j] = addslashes($row[$j]);
                $row[$j] = preg_replace("/\n/","\\n",$row[$j]);
                if (isset($row[$j]) and $row[$j]!='')
                    $salida .= '"'.$row[$j].'"';
                else
                    $salida .= 'NULL';
                if ($j < ($num-1)) $salida .= ',';
            }
            $salida .= ");\n";
        }
        $salida .= "\n\n\n";
    }

    DB_disconnection($db);

    $filename='database_backup.sql';
    file_put_contents($filename, $salida);

    if (file_exists('installed'))
        echo "<h1>Hacer backup BBDD</h1> <hr> <a href='$filename' class='btn btn-primary btn-block' download>Haga click aquí para descargar el backup</a>";
}
// Restaura un backup de la BBDD
function restoreBackup($restore = false) {
    if (!isset($_POST['restore'])){
        echo <<< HTML
        
        <h1>Restaurar backup BBDD</h1>
        <hr>
        <div class="row">
            <form class="form-horizontal" action="index.php?p=restore_backup" method="post" enctype="multipart/form-data">
                <input type="hidden" name="restore" value="yes">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="sql">Archivo SQL</label>
                    <div class="col-sm-10">          
                        <input type="file" class="form-control btn-block" id="sql" name="sql" required>
                    </div>
                </div>
                <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Subir</button>
                    </div>
                </div>
            </form>
        </div>
HTML;
    }
    else {
        $fileType = pathinfo($_FILES["sql"]["name"],PATHINFO_EXTENSION);
        $allowed = array('application/sql', 'text/sql', 'text/x-sql', 'text/plain');
        $uploadOk = true;

        if(isset($_POST["submit"])) {
            $check = filesize($_FILES["sql"]["tmp_name"]);
            if($check === false) {
                $uploadOk = false;
            }
        }

        if ($_FILES["sql"]["size"] > 500000) {
            $uploadOk = false;
        }
        // Allow certain file formats and file types
        if($fileType != "sql" && in_array($_FILES['sql']['type'], $allowed)) {
            $uploadOk = false;
        }

        // No se mueve el archivo a un lugar seguro ya que no nos hará más falta
        if ($uploadOk) {
            require_once ('php/db.php');
            $content = file_get_contents($_FILES["sql"]["tmp_name"]);

            $db = DB_connection();
            $result = mysqli_multi_query($db, $content);
            DB_disconnection($db);

            if ($result !== false){
                echo "<h1>Restaurar backup BBDD</h1><hr> <p>Se ha restaurado la BBDD correctamente.</p>";
            }
            else{
                echo "<h1>Restaurar backup BBDD</h1><hr> <p>Error: no se ha podido restaurar la BBDD correctamente.</p>";
            }

            unlink($_FILES["sql"]["tmp_name"]);
        }
        else{
            echo "<h1>Restaurar backup BBDD</h1><hr> <p>Error: no se ha podido subir el fichero seleccionado.</p>";
        }
    }
}

// Muestra un aviso de instalación de la web app
function displayInstallApp() {
    echo <<< HTML
    
    <h1>Instalar aplicación web</h1>
    <hr>
    
    <p>¿Desea instalar la aplicación web? </p> 
    <p>Si es así, pulse el botón y cree un usuario administrador (director) si no lo hizo anteriormente.</p>
    <p>A continuación, haga logout y regístrese con dicho usuario.</p>
    <a href='index.php?p=doinstall' class='btn btn-primary btn-block'>Sí, quiero instalar la aplicación web</a>
HTML;

}
// Instala la aplicación web
function installApp() {
    if (!file_exists('installed')){
        require_once ('php/db.php');
        $file = ( file_exists('database_backup.sql') )? 'database_backup.sql' : 'tablas.sql';
        var_dump($file);

        $sql = file_get_contents($file) or die("Error en apertura de fichero SQL.");

        $db = DB_connection();
        $result = mysqli_multi_query($db, $sql);
        DB_disconnection($db);

        if ($result !== false){
            file_put_contents('installed', '');
            header('Location: index.php?p=add_user');
        }
        else{
            header('Location: index.php?p=anywhere');
        }

    }
}
// Muestra un aviso de desinstalación de la web app
function displayUninstallApp() {
    echo <<< HTML
    
    <h1>Desinstalar aplicación web</h1>
    <hr>
    
    <p>¿Está seguro que quiere desinstalar la aplicación web?</p>
    <a href='index.php?p=douninstall' class='btn btn-primary btn-block'>Sí, quiero desinstalarla</a>
HTML;

}
// Deinstala la aplicación web
function uninstallApp() {
    if (file_exists('installed')){
        unlink('installed');
        makeBackup();
        logout();
        header('Location: index.php');
    }
}

///
/// ADMINISTRACIÓN
//////////////////////////////////////////////////////



//////////////////////////////////////////////////////
/// ERRORES
///
function displayAppNotInstalled() {
    echo <<< HTML
    <h1>Error</h1>
    <hr>
    <p>La aplicación web a la que intenta acceder no se encuentra disponible.</p>
    <p>Contacte con un administrador para obtener más información al respecto.</p>
HTML;
}
function displayBadRequest() {
    echo <<< HTML
    <h1>Error</h1>
    <hr>
    <p>Lo sentimos, la página a la que intenta acceder no está disponible en estos momentos.</p>
HTML;

}
function displayBadLogin() {
    echo <<< HTML
    <h1>Error</h1>
    <hr>
    <p>El usuario y/o contraseña introducidos no son correctos. Si ha olvidado su contraseña, contacte con un administrador.</p>
HTML;

}
///
/// ERRORES
//////////////////////////////////////////////////////


//////////////////////////////////////////////////////
/// LOGIN
///
function login() {
    if (file_exists('installed')) { // si la web app está instalada, se comprueba credenciales de usuario desde la BBDD
        require_once 'php/db.php';
        $db = DB_connection();
        DB_escape($db, $_POST);

        $data = DB_query($db, "select * from `User` where `email`='{$_POST['email']}' and `pass`=PASSWORD('{$_POST['password']}')");

        if (count($data) > 0 and $data !== false and $data[0]['blocked'] == 0) {
            foreach ($data[0] as $key => $value) {
                $_SESSION[$key] = $value;
            }
        }
        else{
            header('Location: index.php?p=bad_login');
        }

        DB_disconnection($db);
    }
    else{                                   // si la web app no está instalada, solo se tiene en cuenta al usuario root
        $email = "root";
        $pass = "root";

        if ($_POST['email'] == $email and $_POST['password'] == $pass){
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['pass'] = $_POST['password'];
            $_SESSION['name'] = 'Root';
            $_SESSION['admin'] = 1;

            header('Location: index.php?p=install');
        }
        else {
            header('Location: index.php?p=bad_login');
        }
    }
}
function logout() {
    // Destruir todas las variables de sesión.
    $_SESSION = array();

    // Borrando la cookie de sesión.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,$params["path"], $params["domain"],$params["secure"], $params["httponly"]);
    }

    session_destroy();
}
///
/// LOGIN
//////////////////////////////////////////////////////



//////////////////////////////////////////////////////
/// FUNCIONES AUXILIARES
///

// Sube una foto de usuario al servidor, realizando las comprobaciones pertinentes
function uploadPhoto() {
    $target_dir = "img/user_photo/";
    $imageFileType = pathinfo($_FILES["photo"]["name"],PATHINFO_EXTENSION);
    $target_file = $target_dir . uniqid() . '.' . $imageFileType;
    $allowed = array('image/png', 'image/jpeg', 'image/pjpeg');
    $uploadOk = true;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check === false) {
            $uploadOk = false;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = false;
    }
    // Check file size
    if ($_FILES["photo"]["size"] > 500000) {
        $uploadOk = false;
    }
    // Allow certain file formats and file types
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && in_array($_FILES['photo']['type'], $allowed)) {
        $uploadOk = false;
    }

    if ($uploadOk) {
        $uploadOk = $uploadOk and move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        if ($uploadOk){
            return $target_file;
        }
        else {
            return $uploadOk;
        }
    }
    else {
        return $uploadOk;
    }

}
// Borra la foto $path, si existe
function removePhoto($path) {
    if (file_exists($path))
        unlink($path);
}
// Elimina el caracter "," del final de $string
function removeFinalComma (&$string) {
    if (strlen($string) > 0) {
        $string = trim($string);
        if ($string[strlen($string) - 1] == ',')
            $string = substr($string, 0, strlen($string) - 1);
    }
}
///
/// FUNCIONES AUXILIARES
//////////////////////////////////////////////////////

?>