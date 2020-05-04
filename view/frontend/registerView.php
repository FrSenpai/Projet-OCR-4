
<?php ob_start(); ?>

<div>
    <h3>Inscrivez-vous !</h3>
    <form action="index.php?action=addUser" method="post">
        <input name='pseudo' type="text" placeholder='Pseudo'>
        <input name='password' type="password" placeholder='Mot de passe'>
        <button type='submit'>S'inscrire !</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>