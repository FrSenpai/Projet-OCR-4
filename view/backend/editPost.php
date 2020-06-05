<?php $title = 'Editer un article'; ?>


<?php ob_start(); ?>

<section>
    <div class="containerEditPost">
        <h3 class="titleEditPost">Edition d'un article :</h3>
        <form class="formEditPost" action="index.php?action=sendEditedPost&id=<?= $post['id']; ?>" method="post">
            <label class="labelEditPost" for="postTitle">Titre :</label>
            <input class="postEditTitle" id="postTitle" name="postTitle" value="<?= $post['title']; ?>" type="text">
            <label class="labelEditPost" for="editPostContent">Contenu de l'article : </label>
            <textarea class="tinyText" id="editPostContent" name="postContent"><?= $post['content']; ?></textarea>
            <button class="sendEditedPost" type="submit">Mettre à jour l'article !</button>
        </form>
        <a class="linkBackToPostsManagement" href="index.php?action=adminPostsManagement">Retour à la liste des articles</a>
    </div>
    
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>