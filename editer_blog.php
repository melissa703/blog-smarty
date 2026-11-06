<?php
require_once 'config_blog.php';

$erreur = '';

// Mode 1 : le formulaire vient d'être envoyé
if (isset($_POST['titre'], $_POST['contenu'], $_POST['categorie'])) {

    // Nettoyage des entrées
    $titre     = trim($_POST['titre']);
    $contenu   = trim($_POST['contenu']);
    $categorie = trim($_POST['categorie']);

    if ($titre === '' || $contenu === '') {
        $erreur = 'Le titre et le contenu sont obligatoires.';
    } else {
        // Respect des tailles des colonnes
        $titre     = mb_substr($titre, 0, 120);
        $categorie = mb_substr($categorie, 0, 12);

        // Annonce : extrait du billet, sans aucune balise
        $annonce = mb_substr(strip_tags($contenu), 0, 100);

        // Requête préparée : protège contre les injections SQL
        $stmt = $connexion->prepare(
            'INSERT INTO billets_blog (titre, contenu, annonce, date_billet, categorie)
             VALUES (?, ?, ?, NOW(), ?)'
        );
        $stmt->bind_param('ssss', $titre, $contenu, $annonce, $categorie);
        $stmt->execute();

        // Redirection vers l'affichage du billet qu'on vient de créer
        $id = $connexion->insert_id;
        header('Location: afficher_blog.php?ID=' . $id);
        exit;
    }
}

// Mode 2 : affichage du formulaire vide (ou avec une erreur)
$smarty->assign('titre', 'Nouveau billet');
$smarty->assign('erreur', $erreur);
$smarty->display('edition_blog.tpl');
