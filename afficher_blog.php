<?php
require_once 'config_blog.php';

// 1. Vérifier le paramètre ID
$id = isset($_GET['ID']) ? (int) $_GET['ID'] : 0;

if ($id <= 0) {
    http_response_code(400);
    die('Identifiant de billet invalide.');
}

// 2. Chercher le billet dans la base
$stmt = $connexion->prepare(
    'SELECT ID, titre, contenu, categorie, date_billet
     FROM billets_blog
     WHERE ID = ?'
);
$stmt->bind_param('i', $id);
$stmt->execute();
$billet = $stmt->get_result()->fetch_assoc();

if (!$billet) {
    http_response_code(404);
    die('Ce billet n\'existe pas.');
}
$billet['date'] = date('d/m/Y à H:i', strtotime($billet['date_billet']));

// 3. Chercher les commentaires du billet
$stmt = $connexion->prepare(
    'SELECT nom, comment, date_comment
     FROM commentaires_blog
     WHERE ID = ?
     ORDER BY date_comment ASC'
);
$stmt->bind_param('i', $id);
$stmt->execute();
$resultat = $stmt->get_result();

$commentaires = array();
while ($ligne = $resultat->fetch_assoc()) {
    $commentaires[] = array(
        'nom'     => $ligne['nom'],
        'comment' => $ligne['comment'],
        'date'    => date('d/m/Y à H:i', strtotime($ligne['date_comment']))
    );
}

// 4. Afficher le template
$smarty->assign('titre', $billet['titre']);
$smarty->assign('billet', $billet);
$smarty->assign('commentaires', $commentaires);
$smarty->display('afficher_blog.tpl');
