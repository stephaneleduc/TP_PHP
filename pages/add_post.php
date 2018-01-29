<?php

//Ce fichier permet d'afficher le formulaire de création de post

//Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }


    //Si l'utilisateur est connecté et a les droits de créer un nouveau post, on affiche le formulaire ci-dessous
    if (isLogged() && isGranted( $_SESSION["user"]["id_role"], CREATE_POST ) ) {
?>

        
        <form id="add_post" action="?service=add_post" method="post">
            <label>Répondre avec un nouveau message :</label>
            <textarea placeholder="ATTENTION : On ne dit pas de la merde ! 1000 caractères maximum !" name="new-post"></textarea>
            <input type="submit" value="Ajouter">

        </form>

<?php
    }
?>