<?= $title = 'Panel administrateur'; ?>

<?php ob_start(); ?>

<section>
    <div>
        <h3>Bienvenue sur le dashboard !</h3>
        <ul>
            <li><a href="index.php?action=adminPostsManagement">Gestion des article</a></li>
            <li>Gestion des articles</li>
            <li>Gestion des commentaires</li>
        </ul>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>