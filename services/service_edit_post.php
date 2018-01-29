<?php

    //Ce fichier est utilisé lorsqu'un utilisateur souhaite modifier l'un de ses posts

    //Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>

<?php

    //Si l'id du post concerné par la modification est passé dans l'URL
    if (isset($_GET["id"]) ) {

        $id_post = $_GET["id"];

        // On récupère l'id de l'utilisateur qui a posté le post
        $id_user_post =  getUserIdPost($id_post, $_SESSION["user"]["id_subject"] );

        //On récupère son role
        $id_role_post = recupRoleFromUserId($id_user_post);

        //On récupère l'id du sujet concerné
        $id_subject = $_SESSION["user"]["id_subject"];

        //Si l'utilisateur qui a crée le post est bien l'utilisateur qui est actuellement connecté, alors la modification peut avoir lieu
        if ($id_user_post == $_SESSION["user"]["id"] && $id_role_post == $_SESSION["user"]["id_role"]) {

            //On récupère le contenu du post
            $content = getContentFromPost($id_post);

            //On l'insère en session
            $_SESSION["content"] = $content;

            //avec l'id du post à modifier
            $_SESSION["edit_id_post"] = $id_post;

            //On redirige vers la page du sujet. Les deux variables de sessions créés au dessus vont permettre l'affichage
            // du formulaire de modification
            header ("Location: ?page=subject&subject=".$_SESSION["user"]["id_subject"]);
            die();
        }

        //Sinon, message d'erreur et retour à l'accueil
        else {

            $error = urlencode("Vous n'avez pas les autorisation necessaires !");
            header("Location: ?page=accueil&error=".$error);
            die();

        }
    
    }

    //Si l'id du post n'est pas passé dans l'URL, message d'erreur et retour à l'accueil
    else {

        $error = urlencode("Vous n'avez pas les autorisation necessaires !");
        header("Location: ?page=accueil&error=".$error);
        die();

    }

?>