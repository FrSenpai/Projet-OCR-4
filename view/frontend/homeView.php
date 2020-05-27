<?php $title = 'Accueil'; ?>

<?php ob_start(); ?>

<div id='containerDescriptionAuthor'>
    <figure>
        <img src="public/images/alain-laroche-fictif" alt="Avatar Alain Laroche" id="avatarAuthor">
        <figcaption>
            <p id='descriptionAuthor'>Erat gratulatio antea decrevi Mario idem quot ex hominis est et immortalibus antea
            admirentur C homines meum.</p>
        </figcaption>
    </figure>
    
</div>

<section id="sectionArticles">
    <h2 id="titreSectionArticles">Articles récents !</h2>
    <?php 
while ($data = $posts->fetch()) {
?>
        <article>
            <div id='divTitlePosts'>
                <h3><a href='index.php?action=post&amp;id=<?= $data['id']; ?>'><?= htmlspecialchars($data['title']); ?></a></h3>
                <p>: le <?= $data['creation_date_fr'] ?></p>
            </div>
            
            <div id='postContent'> 
                <?= $data['content']; ?>
            </div>
            <div>
                <a id="readMore" href="index.php?action=post&amp;id=<?= $data['id'] ?>">Lire la suite</a>
            </div>
            
            
            
        </article>
    <?php 
}
$posts->closeCursor();

?>
</section>




<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>