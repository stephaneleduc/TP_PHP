<?php

//Ce fichier est utilisé pour afficher les posts d'un sujet une fois qu'on a cliqué sur le sujet dans le menu.

//Utilisé pour empecher l'appel de page php via l'url
    if(!defined("DEFINITION")) {
        header ("Location: ../?page=accueil");
        die();
    }
?>

<?php

    //Récupère l'id du sujet passé en paramètre.
    // Par sécurité, on va tester que cette id existe bien en récupérant le titre du sujet
    if (isset($_GET["subject"])) {

        $id_subject = $_GET["subject"];
        $title = getSubjectTitle($id_subject);

?>

<h3>CHOIX DES FILTRES :</h3>
<div id="nb_post">
    <form method="get" action="."> Nombre de messages par page :
        <select name="post_by_page" size="1">
            <option>5</option>
            <option selected>10</option>
            <option>15</option>
            <option>20</option>
            <option>25</option>
        </select>
        <input type="hidden" name="page" value="subject">
        <input type="hidden" name="subject" value="<?php echo $id_subject ?>">
        <input type="submit" value="Valider">
    </form>
</div>

<?php
        
        //Si le titre n'existe pas, alors le sujet non plus. On renvoie sur la page d'accueil avec une erreur
        if (!$title) {

            $error = urlencode("Le sujet demandé n'existe pas !");
            header("Location: ?page=accueil&error=".$error);
            die(); 
        }

        //si le sujet existe, alors on affiche un lien pour revenir à la liste des sujets, un lien pour répondre à ce sujet(si connecté)
        //et les posts du sujet.
        else {

            echo "<h3>Sujet : ".$title."</h3>";
            echo "<div id=list_menu>";
            echo "<a href=?page=accueil><h4> Liste des sujets </h4></a>";


            //Si connecté, on affiche le lien pour répondre
            if ( isLogged() && !getCloseSubject($id_subject) ) {

                echo "<a href=#add_post><h4> Répondre sur ce sujet </h4></a>";

            }
            

            //Si connecté en tant que ADMIN ou MODERATOR, on affiche la possibilité de cloturer le sujet (si ce n'est pas déjà fait)
            if ( isLogged(MODERATOR) && !getCloseSubject($id_subject)) {

                echo "<a href=?service=close_subject&subject=".$id_subject."><h4> Fermer le sujet </h4></a>";

            }
            else if ( isLogged(MODERATOR) && getCloseSubject($id_subject)) {

                echo "<a href=?service=reopen_subject&subject=".$id_subject."><h4> Rouvrir le sujet</h4></a>";
            }

            echo "</div>";
            //Comme pour les sujets, onmet par défaut des valeurs pour le nombre de posts par page et l'index de la page
            $posts_by_page = NB_POSTS_BY_PAGE;
            $index_page = 0;
            $nb_pages = ceil (countPostsBySubject( $id_subject ) / $posts_by_page );

            // Si le nombre de posts par page est défini dans l'URL
            if ( isset($_GET["post_by_page"])) {

                //Si l'index de la page est défini dans l'URL
                if (isset($_GET["index_page"])) {

                    //On récupere les valeurs de l'URL
                    $posts_by_page = $_GET["post_by_page"];
                    $index_page = $_GET["index_page"];
                    $nb_pages = ceil (countPostsBySubject( $id_subject ) / $posts_by_page );
                    
                    //On test si elles sont correctes.Si ce n'est pas le cas, on les remet par défaut grâce aux constantes du fichier
                    // "functions.php"
                    // On récupèere ensuite les posts
                    if ($index_page < 0 || $index_page >= $nb_pages || $posts_by_page < 5 || $posts_by_page > 25) {
                        $index_page = 0;
                        $posts_by_page = NB_POSTS_BY_PAGE;
                        $nb_pages = ceil (countPostsBySubject( $id_subject ) / $posts_by_page );
                        $posts = getPostsBySubject($id_subject, $index_page, $posts_by_page );
                      }

                      //Si elles sont correctes, on récupère les posts
                      else {
              
                        $nb_pages = ceil (countPostsBySubject( $id_subject ) / $posts_by_page );
                        $posts = getPostsBySubject($id_subject, $index_page, $posts_by_page );
                      }
                    
                }

                //Si l'index de la page n'est pas défini, on récupère juste "nombre de posts par page"
                else {

                    $posts_by_page = $_GET["post_by_page"];
                    $nb_pages = ceil (countPostsBySubject( $id_subject ) / $posts_by_page );

                    //Si "nombre de pots par page" n'est pa correct, on la remet pa défaut
                    if ($posts_by_page < 5 ||$posts_by_page > 25) {
                        $posts_by_page = NB_POSTS_BY_PAGE;
                      }

                    //Et on récupère les posts
                    $posts = getPostsBySubject($id_subject, $index_page, $posts_by_page );
                }
            }


            //Si rien n'est défini, on récupère les posts avec les valeurs par défaut
            else {

                $posts = getPostsBySubject($id_subject, $index_page, $posts_by_page );

            }

            //On boucle sur chaque post pour les afficher
            foreach ($posts as $message) {
                
                showPost($message, $id_subject);

                //Si l'utilisateur a cliqué sur "modifier", la page est rechargée.
                //Si le sujet n'est pas clos
                // Le contenu du post concerné, ainsi que son id sont stockés en session.
                // Si ces deux valeurs de sessions existent, alors un formulaire de modification apparait sous le post concerné
                if (!getCloseSubject($id_subject) && isset($_SESSION["content"]) && isset($_SESSION["edit_id_post"]) && ($message["id"] == $_SESSION["edit_id_post"]) ) {

                    //On inclut le formulaire de réédition de post
                    include "edit_post.php";
                }

                
            }

            //On créé les liens vers les pages et l'indexation
            $page = "<ul>";

            for ( $i= 0 ; $i < $nb_pages ; $i++) {
                        
                 $page .= "<li><a href='?page=subject&subject=".$id_subject."&post_by_page=".$posts_by_page."&index_page=".$i."'> Page ".($i+1)."</a></li> ";
            }

            $page.= "</ul>";
            echo $page;

            //Si on est loggé, qu'on se trouve à la dernière page de posts et que le sujet n'est pas clos, on inclut un formulaire pour répondre
            if ( isLogged() && $index_page == $nb_pages - 1 && !getCloseSubject($id_subject) ) {

                $_SESSION["user"]["id_subject"] = $id_subject;
                include "add_post.php";
            }

        }

    }


    //Si l'id du sujet passé dans l'URL n'existe pas, message d'erreur et retour à l'accueil
    else {

        $error = urlencode("Le sujet demandé n'existe pas !");
        header("Location: ?page=accueil&error=".$error);
        die();
    }


?>