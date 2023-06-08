<!DOCTYPE html>
<!--
<html>
<head>
  <title>Formulaire de Connexion</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
  <h2>Connexion</h2>
  <form action="traitement_connexion_prof.php" method="POST">
    <div>
      <label for="email">Email :</label>
      <input type="email" name="email" id="email" required>
    </div>
    <div>
      <label for="password">Mot de passe :</label>
      <input type="password" name="password" id="password" required>
    </div>
    <div>
      <input type="submit" value="Se connecter">
    </div>
  </form>
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
$email = $_POST['email'];
$password = $_POST['password'];

// Informations de connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=bd_elearning';
$utilisateur = 'root';
$motDePasse = '';

try {
  // Création d'une instance de PDO
  $connexion = new PDO($dsn, $utilisateur, $motDePasse);

  // Configuration des options de PDO
  $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Préparation de la requête pour récupérer les informations de l'utilisateur
  $requete = "SELECT id_ens, nom_ens, prenom_ens, email_ens, password_ens FROM enseignant WHERE email_ens = :email";
  $statement = $connexion->prepare($requete);
  $statement->bindParam(':email', $email);
  $statement->execute();

  // Récupération du résultat
  $utilisateur = $statement->fetch(PDO::FETCH_ASSOC);

  // Vérification du mot de passe
  if ($utilisateur && verifyPassword($password, $utilisateur['password_ens'])){
    // Authentification réussie
    session_start();
    $_SESSION['id'] = $utilisateur['id_ens'];
    $_SESSION['nom'] = $utilisateur['nom_ens'];
    $_SESSION['prenom'] = $utilisateur['prenom_ens'];
    $_SESSION['email'] = $utilisateur['email_ens'];

    // Redirection vers une page de succès ou à l'intérieur de l'application
    header('Location: prof.html');
    exit();
  } else {
    // Mot de passe incorrect ou utilisateur non trouvé
    echo 'Mot de passe incorrect ou utilisateur non trouvé.';
  }
} catch (PDOException $e) {
  // Gestion des erreurs de connexion à la base de données
  echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}

// Fonction pour vérifier le mot de passe
function verifyPassword($password, $hashedPassword) {
  // Votre logique de vérification de mot de passe ici
  // Par exemple, vous pouvez utiliser une autre fonction de hachage comme password_hash()
  // ou utiliser une bibliothèque de hachage comme bcrypt ou Argon2

  // Exemple basique avec password_verify()
  return password_verify($password, $hashedPassword);
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

