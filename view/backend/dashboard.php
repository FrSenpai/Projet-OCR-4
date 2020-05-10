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


    <div>
        <h4>Commentaires signalés :</h4>
        <?php 
            while ($commentsReported = $comments->fetch()) {
                ?>
                <p><?= $commentsReported['user']; ?> : <?= $commentsReported['content']; ?></p>
                <a href='index.php?action=deleteComment&commentId=<?= $commentsReported['id'] ?>'>Supprimer le commentaire</a>
                <a href='index.php?action=banUser&pseudo=<?= $commentsReported['user']; ?>'>Bannir l'utilisateur</a>
                <?php
            }
        ?>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>