 <?php
    require_once 'php/estructura.php';
    require_once 'php/controlador.php';

    if(session_status() != PHP_SESSION_ACTIVE)
        session_start();

    if (isset($_GET['p'])) {
        switch ($_GET['p']) {
            case 'login':
                login();
                unset($_GET['p']);
                break;
            case 'logout':
                logout();
                unset($_GET['p']);
                break;
            case 'douninstall':
                if (file_exists('installed')) {
                    uninstallApp();
                }
                unset($_GET['p']);
                break;
            case 'doinstall':
                if (!file_exists('installed')) {
                    installApp();
                }
                unset($_GET['p']);
                break;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Innotechmon</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/estructura.css">
    <link rel="stylesheet" href="css/secciones.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/validateForms.js"></script>
    <script type="text/javascript" src="js/aside.js"></script>
    <link rel='icon' type='image/x-icon' href='favicon.ico' />
</head>
<body>

<?php
    displayHeader();
?>

<section class="container-fluid">
    <div class="row content">

        <div class="col-xs-0 col-sm-0 col-md-1 col-lg-2">
        </div>

        <?php
            displayAside();
        ?>

        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-6" id="content">
            <?php

                if (file_exists('installed')) {
                    if (!isset($_GET['p'])) {
                        displayIndex();
                    } else {
                        switch ($_GET['p']) {
                            case 'users':
                                displayUsers();
                                break;
                            case 'projects':
                                displayProjects();
                                break;
                            case 'posts':
                                displayPosts(false);
                                break;
                            case 'searchpub':
                                searchPosts();
                                break;

                            case 'add_project':
                                if (isset($_SESSION['email'])) {
                                    if (isset($_POST['store'])) {
                                        storeProject();
                                    } else {
                                        displayAddingProject();
                                    }
                                } else {
                                    displayBadRequest();
                                }
                                break;
                            case 'edit_project':
                                if (isset($_SESSION['email'])) {
                                    if (isset($_POST['edit'])) {
                                        if ($_POST['edit'] == 'no')
                                            displayEditingProject(true);
                                        else if ($_POST['edit'] == 'yes') {
                                            editProject();
                                        }
                                    } else {
                                        displayEditingProject(false);
                                    }
                                } else {
                                    displayBadRequest();
                                }
                                break;
                            case 'remove_project':
                                if (isset($_SESSION['email'])) {
                                    if (isset($_POST['remove'])) {
                                        removeProject();
                                    } else {
                                        displayRemovingProject();
                                    }
                                } else {
                                    displayBadRequest();
                                }
                                break;


                            case 'add_post':
                                if (isset($_SESSION['email'])) {
                                    if (isset($_POST['store'])) {
                                        storePost();
                                    } else {
                                        displayAddingPost();
                                    }
                                } else {
                                    displayBadRequest();
                                }

                                break;
                            case 'edit_post':
                                if (isset($_SESSION['email'])) {
                                    if (isset($_POST['edit'])) {
                                        if ($_POST['edit'] == 'no')
                                            displayEditingPost(true);
                                        else if ($_POST['edit'] == 'yes') {
                                            editPost();
                                        }
                                    } else {
                                        displayEditingPost(false);
                                    }
                                } else {
                                    displayBadRequest();
                                }
                                break;
                            case 'remove_post':
                                if (isset($_SESSION['email'])) {
                                    if (isset($_POST['remove'])) {
                                        removePost();
                                    } else {
                                        displayRemovingPost();
                                    }
                                } else {
                                    displayBadRequest();
                                }
                                break;

                            case 'add_user':
                                if (isset($_SESSION['email']) and $_SESSION['admin'] == 1) {
                                    if (isset($_POST['store'])) {
                                        storeUser();
                                    } else {
                                        displayAddingUser();
                                    }
                                } else {
                                    displayBadRequest();
                                }
                                break;
                            case 'edit_user':
                                if (isset($_SESSION['email'])) {
                                    if (isset($_POST['edit'])) {
                                        if ($_POST['edit'] == 'no')
                                            displayEditingUser(true);
                                        else if ($_POST['edit'] == 'yes') {
                                            editUser();
                                        }
                                    } else {
                                        displayEditingUser(false);
                                    }
                                } else {
                                    displayBadRequest();
                                }
                                break;
                            case 'remove_user':
                                if (isset($_SESSION['email']) and $_SESSION['admin'] == 1) {
                                    if (isset($_POST['remove'])) {
                                        removeUser();
                                    } else {
                                        displayRemovingUser();
                                    }
                                } else {
                                    displayBadRequest();
                                }
                                break;

                            case 'log':
                                if (isset($_SESSION['email']) and $_SESSION['admin'] == 1) {
                                    displayLog();
                                } else {
                                    displayBadRequest();
                                }
                                break;
                            case 'make_backup':
                                if (isset($_SESSION['email']) and $_SESSION['admin'] == 1) {
                                    makeBackup();
                                } else {
                                    displayBadRequest();
                                }
                                break;
                            case 'restore_backup':
                                if (isset($_SESSION['email']) and $_SESSION['admin'] == 1) {
                                    restoreBackup();
                                } else {
                                    displayBadRequest();
                                }
                                break;

                            case 'bad_login':
                                displayBadLogin();
                                break;

                            case 'uninstall':
                                displayUninstallApp();
                                break;

                            default:
                                displayBadRequest();
                                break;
                        }
                    }
                }
                else{
                    if ( isset($_SESSION['email']) ){
                        if ( isset($_GET['p']) )
                            if ( $_GET['p'] == 'install' )
                                displayInstallApp();
                            else
                                displayAppNotInstalled();
                        else
                            displayInstallApp();
                    }
                    else {
                        displayAppNotInstalled();
                    }
                }
            ?>
        </div>

        <div class="col-xs-0 col-sm-0 col-md-1 col-lg-2">
        </div>

    </div>
</section>


<?php
    displayFooter();
?>

</body>
</html>
