<?php

//Ce fichier est utilisé par ADMIN pour supprimer un sujet

    //Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>


<?php

    //Si l'utilisateur a le droit de supprimer, et que le sujet existe
    if (isset($_GET["subject"] ) && verifySubject( $_GET["subject"] ) && isGranted( $_SESSION["user"]["id_role"], REMOVE_SUBJECT ) ) {

        //suppression du sujet et de ses posts
        removeSubject($_GET["subject"]);
        $message = urlencode("Le sujet demandé a été supprimé !");
        header("Location: ?page=accueil&message=".$message);
        die();

    }

    //Sinon, retour à l'accueil avec un message d'erreur
    else {

        $error = urlencode("Le sujet demandé n'existe pas !");
        header("Location: ?page=accueil&error=".$error);
        die();
    }


?>