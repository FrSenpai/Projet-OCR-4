<?php $title = 'Gestion des articles'; ?>

<?php ob_start(); ?>

<section>
    <div id="containerPostsManagement">
        <h3 id="titleListPosts">Liste des articles :</h3>

        <?php 
            
            while ($post = $nbPost->fetch()) {
                ?>
                <div class="containerListPosts">
                    <h4 class="titleReqPost"><?= $post['title']; ?></h4>
                    <div class="containerActionsPosts">
                        <a href="index.php?action=editPost&id=<?= $post['id']; ?>">Modifier</a>
                        <a href="index.php?action=deletePost&id=<?= $post['id']; ?>">Supprimer</a>
                    </div>
                </div>
        <?php
            }
                ?>

        <div class="containerPagination">
            <?php 
            //Pagination de la liste des posts
            if ($page > 1) {
                ?>
                <a class="linkPagination" href="?action=adminPostsManagement&page=<?php echo $page - 1; ?>">Page précédente</a>
            <?php
            }

            for ($i = 1; $i <=$nombreDePages; $i++) {
                ?>
                <a class="linkPagination" href="?action=adminPostsManagement&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php
            }
            
            if ($page < $nombreDePages) {
                ?>
                <a class="linkPagination" href="?action=adminPostsManagement&page=<?php echo $page + 1; ?>">Page suivante</a>
            <?php
            }
            
            ?>

        </div>
        <a id="linkCreatePost" href="index.php?action=addPost">Ajouter un nouvel article</a>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>