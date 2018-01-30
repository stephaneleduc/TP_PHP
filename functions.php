<?php

    //Demarrage de la session
    session_start();




    //Définition d"une constante qui va permettre d'enpecher l'appel direct d"une page php.
    define("DEFINITION", "definition");




    //definition d'un locale pour avoir la date en Français
    setlocale(LC_TIME, 'fra_fra');




    //Constantes utilisées pour la base de données
    define("SALT", "k4RbxXx0");
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "root");
    define("DB_NAME", "forum");




    //Constantes qui concernent les différents roles disponibles sur la forum
    define ("USER", 3);
    define ("MODERATOR", 2);
    define ("ADMIN", 1);




    //Les différents privilèges disponibles
    define ("CREATE_SUBJECT", 1);
    define ("CREATE_POST", 2);
    define ("EDIT_HIS_POST", 3);
    define ("REMOVE_HIS_POST", 4);
    define ("REMOVE_POST", 5);
    define ("REMOVE_SUBJECT", 6);
    define ("CREATE_CATEGORIE", 7);
    define ("CLOSE_SUBJECT", 8);
    define ("REOPEN_SUBJECT", 9);




    //Constantes par défaut du nombre de sujets et du nombre de posts affichés par page
    define("NB_SUBJECTS_BY_PAGE", 10);
    define("NB_POSTS_BY_PAGE", 10);





    //Cette fonction permet de vérifier si un utilisateur est connecté.
    //Retourne vrai si la session utilisateur existe et s'il a le bon role
    function isLogged( $as_role = USER ) {

        return ( isset($_SESSION["user"]) 
        && $_SESSION["user"]["id_role"] <= $as_role );
    }




    
    //Cette fonction est utilisée avant l'execution d'un service pour vérifier que l'utilisateur est ben connecté
    function connectionRequired($as_role = USER) {

        //S'il n'est pas connecté, retour à l'accueil
        if(!isset( $_SESSION["user"] ) ) {

            header("Location: ?page=accueil");
            die();
        }

        //S'il n'a pas les bonnes autorisations
        else if ( !isLogged( $as_role )) {

            $error = "Vous n'avez pas les autorisation necessaires !";
            header("Location: ?page=accueil&error=".$error);
            die();

        }
    }
    



    //Fonction utilisée pour le debogage PHP
    function debug ( $arg, $printr = false ) {

        if ($printr ) {
            echo "<pre>";
            print_r ($arg);
            echo "</pre>";
        }
        else {
            var_dump($arg);
        }
        die();
    }




    //Fonction permettant de se connecter à la base de données.
    //Retourne la connexion mysql
    function getConnection() {

        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //Gestion de l'erreur de connexion
        if ($errors = mysqli_connect_error($connection)) {

            $errors = utf8_encode($errors);
            header ("Location: ?error=" .$errors);
            die();

        }

        return $connection;


    }





    //Fonction qui vérifie si l'utilisateur à le bon droit(en paramètre) en fonction de son role
    //Retourne true or false
    function isGranted( $id_role, $id_grant ) {

        $connection = getConnection();
        $sql = "SELECT count(*) as found
        FROM link_role_grant
        WHERE link_role_grant.id_role = ?
        AND link_role_grant.id_grant = ?";

        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "ii", $id_role, $id_grant );
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $result);
        mysqli_stmt_fetch($statement); 
        return (boolean)$result;
    }





    //Fonction qui insert le nouvel utilisateur souhaitant s'inscrire dans la base de données
    //Retourne le résultat de l'execution de la requete SQL
    function inscriptionUser($user, $pass) {

        $connection = getConnection();
        $sql = "INSERT INTO users VALUES (null, ?, ?, 3)";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "ss", $user, $pass);
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_fetch($statement);
        mysqli_stmt_close( $statement );
        mysqli_close($connection );

        return $result;

    }




    //Fonction qui vérifie si le nom rentré dans la partie inscription existe dejà en base ou non
    //Retourne 0 ou 1 (0 : le nom n'existe pas en base, 1 : le nom d'utilisateur existe déjà).
    function verifyInscription($user) {

        $connection = getConnection();
        $sql = "SELECT count(*) as number FROM users where username=?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "s", $user);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_number);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close( $statement );
        mysqli_close($connection );

        return $b_number;

    }



    //Fonction qui vérifie si le nom de catégorie existe déjà (ou non) avant de créer une nouvelle catégorie
    // Retourne 1 si le nom de catégorie existe déjà ou 0 si ce n'est pas le cas
    function verifyCategorie($cat_name) {

        $connection = getConnection();
        $sql = "SELECT count(*) as number FROM categories where cat_name=?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "s", $cat_name);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_number);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close( $statement );
        mysqli_close($connection );

        return $b_number;

    }


    //Fonction qui verifie que le sujet existe bien avant de le supprimer
    function verifySubject ($id_subject) {
        $connection = getConnection();
        $sql = "SELECT count(*) as number FROM subject where id=?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_subject);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_number);
        $result = mysqli_stmt_fetch( $statement );
        mysqli_stmt_close ($statement);
        mysqli_close($connection);
        
        return ($b_number);

    }


    //Fonction qui vérifie la connexion d'un utilisateur.
    //Retourne toutes les infos utilisateurs (id, nom, mot de passe, et son role)
    function verifyLogin($username, $password) {

        $connection = getConnection();
        $sql = "SELECT * FROM users where username=? AND password= ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "ss", $username, $password);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_id, $b_username, $b_password, $b_id_role);
        mysqli_stmt_fetch($statement);

        $user = [];

        if ($b_id ) {

            $user= [
                "id" => $b_id,
                "username" => $b_username,
                "password" => $b_password,
                "id_role" => $b_id_role

            ];
        }

        mysqli_stmt_close( $statement );
        mysqli_close($connection );

        return $user;
    }



    //Fonction qui retourne le nom du role en fonction de l'id passé en paramètre.
    function getRole($id_role) {

        $connection = getConnection();
        $sql = "SELECT role_name FROM roles where id = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_role);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_role);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);

        return $b_role;
    }


    //Fonction utilisé lors de l'affichage des posts d'un sujet.
    //Vérifié si le titre de l'id du sujet passé en URL existe.
    //Permet d'éviter des mauvais ID en URL
    function getSubjectTitle( $id_subject) {

        $connection = getConnection();
        $sql = "SELECT title FROM subject where id = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_subject );
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_title);
        $result = mysqli_stmt_fetch( $statement );
        mysqli_stmt_close ($statement);
        mysqli_close($connection);

        if ($result) {
        
            return $b_title;
        
        }

        else {

            return false;
        }
        
    }





    //Fonction qui retourne le contenu d'un post dont l'id est passé en paramètre
    //Cette fonction est utilisé dans le cas de l'édition d'un post
    function getContentFromPost($id_post) {

        $connection = getConnection();
        $sql = "SELECT post_content FROM posts where id = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_post );
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_content);
        mysqli_stmt_fetch( $statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);
        return $b_content;

    }





    //Recupère et retourne tous les posts disonibles pour un sujet précis, dont l'id est passé en paramètre.
    //Optionnellement, l'index de la page et le nombre de posts par page peuvent être passés en paramètre.
    function getPostsBySubject ($id_subject, $page_index = 0, $nb_post = NB_POSTS_BY_PAGE) {

        $connection = getConnection();
        $sql = "SELECT posts.id, users.username, post_content, date_post
        FROM posts
        JOIN users
        ON users.id = posts.id_user
        WHERE posts.id_subject = ?
        ORDER BY date_post ASC
        LIMIT ?, ?";

        $start_index = $page_index * $nb_post;
        $end_index = $nb_post;

        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "iii", $id_subject, $start_index, $end_index);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_id, $b_username, $b_content, $b_date);

        $posts = [];

        while ( mysqli_stmt_fetch( $statement) ) {

            $posts[] = [
                "id" => $b_id,
                "username" => $b_username,
                "content" => $b_content,
                "date" => $b_date

            ];
        }

        mysqli_stmt_close( $statement );
        mysqli_close($connection );

        return $posts;

    }




    //Récupère et retourne l'id du role de l'utisateur avec son nom es paramètre
    //Utilisé lors de l'affichage des posts
    function recupRoleFromUsername ($username) {

        $connection = getConnection();
        $sql = "SELECT id_role FROM users WHERE username = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "s", $username );
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_id_role);
        $result = mysqli_stmt_fetch( $statement );
        mysqli_stmt_close ($statement);
        mysqli_close($connection);

        return($b_id_role);


    }




    //Récupère et retourne l'id du role de l'utilisateur avec son id en paramètre
    function recupRoleFromUserId ($id_user) {

        $connection = getConnection();
        $sql = "SELECT id_role FROM users WHERE id = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "s", $id_user );
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_id_role);
        $result = mysqli_stmt_fetch( $statement );
        mysqli_stmt_close ($statement);
        mysqli_close($connection);

        return($b_id_role);


    }



    // Recupère l'id du post le plus ancien d'un sujet (id passé en paramètre).
    // Utilisé dans l'affichage des posts pour emepecher sa suppression.
    // Il s'agit du premier post lors de la création du sujet
    function getMinDateIdPost($id_subject) {

        $connection = getConnection();
        $sql = "SELECT min(date_post) as mindate, id 
        FROM posts
        WHERE id_subject = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_subject );
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_date_min, $b_id_post);
        mysqli_stmt_fetch( $statement );
        mysqli_stmt_close ($statement);
        mysqli_close($connection);
        return($b_id_post);
    }






    //Affichage du post, dont le contenu et l'id du sujet sont passés en paramètre
    function showPost( $message, $id_subject) {

        if (isset($_GET["index_page"])) {

            $index_page = $_GET["index_page"];
        }
    
        else {
    
            $index_page = 0;
    
        }

        if (isset($_GET["post_by_page"])) {

            $nb_posts = $_GET["post_by_page"];
        }
    
        else {
    
            $nb_posts = NB_POSTS_BY_PAGE ;
    
        }

        //On récupere la valeur du booléen qui clore le sujet
        $close = getCloseSubject($id_subject);

        //L'id du post est inséré dans la session
        $_SESSION["id_post"] = $message["id"];

        //On travaille sur la date pour la formater dans un format plus lisible
        $date = strtotime($message["date"]);
        $newdate = strftime('%A %d %B %Y à %H:%M:%S',$date);

        //Affichage du message
        $content_post = $message["content"];
        $content = str_replace("\r", "<br>", $content_post);

        //On commence à créer l'affichage du post.
        $line = "<div class = post >";
        $line .= "<div class=info>".$message["username"]." a écrit le ".$newdate." :</div>";
        $line .= "<div class=content>".$content."</div>";
        $line .= "<div class=edit>";

        //On récupère l'id du role de l'utilisateur qui a écrit le post. Cela va permettre d'ajouter les options de "modification"
        // et de "suppression" du post en fonction du role et des droits.
        $id_user_role = recupRoleFromUsername($message["username"]);

        //On récupere l'id du premier post du sujet (celui-ci ne pourra pas être supprimé ou modifié)
        $min_id_post = getMinDateIdPost($id_subject);

        //si le sujet n'est  pas clos, on peut pmodifier/supprimer de post
        if (!$close) {
            //Si l'utilisateur est loggé et que le post concerné n'est pas le premier
            if ( islogged() && $message["id"] != $min_id_post ) {

                //Si l'utilisateur à les droits de suppression, et qu'il est "ADMIN"
                if (isGranted( $_SESSION["user"]["id_role"], REMOVE_POST ) && $_SESSION["user"]["id_role"] == 1) {

                    //On ajoute le lien pour la suppression de post
                    $line .= "<a href=?service=remove_post&id=".$_SESSION["id_post"].">Supprimer</a>";

                    //Si l'utilisateur concerné est celui qui a écrit le message, on lui rajoute le lien
                    //pour modifier son post
                    if ($message["username"] == $_SESSION["user"]["username"] ) {
                        $line .= "<a href=?service=edit_post&id=".$_SESSION["id_post"]."&post_by_page=".$nb_posts."&index_page=".$index_page."#edit_post>Modifier</a>";
                    }
                }

                //Si l'utilisateur à les droits de suppression, et qu'il est "MODERATOR"
                else if (isGranted( $_SESSION["user"]["id_role"], REMOVE_POST ) && $_SESSION["user"]["id_role"] == 2) {

                    //Si celui qui a écrit le post n'est pas un ADMIN, alors on rejoute le lien de suppression
                    // NB: un MODERATOR ne peut pas supprimé le post d'un ADMIN
                    if ($id_user_role != 1 ) {

                        $line .= "<a href=?service=remove_post&id=".$_SESSION["id_post"].">Supprimer</a>";

                    }

                    //Si l'utilisateur concerné est celui qui a écrit le message, on lui rajoute le lien
                    //pour modifier son post
                    if ($message["username"] == $_SESSION["user"]["username"] ) {
                        $line .= "<a href=?service=edit_post&id=".$_SESSION["id_post"]."&post_by_page=".$nb_posts."&index_page=".$index_page."#edit_post>Modifier</a>";
                    }

                }

                //Si l'utilisateur concerné n'est ni ADMIN, ni MODERATOR
                // et s'il est l'auteur des posts, alors il peut choisir de les modifier ou les supprimer
                else {
                    if ($message["username"] == $_SESSION["user"]["username"] ) {

                        $line .= "<a href=?service=remove_post&id=".$_SESSION["id_post"].">Supprimer</a>";
                        $line .= "<a href=?service=edit_post&id=".$_SESSION["id_post"]."&post_by_page=".$nb_posts."&index_page=".$index_page."#edit_post>Modifier</a>";
                    }

                }

            }

        }

        $line .= "</div>";
        $line .= "</div>";
        //On affiche alors le post et les options disponibles
        echo $line;

    }





    //Cette fonction permet d'ajouter un post via le formulaire en bas de page. 
    // L'id du sujet, de l'utilisateur ainsi que le contenu du post sont passés en paramètre
    function addPost($id_subject, $id_user, $content ) {

        //Encodage du texte pour eviter toutes injections de code
        $text = htmlentities($content);
        $connection = getConnection();
        $sql = "INSERT INTO posts (id_subject, id_user, post_content) VALUES (?,?,?)";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "iis", $id_subject, $id_user, $text);
        mysqli_stmt_execute($statement);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);


    }




    //Fonction réservée à l'ADMIN pour créer une nouvelle catégorie
    function addCategorie( $cat_name ) {

        $connection = getConnection();
        $sql = "INSERT INTO categories (cat_name) VALUES (?)";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "s", $cat_name);
        mysqli_stmt_execute($statement);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);


    }





    //Fonction qui compte et retourne le nombre de sujets disponibles.
    //Permet la pagination
    function countNbSubject () {

        $connection = getConnection();
        $sql = "SELECT count(id) as subjects FROM subject";
        $results = mysqli_query($connection, $sql);
        $result = mysqli_fetch_assoc($results);
        mysqli_close($connection);
        return $result["subjects"];

    }
    




    //Fonction qui compte et retourne le nombre de posts pour un sujet précis.
    //Utile lors de l'affichage des sujets sur la page d'accueil
    function countPostsBySubject( $id_subject ) {

        $connection = getConnection();
        $sql = "SELECT count(*) as number FROM posts WHERE id_subject = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_subject);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_number);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);
        return $b_number;
    }




    //Cette fonction affiche sur la page d'accueil tous les sujets avec (le titre, l'auteur, le nombre de posts,
    //la date du dernier post et la catégorie).
    //Les paramètres optionnels permettent la pigination et un affichage en fonction du nombre de sujets par page (liste déroulante)
    //Le paramètre "catégorie" permet de filtrer l'affichage des sujets.
    //Le paramètre "auteurs" permet d'afficher les sujets de l'auteur renseigné dans la barre de recherche
    //Le paramètre "title" permet d'afficher les sujets dont le titre contient les mots clés saisis par l'utilisateur
    //Le paramètre "msg" permet d'afficher les sujets dont les messages contiennent les  mots clés saisis par l'utilisateur
    function showMenu ($page_index = 0, $nb_subject = NB_SUBJECTS_BY_PAGE, $categorie = null, $auteur = null, $title = null, $msg = null) {

        $start_index = $page_index * $nb_subject;
        $end_index = $nb_subject;
        $connection = getConnection();
        
        //Si la recherche d"un mot clé dans les messages est activée
        if ($msg != null ) {

            $string = preg_replace('/\s.*/', '', $msg);
            $new_msg = "%$string%";

            $sql= "SELECT subject.id, title, users.username, P1.date_post, cat_name
            FROM SUBJECT
            JOIN POSTS as P1
            ON P1.id_subject = subject.id
            JOIN USERS
            ON users.id = subject.id_user
            JOIN CATEGORIES
            ON categories.id = SUBJECT.id_cat
            WHERE P1.post_content like ?
            AND P1.date_post IN (SELECT max(date_post) FROM POSTS as P2 WHERE P1.id_subject = P2.id_subject)
            GROUP BY subject.id
            LIMIT ?, ?";

            $statement = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($statement, "sii", $new_msg, $start_index, $end_index);
            mysqli_stmt_execute ($statement );
            mysqli_stmt_bind_result( $statement, $b_id, $b_title, $_username, $b_date_post, $b_cat_name);
            $subjects = [];

        }



        //Si la recherche d"un mot clé dans le titre du sujet est activée
        else if ($title != null ) {

            $string = preg_replace('/\s.*/', '', $title);
            $newtitle = "%$string%";

            $sql= "SELECT subject.id, title, users.username, P1.date_post, cat_name
            FROM SUBJECT
            JOIN POSTS as P1
            ON P1.id_subject = subject.id
            JOIN USERS
            ON users.id = subject.id_user
            JOIN CATEGORIES
            ON categories.id = SUBJECT.id_cat
            WHERE title like ?
            AND P1.date_post IN (SELECT max(date_post) FROM POSTS as P2 WHERE P1.id_subject = P2.id_subject)
            GROUP BY subject.id
            LIMIT ?, ?";

            $statement = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($statement, "sii", $newtitle, $start_index, $end_index);
            mysqli_stmt_execute ($statement );
            mysqli_stmt_bind_result( $statement, $b_id, $b_title, $_username, $b_date_post, $b_cat_name);
            $subjects = [];

        }


        //Si la recherche d'un auteur est activée, on recherche et on affiche tous les sujets de cet auteur
        else if ($auteur != null ) {

            $new_auteur = "%$auteur%";

            $sql= "SELECT subject.id, title, users.username, P1.date_post, cat_name
            FROM SUBJECT
            JOIN POSTS as P1
            ON P1.id_subject = subject.id
            JOIN USERS
            ON users.id = subject.id_user
            JOIN CATEGORIES
            ON categories.id = SUBJECT.id_cat
            WHERE users.username like ?
            AND P1.date_post IN (SELECT max(date_post) FROM POSTS as P2 WHERE P1.id_subject = P2.id_subject)
            GROUP BY subject.id
            LIMIT ?, ?";

            $statement = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($statement, "sii", $new_auteur, $start_index, $end_index);
            mysqli_stmt_execute ($statement );
            mysqli_stmt_bind_result( $statement, $b_id, $b_title, $_username, $b_date_post, $b_cat_name);
            $subjects = [];

        }

        //Si l'utilisateur applique un filtre sur la catégorie, la page d'accueil se recharge avec les sujets
        // contenus dans cette catégorie
        else if ($categorie != null) {

            $sql = "SELECT subject.id, title, users.username, P1.date_post, cat_name
                    FROM SUBJECT
                    JOIN POSTS as P1
                    ON P1.id_subject = subject.id
                    JOIN USERS
                    ON users.id = subject.id_user
                    JOIN CATEGORIES
                    ON categories.id = SUBJECT.id_cat
                    WHERE id_cat = ?
                    AND P1.date_post IN (SELECT max(date_post) FROM POSTS as P2 WHERE P1.id_subject = P2.id_subject)
                    GROUP BY subject.id
                    LIMIT ?, ?";

            $statement = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($statement, "iii", $categorie, $start_index, $end_index);
            mysqli_stmt_execute ($statement );
            mysqli_stmt_bind_result( $statement, $b_id, $b_title, $_username, $b_date_post, $b_cat_name);
            $subjects = [];

        }

        //Si on ne filtre pas la catégorie, on récupere tous les sujets
        else {
            $sql = "SELECT subject.id, title, users.username, P1.date_post, cat_name
                    FROM SUBJECT
                    JOIN POSTS as P1
                    ON P1.id_subject = subject.id
                    JOIN USERS
                    ON users.id = subject.id_user
                    JOIN CATEGORIES
                    ON categories.id = SUBJECT.id_cat
                    WHERE P1.date_post IN (SELECT max(date_post) FROM POSTS as P2 WHERE P1.id_subject = P2.id_subject)
                    GROUP BY subject.id
                    LIMIT ?, ?";

            $statement = mysqli_prepare($connection, $sql);
            mysqli_stmt_bind_param($statement, "ii", $start_index, $end_index);
            mysqli_stmt_execute ($statement );
            mysqli_stmt_bind_result( $statement, $b_id, $b_title, $_username, $b_date_post, $b_cat_name);
            $subjects = [];
        }
        
        //On récupère les infos concernées et on les stocke dans un tableau
        while (mysqli_stmt_fetch( $statement ))  {
            $subjects[] = [

                "id" => $b_id,
                "title" => $b_title,
                "username" => $_username,
                "date_post" => $b_date_post,
                "cat_name" => $b_cat_name

            ];

        }

        $line = "";

        //Pour chaque élément du tableau, on affiche :
        // - le titre du sujet
        // - l'auteur du sujet
        // - le nombre de posts pour ce sujet (suivi de CLOS si sujet clos)
        // - la date du dernier message
        // - la catégorie du sujet
        // - un lien (croix rouge) pour supprimer le sujet (ADMIN uniquement)
        foreach ($subjects as $subject) {

            $date = strtotime($subject['date_post']);
            $newdate = strftime('%d %B %Y, %H:%M:%S',$date);
            $line = "<div id = new-subject >";
            $line .= "<a href=?page=subject&subject=".$subject['id']."><span class = subject >".$subject['title']."</span></a>";
            $line .= "<span class = autor >".$subject['username']."</span>";

            //Si le sujet est clos, on l'affiche dans le menu
            if (getCloseSubject($subject['id'])) {
                $line .= "<span class = nb >".countPostsBySubject($subject['id'])." <b>(CLOS)</b> </span>";
            }
            else {
                $line .= "<span class = nb >".countPostsBySubject($subject['id'])."</span>";
            }
            $line .= "<span class = last-msg >".$newdate."</span>";
            $line .= "<span class = cat_subject >".$subject['cat_name']."</span>";

            //Su l'utilisateur est ADMIN et qu'il a les droits de suppression de sujets
            if ( islogged(ADMIN) && isGranted( $_SESSION["user"]["id_role"], REMOVE_SUBJECT ) ) {

                //On rajoute le lien pour supprimer le sujet
                $line .= "<span class=suppr><a href=?service=remove_subject&subject=".$subject['id']."><img src=issets/close.jpg></a></span>";
              }
            $line .= "</div>";

            echo $line;

        }

    }



    //Retourne toutes les catégories existantes pour les afficher dans les listes déroulantes
    function getCategories() {

        $connection = getConnection();
        $sql = "SELECT id, cat_name as name FROM categories";
        $results = mysqli_query($connection, $sql);
        mysqli_close($connection);
        $cat = [];
        while ($row = mysqli_fetch_assoc($results) ) {
        
            $cat[] = $row;
        }

        return $cat;

    }


    //Affiche le formulaire de création d'un nouveau sujet (réservé aux utilisateurs connectés)
    function showFormularForSubject() {

        $categories = getCategories(); //Recupere toutes les catégories
        $form = "<h3>Créer un nouveau sujet :</h3>";
        $form .= "<form id=create_subject action=?service=create_subject method=post>";
        $form .= "<label>Titre du sujet :</label>";
        $form .= "<input placeholder='255 caractères maximum' type=text name=create-subject><br>";
        $form .= "<label> Votre message :</label>";
        $form .= "<textarea placeholder='1000 caractères maximum' name=first_post></textarea><br>";
        $form .= "<label> Choississez la catégorie :</label>";
        $form .= "<select name=categories size=1>";

        //Affiche les catégories dans une liste déroulante
        foreach ($categories as $categorie) {
            $form .= "<option>".$categorie["name"]."</option>";
        }
        $form .= "</select><br>";
        $form .= "<input type=submit value='Créer le sujet'>";
        $form .="</form>";

        echo $form;
    }



    //Recupère et retourne l'id de la catégorie (dont le nom est pasé en paramètre)
    function getCategorieId ($cat_name) {

        $connection = getConnection();
        $sql = "SELECT id FROM categories WHERE cat_name = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "s", $cat_name);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_number);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);
        return $b_number;
        
    }



    //Créer un nouveau sujet et l"insère en base de données, avec le premier post et la catégorie (obligatoire)
    function createNewSubject($id_user, $title, $content_post, $cat) {

        $text = htmlentities($content);
        $connection = getConnection();
        $sql = "INSERT INTO subject (id_user, title, id_cat) VALUES (? , ?, ?)";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "isi", $id_user, $title, $cat);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close ($statement);

        //Permet de récuperer le nouvel id du sujet créé
        $id_subject = mysqli_insert_id($connection);

        // Ajout du permier post de ce nouveau sujet
        addPost($id_subject, $id_user, $content_post );
        mysqli_close($connection);

    }




    //Fonction réservé à l'ADMIN qui permet la suppression d'un sujet.
    //Supprime dans un premier tous les posts du sujet, puis suprimme le sujet dont l'id est passé en paramètre.
    function removeSubject ( $id_subject ) {
        $connection = getConnection();
        $sql = "DELETE FROM posts WHERE id_subject = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_subject);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close ($statement);

        $sql = "DELETE FROM subject WHERE id = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_subject);
        mysqli_stmt_execute($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);
    }






    //Cette fonction permet de récuperer le booléen qui cloture le sujet
    function getCloseSubject($id_subject) {

        $connection = getConnection();
        $sql = "SELECT close FROM subject WHERE id = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_subject);
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_close);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);
        return $b_close;


    }


    //Cette fonction permet de cloturer/rouvrir un sujet
    function closeSubject ($id_subject, $value) {

        $connection = getConnection();
        $sql = "UPDATE subject set close = ? WHERE id = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "ii", $value, $id_subject);
        mysqli_stmt_execute($statement);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);

    }

    

    //Récupère l'id de l'utilisateur qui a posté le post
    //Utilisée la suppression et la modification du post
    function getUserIdPost($id_post, $id_subject ) {
        $connection = getConnection();
        $sql = "SELECT id_user as number FROM posts WHERE  id = ? AND id_subject = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "ii", $id_post, $id_subject );
        mysqli_stmt_execute($statement);
        mysqli_stmt_bind_result($statement, $b_number);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);
        return $b_number;

    }





    //Fonction qui permet la suppression d'un post
    function removePost( $id_post ) {
        $connection = getConnection();
        $sql = "DELETE FROM posts WHERE id = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "i", $id_post);
        mysqli_stmt_execute($statement);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);
    
    }





    //fonction qui permet de mettre à jour un post
    function updatePostContent( $id_post, $content ) {
        $text = htmlentities($content);
        $connection = getConnection();
        $sql = "UPDATE posts set post_content = ? WHERE id = ?";
        $statement = mysqli_prepare ($connection, $sql);
        mysqli_stmt_bind_param( $statement, "si", $text, $id_post);
        mysqli_stmt_execute($statement);
        mysqli_stmt_fetch($statement);
        mysqli_stmt_close ($statement);
        mysqli_close($connection);

    }

?>