<?php $title = 'Lecture d\'un article'; ?>

<?php ob_start(); ?>



<article id="containerPost">
    <h3 id="titlePost"><?= htmlspecialchars($postById['title']); ?></h3>
    <p>
        <?= $postById['content']; ?>
    </p>
    <em id="datePost">le <?= $postById['creation_date_fr'] ?></em>
    <?php 

        if (isset($_SESSION['pseudo'])) {
            ?>  
                <div class="containerAddComment">
                    <form id="formComment" action='index.php?action=addComment&amp;postId=<?= $postById['id'] ?>' method='post'>
                        <p class="headComment">Ajouter un commentaire :</p>
                        <textarea id="textareaContent" type="text" name='content' placeholder='Votre commentaire'></textarea>
                        <button class="sendForm" type='submit'>Envoyer !</button>
                    </form>
                </div>
            <?php
        } else {
            ?>
                <div class="containerAddComment">
                    <p>Vous devez être connecté afin de poster un commentaire.</p>
                </div>
            <?php
        }

    ?>
    


    <?php 
    while ($comment = $comments->fetch()) {
        ?>
    <div id="containerComment">
        <?php 
        //Si le commentaire a été signalé, on affiche un message en conséquence
        if ($comment['reported'] > 0) {
            ?>
            <p class="headComment"><?= htmlspecialchars($comment['user']); ?> le <?= $comment['comment_date_fr']; ?></p>
            <p>Ce commentaire à été signalé, il ne sera pas affiché.</p>
            <?php
        } else {
            ?>
            <p class="headComment">
                <strong>
                    <?= htmlspecialchars($comment['user']) ?>
                </strong>
                le <?= $comment['comment_date_fr'] ?> - 
                <a class="linkReport" href="index.php?action=reportComment&amp;commentId=<?= $comment['id'] ?>&amp;postId=<?= $postById['id']; ?>">Signaler</a>
            </p>
            <p id="commentContent"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
        <?php
        }
        ?>
    </div>
    <?php
    }
        ?>
</article>




<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>