<?= $title = 'Gestion des articles'; ?>

<?php ob_start(); ?>

<section>
    <div>
        <h3>Liste des articles :</h3>
        <?php 
            
            while ($post = $nbPost->fetch()) {
                ?>
                <h4><?= $post['title']; ?></h4>
                <p>Actions :</p>
                <ul>
                    <li>Modifier</li>
                    <li>Supprimer</li>
                </ul>

                <?php
            }
                ?>
            <?php 
            //Pagination de la liste des posts
            if ($page > 1) {
                ?>
                <a href="?action=adminPostsManagement&page=<?php echo $page - 1; ?>">Page précédente</a>
                <?php
            }

            for ($i = 1; $i <=$nombreDePages; $i++) {
                ?>
                <a href="?action=adminPostsManagement&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php
            }
            
            if ($page < $nombreDePages) {
                ?>
                <a href="?action=adminPostsManagement&page=<?php echo $page + 1; ?>">Page suivante</a>
                <?php
            }
            
            ?>
        <p>Ajouter un nouvel article</p>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>