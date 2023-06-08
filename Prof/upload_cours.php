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
?>

<form method="POST" enctype="multipart/form-data">
<input type="file" name="cour" accept="application/pdf" required/>
<button type="submit" name="upload">upload</button>
</form>