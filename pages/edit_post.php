<?php

//Ce fichier permet d'afficher le formulaire de modification de post

//Utilisé pour empecher l'appel de page php via l'url

    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }

?>

<!-- Ce formulaire s'affiche lorsque l'utilisateur clique sur le lien "modifier" du post -->

<form id="edit_post" action="?service=reedit_post" method="post">
    <label>Modifier votre message : </label>
    <textarea name="update-post" ><?php echo $_SESSION["content"] ?></textarea>
    <input type="submit" value="Modifier">

</form>

