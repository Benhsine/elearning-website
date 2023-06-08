
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>ZAYO_PROJECT</title>
		<link rel="stylesheet" href="../CSS/normalize.css">
		<link rel="stylesheet" href="../CSS/main.css">
		<link rel="stylesheet" href="../CSS/all.min.css">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link rel="stylesheet" href="style.css">
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
		<style>
            @media (min-width:768px){
				.scontainer {
				text-align: center;
				border: 2px solid blue;
				margin: 30px 420px;
				padding: 45px ;
				border-radius: 20px;
				background-color: rgb(248, 246, 244);
    			}
			}
			input {
				padding: 10px 30px;
				margin: 8px 25px;
				border: 1px solid blue;
				border-radius: 15px;
				text-align: center;
			}
			@media (max-width:767px){
				.scontainer{
					text-align: center;
					border: 2px solid blue;
					background-color: rgb(248, 246, 244);
					border-radius: 20px;
					margin: 15px 10px;
				    padding: 45px ;
				}
				input {
					margin-left: auto;
					margin-right: auto;
				}
			}
			.avatar{
				background-color: rgb(255, 255, 255);
                overflow: hidden;
                height: 170px;
                width: 170px;
                border-radius: 50%;
                background-image:url('images/monkey.gif');
                background-size: 90% 85%;
                background-repeat: no-repeat;
                background-position: center;
                box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
				margin-left: auto;
				margin-right: auto;
                margin-top: -20px;
				margin-bottom: 40px;
			}
			.btnl:hover{
				font-weight: bold;
				background-color: aqua;
				border: 2px solid blue;
			}
			.btns:hover{
				font-weight: bold;
				background-color: rgb(135, 194, 46);
				border: 2px solid blue;
			}
		</style>
	</head>
<body>
	    <!-- start header -->
		<header>
			<div class="container">
				<a href="http://esi.ac.ma/" >
					<img src="../IMAGES/logo.jpeg" alt="logo" class="pc">
				</a>
				<a href="http://esi.ac.ma/" >
					<img src="../IMAGES/logot.jpeg" alt="logot" class="tlfn">
				</a>
				<nav>
					<ul>
						<li>
							<a href="../HTML/index.html">Acceuil</a>
						</li>
						<li>
							<a href="../HTML/Formations.html">Formations</a>
						</li>
						<li>
							<a href="../HTML/Evénements.html">Evénements</a>
						</li>
						<li>
							<a href="../HTML/A_Propos.html">A_Propos</a>
						</li>
						<li>
							<a href="../HTML/Contact.html">Contact</a>
						</li>
					</ul>
					<button id="menu"><i class="fa-sharp fa-solid fa-bars"></i></button>  
				</nav>
			</div>
		</header>
		<!-- end header -->
	    <div class="content">
			<div class="scontainer">
      <?php
// Récupération des données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$cin = $_POST['cin'];
$email = $_POST['email'];
$password = $_POST['password'];

// Connexion à la base de données (vous devrez fournir vos propres informations de connexion)
$serveur = 'localhost';
$utilisateur = 'root';
$motDePasse = '';
$baseDeDonnees = 'bd_elearning';

try {
  // Connexion à la base de données avec PDO
  $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
  
  // Configuration des options de PDO pour afficher les erreurs
  $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // Vérification de l'existence de l'utilisateur
   $query0 = "SELECT COUNT(*) FROM etudient WHERE cin_pere = :cin";
   $statement0 = $connexion->prepare($query0);
   $statement0->bindParam(':cin', $cin);
   $statement0->execute();
   if ($statement0->fetchColumn() == 0) {
    // Le parent n'a pas de fils
      echo "<h2> vous ne pouvez pas s'inscrire a notre site parce que tu na pas d'enfants chez nous </h2><br>";
      echo "<button><a href='../élève/eleve_signup.html'>inscrit mes enfants</a></button>";
      exit();
    } 
  // Vérification de l'existence de l'utilisateur
  $query = "SELECT COUNT(*) FROM pere WHERE email_pere = :email";
  $statement = $connexion->prepare($query);
  $statement->bindParam(':email', $email);
  $statement->execute();

  if ($statement->fetchColumn() > 0 ) {
  // L'utilisateur existe déjà, afficher un message d'erreur
    echo 'Cet email est déjà utilisé. Veuillez choisir un autre email.';
  } else if ($statement->fetchColumn() == 0 ) {
  
  // Préparation de la requête d'insertion
  $query = "INSERT INTO pere (nom_pere, prenom_pere, cin_pere, email_pere, password_pere) VALUES (:nom, :prenom, :cin, :email, :password)";
  $statement = $connexion->prepare($query);
  
  // Bind des valeurs aux paramètres de la requête
  $statement->bindParam(':nom', $nom);
  $statement->bindParam(':prenom', $prenom);
  $statement->bindParam(':cin', $cin);
  $statement->bindParam(':email', $email);
  $statement->bindParam(':password', $hashPassword);
  
  // Hashage du mot de passe (optionnel mais recommandé)
  $hashPassword = password_hash($password, PASSWORD_DEFAULT);
  
  // Exécution de la requête
  if ($statement->execute()) {
    echo 'Inscription réussie !';
    echo '<a href="connexion_pere.html">Se connecter</a>';
  } else {
    echo 'Erreur lors de l\'inscription';
  }
}
} catch (PDOException $e) {
  echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}
?>
			</div>
      </div>
	    <!-- start footer -->
		<footer>
			<div class="container">
				<div class="footer-content">
					<div class="f1">
						<ul>
							<li>
								<a href="../HTML/index.html">Acceuil</a>
							</li>
							<li>
								<a href="../HTML/Formations.html">Formations</a>
							</li>
							<li>
								<a href="../HTML/Evénements.html">Evénements</a>
							</li>
							<li>
								<a href="../HTML/A_Propos.html">A_Propos</a>
							</li>
							<li>
								<a href="../HTML/">Contact</a>
							</li>
						</ul>
					</div>
					<div class="f2">
						<h3>Zouhir El Amraoui</h3>
						<p>Etudiant Ingénieur Dans Système D'informations Et Transformations Digitale</p>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
					</div>
					<div class="f2">
						<h3>Yassine Benhssine</h3>
						<p>Etudiant Ingénieur Dans Système D'informations Et Transformations Digitale</p>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
					</div>
					<div class="f2">
						<h3>Achraf Jarrou</h3>
						<p>Etudiant Ingénieur Dans Système D'informations Et Transformations Digitale</p>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
					</div>
					<div class="f2">
						<h3>Othmane Arejdal</h3>
						<p>Etudiant Ingénieur Dans Système D'informations Et Transformations Digitale</p>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
						<a href="login.html" class="icon" >
							<i class="fa-solid fa-right-to-bracket"></i>
						</a>
					</div>
				</div>
				<h1>@2023->Ce Project Creé Par Notre Groupe Z_A_Y_O </h1>
			</div>
		</footer>
		<!-- end footer -->
</body>
</html>





