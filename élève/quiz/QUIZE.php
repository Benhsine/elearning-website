<!DOCTYPE html>
<html lang="en">
<head>
    <title>QUIZE</title>
    <link rel="stylesheet" href="QUIZE.css">
    <link rel="icon" type="image/png" href="examicone.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia&effect=fire">
</head>
<body>
    <div class="debut">you are ready to take your <?php echo$_GET['subject'];?> exam ?</div>
    <input type="button" class="notready" value="not yet 😐">
    <input type="button" class="ready" value="ready 💪">
    <div class="end">Made with ❤️ by Z.A.Y.O</div>
    <script>
        // Récupérer les références des boutons
        const notReadyButton = document.querySelector('.notready');
        const readyButton = document.querySelector('.ready');

        // Ajouter des écouteurs d'événements pour les clics sur les boutons
        notReadyButton.addEventListener('click', () => {
            // Redirection vers une autre page
            window.location.href = 'notready.html';
        });

        readyButton.addEventListener('click', () => {
            // Redirection vers une autre page
            window.location.href = 'QUESTION.php?subject=<?php echo$_GET['subject'];?>';
        });
    </script>
</body>
</html>