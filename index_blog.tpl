<html>
<head>
<title>{$titre|escape}</title>
{literal}
<style>
body {
    font-family: sans-serif;
    font-size: 12px;
}
table.billets {
    font-size: 12px;
}
table.billets td {
    padding-bottom: 7px;
}
.entete {
    font-size: 14px;
    font-weight: bold;
}
.date {
    color: #666;
}
</style>
{/literal}
</head>
<body>
<a href="index_blog.php">Mon blog</a>

<table class="billets">
{section name=b loop=$billets}
<tr>
    <td>
        <a class="entete" href="afficher_blog.php?ID={$billets[b].ID|escape:'url'}">{$billets[b].titre|escape}</a><br />
        <span class="date">{$billets[b].date}</span><br />
        {$billets[b].annonce|escape}<br />
        Catégorie : <a href="index_blog.php?categorie={$billets[b].categorie|escape:'url'}">{$billets[b].categorie|escape}</a>
    </td>
</tr>
{sectionelse}
<tr><td>Aucun billet pour le moment.</td></tr>
{/section}
</table>
<p><a href="editer_blog.php">Nouveau billet</a></p>
</body>
</html>
