<?php
$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost; dbname=bd_elearning;", $username, $password);

if (isset($_POST['upload'])) {
    $fileName = $_FILES["video"]["name"];
    $file = $_FILES["video"]["tmp_name"];

    move_uploaded_file($file, "../élève/videos/" . $fileName);
    $position = "../élève/videos/" . $fileName;
    $uploadFile = $database->prepare("INSERT INTO videos(nom_video, position) VALUES(:nom, :position)");
    $uploadFile->bindParam(":nom", $fileName);
    $uploadFile->bindParam(":position", $position);
    if ($uploadFile->execute()) {
        echo 'Vidéo téléchargée avec succès.';
    } else {
        echo 'Erreur lors du téléchargement de la vidéo.';
    }
}
if (isset($_GET['delete']) ) {
    $videoId = $_GET['delete'];
    $deleteVideo = $database->prepare("DELETE FROM videos WHERE id = :id");
    $deleteVideo->bindParam(":id", $videoId);
    if ($deleteVideo->execute()) {
        echo "Vidéo supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression de la vidéo.";
    }
}

// Récupérer les vidéos depuis la base de données
$getVideos = $database->prepare("SELECT * FROM videos");
$getVideos->execute();
$videos = $getVideos->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Mes vidéos</h2>
<ul>
    <?php foreach ($videos as $video) : ?>
        <li>
            
            <video width="320" height="240" controls>
                <source src="<?php echo $video['position']; ?>" type="video/mp4">
                Votre navigateur ne prend pas en charge la lecture de vidéos.
            </video>
            <br>
            <?php echo $video['nom_video']; ?>
            <a href="?delete=<?php echo $video['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette vidéo ?')">Supprimer</a>
            <br>
        </li>
    <?php endforeach; ?>
</ul>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="video" accept="video/*" required />
    <button type="submit" name="upload">upload</button>
</form>

