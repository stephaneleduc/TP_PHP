<?php

 //Ce fichier est utilisé lorsqu'un utilisateur souhaite créer un nouveau sujet

    //Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>

<?php

//Si les champs sont bien remplis et que l'utilisateur a le droit de créer un sujet
if ( !empty($_POST["first_post"]) && !empty($_POST["create-subject"]) && isGranted( $_SESSION["user"]["id_role"], CREATE_SUBJECT ) ) {


    $title = $_POST["create-subject"];
    $content_post = $_POST["first_post"];

    //On vérifie que le post ne dépasse pas 1000 caractères
    if (strlen($content_post) > 1000 ) {

        //Si c'est le cas, on redirige vers l'accueil avec un message d'erreur
        $error = urlencode("Le message doit être inférieur à 1000 caractères !");
        header ("Location: ?page=accueil&error=".$error);
        die();

    }

    //Si tout est ok, on récupère la catégorie et l'id du user
    $cat_name = $_POST["categories"];
    $cat = getCategorieId ($cat_name);
    $user = $_SESSION["user"]["id"];

    //Création du nouveau sujet
    createNewSubject( $user, $title, $content_post, $cat);

    //On redirige vers la page d'accueil avec un message de validation
    $message = urlencode("Sujet créé !");
    header("Location: ?page=accueil&message=".$message);

}

//Sinon, retour à l'accueil avec un message d'erreur.
else {

    $error = urlencode("Veuillez entrer un titre de sujet et un message avant de valider !");
    header ("Location: ?page=accueil&error=".$error);
    die();
}

?>