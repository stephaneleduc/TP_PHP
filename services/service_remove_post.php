<?php

//Ce fichier est utilisé lorsqu'un utilisateur souhaite supprimer un post

    //Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>

<?php

    //On verifie que l'id du post à supprimer soit bien présent dans l'URL
    if (isset($_GET["id"]) ) {

        //On récupere l'id du post
        $id_post = $_GET["id"];
        //On récupere l'id de l'utilisateur qui a posté ce post
        $id_user_post =  getUserIdPost($id_post, $_SESSION["user"]["id_subject"] );
        //On récupere le role de cette utilisateur
        $id_role_post = recupRoleFromUserId($id_user_post);
        //On recupere l'id du sujet concerné
        $id_subject = $_SESSION["user"]["id_subject"];
        //On récupere l'id du premier post du sujet concerné
        $min_id_post = getMinDateIdPost($id_subject);

        //Si le role est correct, si le user qui souhaite supprimer est l'auteur
        if ( $id_role_post >= $_SESSION["user"]["id_role"]  || $id_user_post == $_SESSION["user"]["id"]) {

            //et si le post à supprimer n'est pas le post originel du sujet
            if ($min_id_post != $id_post) {

                //Suppression du post et retour à la page du sujet avec un message de validation
                $id_user = $_SESSION["user"]["id"];
                $id_post = $_GET["id"];
                removePost($id_post);
                $message = urlencode("Le message sélectionné a bien été supprimé");
                header("Location: ?page=subject&subject=".$id_subject."&message=".$message);
                die();

            }

            //Le post à supprimer est le post originel, donc on ne le supprime pas
            //Retour au sujet avec un message d'erreur
            else {

                
            $error = urlencode("Le premier post du forum ne peut pas être supprimé !");
            header("Location: ?page=subject&subject=".$id_subject."&error=".$error);
            die();

            }

        }

        //Si l'utilisateur est différent de l'auteur ou/et les droits sont pas bons
        // On redirige vers le sujet avec un message d'erreur
        else {


            $error = urlencode("Vous n'avez pas les autorisation necessaires !");
            header("Location: ?page=subject&subject=".$id_subject."&error=".$error);
            die();

        }
        

    }

    //Si l'id du post n'est pas renseigné, retour à la page du sujet avec un message d'erreur
    else {

        $error = urlencode("Vous n'avez pas les autorisation necessaires !");
        header("Location: ?page=accueil&error=".$error);
        die();
    }


?>