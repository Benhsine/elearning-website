<?php
$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost; dbname=bd_elearning;", $username, $password);

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
            <br>
            
        </li>
    <?php endforeach; ?>
</ul>

