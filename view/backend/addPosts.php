<!DOCTYPE html>
<?= $title = 'Ajouter un article'; ?>

<?php ob_start(); ?>

<section>
    <div>
        <h3>Création d'un article :</h3>
        <form action="index.php?action=sendNewPost" method="post">
            <input id="postTitle" name="postTitle" placeholder="Renseignez le titre de votre article" type="text">
            <textarea class="tinyText" id="postContent" name="postContent"></textarea>
            <button type="submit">Créer l'article !</button>
        </form>
    </div>
    
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>