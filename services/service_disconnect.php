<?php

//Fichier utilisé pour la deconnexion d'un utilisateur (lien sur la page d'accueil)

//Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>

<?php

    $session = getRole($_SESSION["user"]["id_role"]);

    //Affichage d'un message concernant la deconnexion
    $message = urlencode("L'utilisateur ".$_SESSION["user"]["username"]. "( ". $session ." ) est désormais déconnecté !");

    //On détruite sa session
    session_unset();

    //On redirige vers la page d'accueil
    header("Location: ?page=accueil&message=".$message);
    die();

?>