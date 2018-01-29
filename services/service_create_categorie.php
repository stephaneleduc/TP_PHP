<?php

 //Ce fichier est utilisé pour ajouter une nouvelle catégorie
    //Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>


<?php

    //On vérifie que l'utilisateur soit bien "ADMIN" et que le champ ne soit pas vide
    if (!empty($_POST["new-cat"]) && isGranted( $_SESSION["user"]["id_role"] , CREATE_CATEGORIE)) {

        //Si ok, on vérifie que la catégorie n'existe pas en base de données
        if (verifyCategorie( $_POST["new-cat"] )) {

            //Si elle existe, on redirige vers l'accueil avec un message d'erreur
            $error = urlencode("Cette catégorie ne peut pas être ajoutée car elle existe déjà !");
            header ("Location: ?page=accueil&error=".$error);
            die();

        }

        //Si elle n'existe pas déjà, on la créée
        else {

            //Ajout de la nouvelle catégorie
            addCategorie( $_POST["new-cat"] );
            //On redirige vers la page d'accueil avec un message de validation.
            //La nouvelle catégorie apparait dans la liste déroulante
            $message =urlencode("La nouvelle categorie a bien été rajoutée !");
            header ("Location: ?page=accueil&message=".$message);
            die();
            
        }
    }

    else {

        $error =urlencode("Le champ est vide ou vous n'avez pas les autorisations necessaires !");
        header ("Location: ?page=accueil&error=".$error);
        die();

    }

?>