<?php
$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost; dbname=bd_elearning;",$username,$password);

$files = $database->prepare("SELECT * FROM cours");
$files->execute();
foreach($files AS $file ){
echo "<a href='" ."http://localhost/elerning/PROJECT_E-LEARNING/élève/afficher_fichier.php?fichier=". $file["position"] . "' >".$file["nom_cour"]."</a> <br>";
}
?>
