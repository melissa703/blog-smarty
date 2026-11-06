<?php
require_once 'config_blog.php';

// 1. Vérifier que l'identifiant est correct
$id = isset($_POST['ID']) ? (int) $_POST['ID'] : 0;

if ($id <= 0) {
    http_response_code(400);
    die('Identifiant de billet invalide.');
}

// ... et qu'il correspond à un billet existant
$stmt = $connexion->prepare('SELECT ID FROM billets_blog WHERE ID = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    http_response_code(404);
    die('Ce billet n\'existe pas.');
}

// 2. Nettoyer le nom et le commentaire
$nom         = isset($_POST['nom']) ? trim($_POST['nom']) : '';
$commentaire = isset($_POST['commentaire']) ? trim($_POST['commentaire']) : '';

if ($nom !== '' && $commentaire !== '') {
    $nom = mb_substr($nom, 0, 50);

    // 3. Enregistrer le commentaire (la date se remplit toute seule)
    $stmt = $connexion->prepare(
        'INSERT INTO commentaires_blog (nom, comment, ID) VALUES (?, ?, ?)'
    );
    $stmt->bind_param('ssi', $nom, $commentaire, $id);
    $stmt->execute();
}

// 4. Retour à la page du billet
header('Location: afficher_blog.php?ID=' . $id);
exit;
