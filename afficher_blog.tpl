<html>
<head>
<title>{$titre|escape}</title>
{literal}
<style>
body {
    font-family: sans-serif;
    font-size: 12px;
}
h1 {
    font-size: 20px;
}
.date {
    color: #666;
}
.commentaire {
    margin-bottom: 10px;
}
</style>
<script>
function afficherFormulaire() {
    document.getElementById('formulaire').style.display = 'block';
    document.getElementById('lien_commentaire').style.display = 'none';
}
</script>
{/literal}
</head>
<body>
<a href="index_blog.php">Mon blog</a>

<h1>{$billet.titre|escape}</h1>
<p class="date">{$billet.date}</p>
<p>{$billet.contenu|escape|nl2br}</p>
<p>Catégorie : <a href="index_blog.php?categorie={$billet.categorie|escape:'url'}">{$billet.categorie|escape}</a></p>

<h3>Commentaires</h3>
{section name=i loop=$commentaires}
<div class="commentaire">
    <strong>{$commentaires[i].nom|escape}</strong>
    <span class="date">{$commentaires[i].date}</span><br />
    {$commentaires[i].comment|escape|nl2br}
</div>
{sectionelse}
<p>Aucun commentaire pour le moment.</p>
{/section}

<p id="lien_commentaire"><a href="javascript:afficherFormulaire()">Ajouter un commentaire</a></p>

<div id="formulaire" style="display: none;">
<form method="post" action="commenter_blog.php">
    <input type="hidden" name="ID" value="{$billet.ID}" />
    <p>Nom :<br /><input type="text" name="nom" /></p>
    <p>Commentaire :<br /><textarea name="commentaire" rows="5" cols="40"></textarea></p>
    <p><input type="submit" value="Envoyer" /></p>
</form>
</div>
</body>
</html>
