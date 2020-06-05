<?php $title = 'Ajouter un article'; ?>


<?php ob_start(); ?>

<section>
    <div class="containerEditPost">
        <h3 class="titleEditPost">Création d'un article :</h3>
        <form class="formEditPost" action="index.php?action=sendNewPost" method="post">
            <label class="labelEditPost" for="postTitle">Titre :</label>
            <input class="postEditTitle" id="postTitle" name="postTitle" placeholder="Renseignez le titre de votre article" type="text">
            <label class="labelEditPost" for="postContent">Contenu de l'article : </label>
            <textarea class="tinyText" id="postContent" name="postContent"></textarea>
            <button class="sendEditedPost" type="submit">Créer l'article !</button>
        </form>
        <a class="linkBackToPostsManagement" href="index.php?action=adminPostsManagement">Retour à la liste des articles</a>
    </div>
    
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>