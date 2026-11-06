<?php
require_once 'config_blog.php';

// 1. Filtre éventuel par catégorie (requête préparée : pas d'injection SQL)
$categorie = isset($_GET['categorie']) ? trim($_GET['categorie']) : '';
$categorie = mb_substr($categorie, 0, 12);

if ($categorie !== '') {
    $stmt = $connexion->prepare(
        'SELECT ID, titre, annonce, date_billet, categorie
         FROM billets_blog
         WHERE categorie = ?
         ORDER BY date_billet DESC'
    );
    $stmt->bind_param('s', $categorie);
    $titre = 'Mon blog - ' . $categorie;
} else {
    $stmt = $connexion->prepare(
        'SELECT ID, titre, annonce, date_billet, categorie
         FROM billets_blog
         ORDER BY date_billet DESC'
    );
    $titre = 'Mon blog';
}

// 2. Récupérer les billets
$stmt->execute();
$resultat = $stmt->get_result();

$billets = array();
while ($ligne = $resultat->fetch_assoc()) {
    $billets[] = array(
        'ID'        => $ligne['ID'],
        'titre'     => $ligne['titre'],
        'annonce'   => $ligne['annonce'],
        'date'      => date('d/m/Y à H:i', strtotime($ligne['date_billet'])),
        'categorie' => $ligne['categorie']
    );
}

// 3. Afficher le template
$smarty->assign('titre', $titre);
$smarty->assign('billets', $billets);
$smarty->display('index_blog.tpl');
