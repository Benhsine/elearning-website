<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
  // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
  header('Location: connexion_prof.html');
  exit();
}

// Récupérer les informations de l'étudiant depuis la session
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
$dsn = 'mysql:host=localhost;dbname=bd_elearning';
$utilisateur = 'root';
$motDePasse = '';
$connexion = new PDO($dsn, $utilisateur, $motDePasse);
$query= "select * from etudient" ;
$LesEtudiant=$connexion->prepare($query);
$LesEtudiant->execute();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <!-- Inclure les liens vers les fichiers CSS -->
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <h2>Bienvenue, <?php echo $prenom . ' ' . $nom; ?> !</h2>
  <p>Vous êtes connecté au tableau de bord des professeurs.</p><br>
  <form method="POST">
  <input type="submit" name="button" value="voir mes etudiants">
  </form>
  <?php 
  if (isset($_POST["button"])){
  foreach ($LesEtudiant as $etudient ){
    echo "- NOM : ".$etudient['nom']." PRENOM :".$etudient['prenom']." AGE :".$etudient['age']."<br>";
  } }
  ?>
  <!-- Reste du contenu de la page -->
</body>
</html>
