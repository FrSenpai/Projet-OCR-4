<?php $title = 'Accueil'; ?>

<?php ob_start(); ?>

<div id='containerDescriptionAuthor'>
    <figure>
        <img src="public/images/alain-laroche-fictif" alt="Avatar Alain Laroche" id="avatarAuthor">
    </figure>
    <figcaption>
        <p id='descriptionAuthor'>Erat gratulatio antea decrevi Mario idem quot ex hominis est et immortalibus antea
            admirentur C homines meum.</p>
    </figcaption>
</div>

<section>
    <h2>Articles récents !</h2>
    <?php 
while ($data = $posts->fetch()) {
?>
    <a href='index.php?action=post&amp;id=<?= $data['id'] ?>'>
        <article>
            <h3>
                <?= htmlspecialchars($data['title']); ?>
                <em>le <?= $data['creation_date_fr'] ?></em>
            </h3>

            <p>
                <?= htmlspecialchars($data['content']); ?>
                <br />
            </p>
        </article>
    </a>

    <?php 
}
$posts->closeCursor();

?>
</section>




<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>