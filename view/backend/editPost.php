<!DOCTYPE html>
<?= $title = 'Editer un article'; ?>

<?php ob_start(); ?>

<section>
    <div>
        <h3>Edition d'un article :</h3>
        <form action="index.php?action=sendEditedPost&id= <?= $post['id']; ?>" method="post">
            <input id="postTitle" name="postTitle" value="<?= $post['title']; ?>" type="text">
            <textarea class="tinyText" id="postContent" name="postContent"><?= $post['content']; ?></textarea>
            <button type="submit">Mettre à jour l'article !</button>
        </form>
        <a href="index.php?action=adminPostsManagement">Retour à la liste des articles</a>
    </div>
    
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>