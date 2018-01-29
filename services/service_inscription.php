<?php

//Ce fichier est utilisé lorsqu'un utilisateur souhaite s'inscrire

    //Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>

<?php

    //Par défaut, on met le flag erreur à false
    $errors = false;
    //Si les deux champs ne sont pas vides
    if ( !empty($_POST["user"]) && !empty($_POST["pass"])  ) {

        $name = $_POST["user"];
        //Si le user fait moins de 6 caractères
        if (strlen($name) < 6 ) {
            $error = urlencode("Le nom d'utilisateur doit contenir au moins 6 caractères !");
            $errors = true;
        }

        //Si le mot de passe fait moins de 8 caractères
        else if (strlen($_POST["pass"]) < 8) {
            $error = urlencode("Le mot de passe doit contenir au moins 8 caractères !");
            $errors = true;
        }

        //Si le flag erreur est à true, retour a la page d'accueil avec un message d'erreur
        if ($errors) {
            header ("Location: ?page=accueil&error=".$error);
            die();

        }

        //On hash le mot de passe
        $pass = sha1($_POST["pass"] . SALT);

        //On verifie si le user existe déjà
        $user = verifyInscription($name);

        //Si le user existe dejà, retour à l'accueil avec un message d'erreur
        if ($user) {

            $error = urlencode("Ce nom d'utilisateur existe déjà !");
            header ("Location: ?page=accueil&error=".$error);
            die();

        }


        //Si le user n'existe pas, on l'insère en base de données
        else {
            
            //On récupère le résultat de la requete
            $result = inscriptionUser ($name, $pass);

            //Si c'est ok
            if (!$result) {

                $message = urlencode("Votre inscription a bien été prise en compte !");
                header ("Location: ?page=accueil&message=".$message);
                die();
            }

            //Sinon, on redirige vers l'accueil avec un message d'erreur
            else {

                $error = urlencode("Une erreur est survenue, veuillez réitérer votre inscription !");
                header ("Location: ?page=accueil&error=".$error);
                die();

            }

        }

    }

    //si l'un des 2 champs est vide, on retourne à la page d'accueil avec un message d'erreur
    else {

        $error = urlencode("Veuillez remplir tous les champs \"inscription\" avant de vous inscrire!");
        header("Location: ?page=accueil&error=".$error);
        die();

    }

?>