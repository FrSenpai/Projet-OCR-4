<?= $title = 'Panel administrateur'; ?>

<?php ob_start(); ?>

<section>
    <div>
        <h3>Bienvenue sur le dashboard !</h3>
        <p><a href="index.php?action=adminPostsManagement">Gestion des articles</a></p>
    </div>


    <div>
        <h4>Commentaires signalés :</h4>
        <?php 
            while ($commentsReported = $nbComment->fetch()) {
                ?>
                <p><?= $commentsReported['user']; ?> : <?= $commentsReported['content']; ?></p>
                <a href='index.php?action=deleteComment&commentId=<?= $commentsReported['id']; ?>'>Supprimer le commentaire</a>
                <a href='index.php?action=banUser&pseudo=<?= $commentsReported['user']; ?>'>Bannir l'utilisateur</a>
                <a href="index.php?action=unreportComment&id=<?= $commentsReported['id']; ?>">Annuler le signalement</a>
                <?php
            }
            if ($page > 1) {
                ?>
                <a href="?action=adminPanel&page=<?php echo $page - 1; ?>">Page précédente</a>
                <?php
            }

            for ($i = 1; $i <=$nombreDeCommentaires; $i++) {
                ?>
                <a href="?action=adminPanel&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php
            }
            
            if ($page < $nombreDeCommentaires) {
                ?>
                <a href="?action=adminPanel&page=<?php echo $page + 1; ?>">Page suivante</a>
                <?php
            }

            $nbComment->closeCursor();
            
        ?>
    </div>
    <div>
        <h4>Statistiques</h4>
        <p>Il y a <?= $nbUsers; ?> utilisateur(s) inscrit(s).</p>
        <p>Le blog recense <?= $nbPosts; ?> article(s) dont <?= $nbComments ?> commentaire(s).</p>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>