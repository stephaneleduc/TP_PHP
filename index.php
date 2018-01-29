<?php

    require "functions.php";


    //GESTION DES SERVICES

    if (isset($_GET["service"] ) ) {

        $service = $_GET["service"];

        switch ($service) {

            case "reopen_subject" :
                connectionRequired( MODERATOR );
                include "services/service_reopen_subject.php";
                break;

            case "close_subject" :
                connectionRequired( MODERATOR );
                include "services/service_close_subject.php";
                break;

            case "create_categorie" :
                connectionRequired( ADMIN );
                include "services/service_create_categorie.php";
                break;

            case "reedit_post":
                connectionRequired();
                include "services/service_reedit_post.php";
                break;


            case "remove_subject":
                connectionRequired( ADMIN );
                include "services/service_remove_subject.php";
                break;
            
            case "remove_post":
                connectionRequired();
                include "services/service_remove_post.php";
                break;

            case "edit_post":
                connectionRequired();
                include "services/service_edit_post.php";
                break;

            case "disconnect":
                connectionRequired();
                include "services/service_disconnect.php";
                break;

            case "create_subject":
                connectionRequired();
                include "services/service_create_subject.php";
                break;

            case "add_post":
                connectionRequired();
                include "services/service_add_post.php";
                break;

            case "inscription":
                include "services/service_inscription.php";
                break;

            case "login":
                include "services/service_login.php";
                break;

            default:
                header("Location: ?page=accueil");
        }

        die();

    }



    //GESTION DE L'AFFICHAGE DES PAGES

    $page = "accueil";
    $page_file = "";
    if (isset($_GET["page"])) {

        $page =$_GET["page"];

    }

    switch($page) {

        case "accueil":
            $page_file = "pages/accueil.php";
            break;

        case "subject":
            $page_file = "pages/subject.php";
            break;

        default:
            $page_file = "pages/404.php";

    }


    include "commons/header.php";
    include $page_file;
    include "commons/footer.php";


?>