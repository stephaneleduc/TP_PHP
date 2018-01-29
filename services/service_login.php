<?php

//Ce fichier est utilisé lorsqu'un utilisateur souhaite se connecter

    //Utilisé pour empecher l'appel de page php via l'url

    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>


<?php

/*
// USER : lafouine / lafouine
// USER : lafouine1 / lafouine1
// MODERATOR : dragonball / dragonball
// ADMIN : administrator / administrator
*/

//Si les champs sont correctement remplis
if ( !empty($_POST["username"]) && !empty($_POST["password"]) ) {

    $name = $_POST["username"];
    $pass = sha1($_POST["password"] . SALT);

    //On vérifie les bonnes informations entrées par l'utilisateur
    $user = verifyLogin($name, $pass);

    //Si l'utilisateur et le mot de passe ont été trouvé dans la base de données
    if ($user) {

        //On redirige vers la page d'accueil avec un message de validation
        $message = urlencode("Connexion réussie  !");
        $_SESSION["user"] = $user;
        header("Location: ?page=accueil&message=".$message);
        die();
        
    }

    //Si l'utilisateur et le mot de passe n'ont pas été trouvé dans la base de données
    //Retour à l'accueil avec un message d'erreur
    else {

        $error = urlencode("Nom d'utilisateur et/ou mot de passe incorrect  !");
        header("Location: ?page=accueil&error=".$error); 
        die();

    }


}

//S'il manque des informations, retour à l'accueil avec un message d'erreur
else {

    $error = urlencode("Veuillez remplir tous les champs \"login\" avant de vous connecter !");
    header("Location: ?page=accueil&error=".$error);
    die();

}



?>