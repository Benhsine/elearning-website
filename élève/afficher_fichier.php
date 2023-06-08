<?php
if (isset($_GET['fichier'])) {
    $fichier = $_GET['fichier'];
    
    // Vérifier si le fichier est un fichier PDF
    if (strtolower(pathinfo($fichier, PATHINFO_EXTENSION)) === 'pdf') {
        // Définir le type de contenu du fichier en tant que PDF
        header('Content-Type: application/pdf');
    
        // Indiquer au navigateur d'afficher le fichier plutôt que de le télécharger
        header('Content-Disposition: inline; filename="' . $fichier . '"');
    
        // Lire le contenu du fichier et l'envoyer au navigateur
        readfile($fichier);
        exit();
    }
}

// Si le fichier n'est pas un fichier PDF ou si le paramètre 'fichier' est manquant
echo 'Fichier non trouvé ou non pris en charge.';
?>
