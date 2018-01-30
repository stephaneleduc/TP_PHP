<?php

  //Utilisé pour empecher l'appel de page php via l'url
  if(!defined("DEFINITION")) {
    header ("Location: ../?page=accueil");
    die();
  }
?>

<?php
  //Recupération de toutes les catégories disponibles
  $categories = getCategories();
?>

<!-- Barre de recherche -->
<h3>FILTRES DISPONIBLES :</h3>
<div id="search">
  <form method="post" action="?page=accueil"> Rechercher les sujets d'un auteur ou un mot clé dans le titre du sujet : <br>
      <input type="text" name="search-value">
      <select name="research" size="1">
       <option>Sélectionner une valeur</option>
       <option>Auteurs</option>
       <option>Titres</option>
       <option>Messages</option>
      </select>
      <input type="submit" value="Valider">
  </form>
</div>

<!-- formulaire pour filtrer les sujets par catégorie -->
<div id="filter_cat">
  <form method="get" action="?page=accueil"> Filter les sujets par catégories :
      <select name="catname" size="1">
      <?php
        foreach ($categories as $categorie) {
            echo "<option>".$categorie["name"]."</option>";
        }
      ?>
      </select>
      <input type="submit" value="Valider">
  </form>
</div>

<!-- Formulaire pour choisir le nombre de sujets affichés par page -->
<div id="nb_subject">
  <form method="get" action="?page=accueil"> Nombre de sujets par page :
      <select name="subject_by_page" size="1">
        <option>5</option>
        <option selected>10</option>
        <option>15</option>
        <option>20</option>
        <option>25</option>
      </select>
      <input type="submit" value="Valider">
  </form>
</div>

<?php 

    //Formulaire réservé à l'ADMIN pour ajouter une nouvelle catégorie
    if (isLogged (ADMIN ) ) {

      $form = "<h3>Ajouter une nouvelle catégorie :</h3>";
        $form .= "<form id=create_categorie action=?service=create_categorie method=post>";
        $form .= "<label >Nom de la nouvelle catégorie :</label>";
        $form .= "<input type=text name=new-cat>";
        $form .= "<input type=submit value='Créer la catégorie'>";
        $form .="</form>";

        echo $form;

    }

?>

<!-- Affichage du menu des sujets -->
<div id = "menu" >
    <span class = "subject" >SUJET</span>
    <span class = "autor" >AUTEUR</span>
    <span class = "nb" >NB MESSAGE</span>
    <span class = "last-msg" >DERNIER MSG</span>
    <span class = "cat_subject" >CATEGORIE</span>
</div>


<?php

    //On définit par défaut :
    // - le nombre de sujets par page
    // - l'index de la page
    // - le nombre de pages en fonction des 2 valeurs au dessus
  $subjects_by_page = NB_SUBJECTS_BY_PAGE;
  $index_page = 0;
  $nb_pages = ceil (countNbSubject() / $subjects_by_page );

  //Par défaut, aucun filtre de catégorie n'est présent
  $cat = null;
  $auteur = null;
  $title = null;
  $msg = null;

//Si l'utilisateur a recherché quelque chose
  if ( !empty($_POST["search-value"]) &&  !empty($_POST["research"])  && $_POST["research"] != "Sélectionner une valeur" ) {

    //Si il a recherché dans les auteurs
    if ( $_POST["research"] == "Auteurs") {

      $string = $_POST["search-value"];

      $auteur = preg_replace('/[^A-Za-z0-9\- ]/', '', $string);

      showMenu($index_page, $subjects_by_page, $cat, $auteur);
  
    }

    //S'il a recherché dans le titre des sujets
    else if ( $_POST["research"] == "Titres") {

      $string = $_POST["search-value"];

      $title = preg_replace('/[^A-Za-z0-9\- ]/', '', $string);

      showMenu($index_page, $subjects_by_page, $cat, $auteur, $title);

    }

    else if ( $_POST["research"] == "Messages") {

      $string = $_POST["search-value"];

      $msg = preg_replace('/[^A-Za-z0-9\- ]/', '', $string);


      showMenu($index_page, $subjects_by_page, $cat, $auteur, $title, $msg);

    }

  }

  else {



    //Si le filtre catégorie est activé
    if ( isset($_GET["catname"])) {

      //On récupere l'id de la catégorie sélectionné
      $cat = getCategorieId($_GET["catname"]);

      // Si l'id n'existe pas (donc que la valeur dans l'URL est incorrecte), on remet la variable à 0
      // pour afficher tous les sujets
      if (!$cat) {
        $cat = null;
      }

    }

    //Permet la pagination des sujets et l'indexation des pages

    // Si le paramètre "nombre de sujets par page" est présent dans l'URL
    if ( isset($_GET["subject_by_page"])) {

      //Si le paramètre index de la page est présent dans l'URL
      if (isset($_GET["index_page"])) {

          //Si le nombre de sujets par page et l'index de la page sont définis dans l'URL, on récupère ces valeurs.
          $subjects_by_page = $_GET["subject_by_page"];
          $index_page = $_GET["index_page"];

          //On calcule le nombre de pages
          $nb_pages = ceil (countNbSubject() / $subjects_by_page );

          //Si jamais les éléments passés en paramètre sont incorrects, on reprend les valeurs par défaut qui sont
          // définis dans les constantes du fichier "functions.php" et on affiche la liste des sujets
          if ($index_page < 0 || $index_page >= $nb_pages || $subjects_by_page < 5 || $subjects_by_page > 25) {
            $index_page = 0;
            $subjects_by_page = NB_SUBJECTS_BY_PAGE;
            $nb_pages = ceil (countNbSubject() / $subjects_by_page );
            showMenu($index_page, $subjects_by_page, $cat);
          }

          //Sinon, l'index page et le nombre de sujets par page sont corrects et on peut afficher le menu avec les filtres
          else {
            
            $nb_pages = ceil (countNbSubject() / $subjects_by_page );
            showMenu($index_page, $subjects_by_page, $cat);
          }
      }

      //Si l'index de la page n'est pas défini, il reste à 0
      //On récupere dans l'URL le nombre de sujets par page
      else {

        $subjects_by_page = $_GET["subject_by_page"];
        $nb_pages = ceil (countNbSubject() / $subjects_by_page );

        //Si la valeur de "nombre de sujets par page" n'est pas correct, on la met par défaut. Puis on affiche le menu
        if ($subjects_by_page < 5 || $subjects_by_page > 25) {
          $subjects_by_page = NB_SUBJECTS_BY_PAGE;
        }
        showMenu($index_page, $subjects_by_page, $cat);
      }

    }

    //Si rien n'est défini dans l'URL, le menu s'affiche par défaut
    else {

      showMenu($index_page, $subjects_by_page, $cat);

    }

  }


  //On affiche ensuite la pagination et les liens pour naviguer
  $page = "<ul>";

  for ( $i= 0 ; $i < $nb_pages ; $i++) {
            
    $page .= "<li><a href='?subject_by_page=".$subjects_by_page."&index_page=".$i."'> Page ".($i+1)."</a></li> ";
  }

  $page.= "</ul>";
  echo $page;



?>

