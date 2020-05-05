<?php $title = 'PostById'; ?>

<?php ob_start(); ?>



<article>
    <h3>
        <?= htmlspecialchars($postById['title']); ?>
        <em>le <?= $postById['creation_date_fr'] ?></em>
    </h3>

    <p>
        <?= htmlspecialchars($postById['content']); ?>
        <br />
    </p>
    <?php 

        if (isset($_SESSION['pseudo'])) {
            ?>  
                <div>
                    <form action='index.php?action=addComment&amp;postId=<?= $postById['id'] ?>' method='post'>
                        <p>Ajouter un commentaire !</p>
                        <input type="text" name='content' placeholder='Votre commentaire'>
                        <button type='submit'>Envoyer !</button>
                    </form>
                </div>
            <?php
        } else {
            ?>
                <div>
                    <p>Vous devez être connecté afin de poster un commentaire.</p>
                </div>
            <?php
        }

    ?>
    


    <?php 
    while ($comment = $comments->fetch()) {
        ?>
    <div>
        <?php 
        //Si le commentaire a été signalé, on affiche un message en conséquence
        if ($comment['reported'] > 0) {
            ?>
            <p><?= htmlspecialchars($comment['user']); ?> le <?= $comment['comment_date_fr']; ?></p>
            <p>Ce commentaire à été signalé, il ne sera pas affiché.</p>
            <?php
        } else {
            ?>
            <p><strong><?= htmlspecialchars($comment['user']) ?></strong> le <?= $comment['comment_date_fr'] ?>
            <a href="index.php?action=reportComment&amp;commentId=<?= $comment['id'] ?>&amp;postId=<?= $postById['id']; ?>">Signaler</a></p>
            <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
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