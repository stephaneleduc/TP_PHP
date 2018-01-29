<?php

//Ce fichier est utilisé pour cloturer un sujet

//Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>


<?php


    //Si l'id du sujet est bien en paramètre et les droits sont bons
    if (isset($_GET["subject"]) && isGranted($_SESSION["user"]["id_role"], CLOSE_SUBJECT)) {

        //On cloture le CLOSE_SUBJECT
        //Retour à la page du sujet avec un message de validation
        closeSubject ($_GET["subject"], 1);
        $message = urlencode("Le sujet a bien été cloturé");
        header ("Location: ?page=subject&subject=".$_GET['subject']."&message=".$message);
        die();

    }

    //Si l'une des conditions ci-dessus n'est pas remplie, retour à la page du sujet avec un message d'erreur
    else {

        $error = urlencode("Le sujet n'existe pas ou vous n'avez pas les droits pour le cloturer !");
        header ("Location: ?page=subject&subject=".$_GET['subject']."&error=".$error);
        die();
    }


?>