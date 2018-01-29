<?php

 //Ce fichier est utilisé lorsqu'un utilisateur souhaite ajouter/répondre à un sujet

    //Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>

<?php

    //On vérifie que l'utilisateur a bien les droits pour ajouter un post, et on vérifie que le champ n'est pas vide
    if ( isGranted( $_SESSION["user"]["id_role"], CREATE_POST ) && !empty($_POST["new-post"]) ) {

        $content = $_POST["new-post"];
        $id_subject = $_SESSION["user"]["id_subject"];
        $id_user = $_SESSION["user"]["id"];

        //On ajoute le nouveau post en base de données
        addPost($id_subject, $id_user, $content);

        //On recharge la page du sujet concerné
        $message = urlencode("Votre message a bien été ajouté");
        header("Location: ?page=subject&subject=".$id_subject."&message=".$message);

    }

    //Si problème de droit ou champ vide, on  redirige vers le sujet concerné avec un message d'erreur.
    else {

        $error= urlencode("Veuillez remplir le champ avant de continuer !");
        header("Location: ?page=subject&subject=".$_SESSION["user"]["id_subject"]);
    }

?>