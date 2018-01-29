<?php

    //Ce fichier est utilisée pour modifier le post une fois que l'utilisateur a validé le formulaire de modification

    //Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>


<?php

    //On verifie que la modification ne soit pas vide
    if ( !empty($_POST["update-post"])) {

        //On lance la procédure d'update du post en base de données
        updatePostContent($_SESSION["edit_id_post"], $_POST["update-post"] );

        //On supprime les deux variables de sessions qui ont été utilisées pour afficher le formulaire de modification
        unset ($_SESSION["edit_id_post"]);
        unset ($_SESSION["content"]);

        //On redirige vers la page du sujet
        $message = urlencode("Le message a été correctement modifié !");
        header("Location: ?page=subject&subject=".$_SESSION["user"]["id_subject"]."&message=".$message);
        die();

    }

    //Si la modification est vide, on retourne à la page du sujet avec un message d'erreur
    else {

        $error = urlencode("Le champ ne doit pas être vide pour la modification !");
        header("Location: ?page=subject&subject=".$_SESSION["user"]["id_subject"]."&error=".$error);
        die();
    }

?>