<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>FORUM</title>
        <style>

            ul {

                display:flex;
                justify-content: center;
            }

            li {
                text-decoration : none;
                display : inline;
                margin : 0 20px 0 20px;
            }

            #connection {

                height: 200px;
                display: flex;
                justify-content:flex-start;
            }

            #inscription, #login {

                height:100%;
                text-align: center;
                width:50%;
                border:1px solid black;
                margin :2px;
            }
            
            #inscription label, #inscription input, #login label, #login input {

                margin: 10px;
                
            }

            h1, h2, h3 {
                text-align:center;
                background-color:lightgrey;
            }

            .error {
                font-weight: bold;
                color: red;
                text-align:center;
                font-size: 25px;
            }

            .message {
                font-weight: bold;
                color: blue;
                text-align:center;
                font-size: 25px;
            }
         
            #menu {
                height:25px;
                margin-top: 20px;
                margin-bottom: 5px;
                width:100%;
                background-color: lightgrey;
                font-weight:bold;
            }

            #new-subject {
                height:25px;
                width:100%;
                margin-bottom: 5px;
                background-color: #e7f5f7;
            }

            #new-subject span, #menu span {

                position:absolute;
                height:20px;
                text-align:center;
                overflow:hidden;
            }

            .subject {
                width: 25%;
                left:5%;
                
            }
            .autor {
                width:15%;
                left:30%;
        
            }

            .nb {
                width:10%;
                left:45%;
            }

            .last-msg {
                width:20%;
                left:55%;
            }

            .suppr {

                left:90%;
                width:10%;
            }

            .cat_subject {

                left:75%;
                width:15%;
            }

            .suppr img {

                height:100%;
                display:inline-block;
                background-color:#e5ffff;
                vertical-align: middle;
            }

            .post {

                margin: 20px;
            }

            .info {

                width:100%;
                background-color:#e5ffff;
                border: 1px solid lightgrey;
                text-align:center;
                font-weight:bold;
            }

            .content {

                width:100%;
                background-color:#e5ffff;
                border: 1px solid lightgrey;
            }

            .edit {

                width:100%;
                display:flex;
                justify-content : center;
                background-color:#e5ffff;
                border: 1px solid lightgrey;
            }

            .edit a:first-child {

                margin-right: 10px;
                
            }

            .edit a:nth-child(2) {

                margin-left: 10px;

            }

            #list_menu {

                display: flex;
                justify-content:space-around;
            }

            #add_post, #edit_post, #create_subject, #create_categorie {

                margin:auto;
                width:60%;
                left:50%;
            }

            #create_subject input[type=text],  #create_subject select {

                min-width:100%;

            }

            #create_categorie * {

                margin: 5px;
            }


            #add_post textarea, #edit_post textarea, #create_subject textarea {

                max-width:100%;
                min-width:100%;
                height:100px;
            }

            a {

                text-decoration:none;
            }

            #filter_cat, #nb_subject {

                margin : 10px;
                padding: 10px;
            }

            #nb_subject, #nb_post, #filter_cat {
                text-align:center;
            }

            select {

                text-align:center;
            }



        </style>
    </head>
    <body>

    <?php

        //Utilisé pour empecher l'appel de page php via l'url
        if(!defined("DEFINITION")) {
            header ("Location: ../?page=accueil");
            die();
        }
    ?>

     <h1><a href="?page=accueil">Bienvenue sur monpetitforum.fr</a></h1>

    <?php

    //Affichage des messages et des erreurs si passées dans l'URL
    if (isset($_GET["error"])) {
        $error = urldecode($_GET["error"]);
        echo "<div class=error>".$error."</div>";
    }
    if (isset($_GET["message"])) {
        $message = urldecode($_GET["message"]);
        echo "<div class=message>".$message."</div>";
    }
?>

<?php 

    //Si l'utilisateur n'est pas connecté, on affiche le menu de connexion et d'inscription
    if (!islogged()) {

?>

<div id="connection">
     <div id="login">
        <h2>Se connecter</h2>
        <form action="?service=login" method="POST">

            <label>Username :</label>
            <input type="text" name="username"><br>

            <label>Password :</label>
            <input type="password" name="password"><br>

            <input type="submit" value="Connexion">

        </form>
     </div>

     <div id="inscription">
        <h2>Pas encore de compte ? Incrivez-vous ici !</h2>
        <form action="?service=inscription" method="POST">

            <label>Username :</label>
            <input type="text" name="user"><br>

            <label>Password :</label>
            <input type="password" name="pass"><br>

            <input type="submit" value="Inscription">

        </form>
     </div>

</div>

<?php 

    }

    //Si l'utilisateur est connecté, on affiche un banière avec son nom, son role et un lien de deconnexion.
    else {

        $role = getRole( $_SESSION["user"]["id_role"] );
        echo "<h3>Bienvenue sur le forum ! Vous êtes connecté en tant que ".$_SESSION["user"]["username"]." (Vous êtes ". $role ." ) <a href = ?service=disconnect> Se déconnecter</a></h3>";
    
        //et on affiche le formulaire pour la création d'un sujet
        showFormularForSubject();
    }

?>
    
