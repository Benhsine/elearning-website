<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id']) || !isset($_SESSION['email'])) {
  // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
  header('Location: connexion.html');
  exit();
}

// Récupérer les informations de l'étudiant depuis la session
$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
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
  <p>Vous êtes connecté au tableau de bord de l'étudiant.</p><br>
  <!-- Reste du contenu de la page -->
</body>
</html>