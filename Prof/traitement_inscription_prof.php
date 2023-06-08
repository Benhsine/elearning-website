<!--
<!DOCTYPE html>
<html>
<head>
  <title>Inscription Enseignant</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <div class="container">
    <h2>Inscription Enseignant</h2>
    <form id="inscriptionForm" action="traitement_inscription_prof.php" method="post">
      <input type="text" name="nom" placeholder="Nom" required>
      <input type="text" name="prenom" placeholder="Prenom" required>
      <input type="text" name="cin" placeholder="cin" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Mot de passe" required>
      <button type="submit">S'inscrire</button>
    </form>
  </div>
</body>
</html>
-->
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
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
		<style>
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
			    margin-bottom: 40px;
			}
			.container {
				position: relative;
				text-align: center;
			}
			form{
				margin: 45px 0;
				border: 2px solid blue;
				border-radius: 25px;
				padding: 20px;
				background-color: #faf6f6;
			}
            @media (min-width:768px){
				form {
				padding: 20px 30px;
				border: 2px solid blue;
				margin: 50px 350px;
				border-radius: 25px;
			}
			}
			input {
				padding: 5px 25px;
				text-align: center;
				border: 1px solid blue;
				border-radius: 10px;
			}
			.submit:hover{
				background-color: aqua;
				border: 2px solid blue;
				font-weight: bold;
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
	<!-- start form -->
    <div class="container">
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
  $query = "SELECT COUNT(*) FROM enseignant WHERE email_ens = :email";
  $statement = $connexion->prepare($query);
  $statement->bindParam(':email', $email);
  $statement->execute();

  if ($statement->fetchColumn() > 0) {
  // L'utilisateur existe déjà, afficher un message d'erreur
    echo 'Cet email est déjà utilisé. Veuillez choisir un autre email.';
  } else {
  
  // Préparation de la requête d'insertion
  $query = "INSERT INTO enseignant (nom_ens, prenom_ens, cin_ens, email_ens, password_ens) VALUES (:nom, :prenom, :cin, :email, :password)";
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
    echo '<a href="connexion_prof.html">Se connecter</a>';
  } else {
    echo 'Erreur lors de l\'inscription';
  }
}
} catch (PDOException $e) {
  echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}
?>

	  </div>
	<!-- end form -->
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
		<script type="text/javascript" src="script.js"></script>
</body>
</html>

