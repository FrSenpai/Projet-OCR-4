<?php $title = 'Panel administrateur'; ?>

<?php ob_start(); ?>

<section>
    <div id="containerTitleDashboard">
        <h3 id="titleDashboard">Bienvenue sur le dashboard !</h3>
        <a id="linkPostsManagement" href="index.php?action=adminPostsManagement">Gestion des articles</a>
    </div>


    <div id="containerReportedComment">
        <h4 id="titleReportedComment">Commentaires signalés :</h4>
        <?php 
            if (!$nombreDeCommentaires > 0) {
                ?>
        <p>Il n'y a aucun commentaire signalé actuellement.</p>
        <?php
            } else {
                while ($commentsReported = $nbComment->fetch()) {
                ?>
                    <div class="containerAffectedComment">
                        <p id="contentCommentReported"><?= $commentsReported['user']; ?> : <?= $commentsReported['content']; ?></p>
                            <div id="containerActionsComment">
                                <a class="linkActionsComment"
                                        href='index.php?action=deleteComment&commentId=<?= $commentsReported['id']; ?>'>Supprimer le
                                        commentaire</a>
                                <a class="linkActionsComment"
                                        href='index.php?action=banUser&pseudo=<?= $commentsReported['user']; ?>'>Bannir
                                        l'utilisateur</a>
                                <a class="linkActionsComment"
                                        href="index.php?action=unreportComment&id=<?= $commentsReported['id']; ?>">Annuler le
                                        signalement</a>
                            </div>
                    </div>
                <?php
                    }
                }
            
                ?>
        <div class="containerPagination">
            <?php
            if ($page > 1) {
            ?>
                <a class="linkPagination" href="?action=adminPanel&page=<?php echo $page - 1; ?>">Page précédente</a>
            <?php
            }

            for ($i = 1; $i <=$nombreDeCommentaires; $i++) {
                        ?>
                <a class="linkPagination" href="?action=adminPanel&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php
            }
            
            if ($page < $nombreDeCommentaires) {
                        ?>
                <a class="linkPagination" href="?action=adminPanel&page=<?php echo $page + 1; ?>">Page suivante</a>
            <?php
            }
                    ?>
        </div>
        <?php

    $nbComment->closeCursor();
            
        ?>
    </div>



    <div id="containerStats">
        <h4 id="titleStats">Statistiques</h4>
        <p>Il y a <?= $nbUsers; ?> utilisateur(s) inscrit(s).</p>
        <p>Le blog recense <?= $nbPosts; ?> article(s) dont <?= $nbComments ?> commentaire(s).</p>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>