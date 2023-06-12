<?php
$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost; dbname=bd_elearning;",$username,$password);

if(isset($_POST['upload'])){
$fileName = $_FILES["cour"]["name"];
$file = $_FILES["cour"]["tmp_name"];

move_uploaded_file($file,"../élève/cours/".$fileName);
$position = "../élève/cours/".$fileName;
$uploadFile = $database->prepare("INSERT INTO cours(nom_cour,position) VALUES(:nom,:position)");
$uploadFile->bindParam("nom",$fileName);
$uploadFile->bindParam("position",$position);
if($uploadFile->execute()){
echo 'fichier uploaded avec succes';
}else{
  echo 'fichier not uploaded';
}
}
if (isset($_GET['delete']) ) {
  $docId = $_GET['delete'];
  $deletedoc = $database->prepare("DELETE FROM cours WHERE id = :id");
  $deletedoc->bindParam(":id", $docId);
  if ($deletedoc->execute()) {
      echo "document supprimée avec succès.";
  } else {
      echo "Erreur lors de la suppression de la document.";
  }
}
$getdoc = $database->prepare("SELECT * FROM cours");
$getdoc->execute();
$docs = $getdoc->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Mes documents</h2>
<ul>
    <?php foreach ($docs as $doc) : ?>
        <li>
            <?php echo $doc['nom_cour']; ?>
            <a href="?delete=<?php echo $doc['id_cour']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet document ?')">Supprimer</a>
            <br>
        </li>
    <?php endforeach; ?>
</ul>

<form method="POST" enctype="multipart/form-data">
<input type="file" name="cour" accept="application/pdf" required/>
<button type="submit" name="upload">upload</button>
</form>