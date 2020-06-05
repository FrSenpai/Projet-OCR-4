<?php $title = "Inscription"; ?>
<?php ob_start(); ?>

<div id="containerRegister">
    <h3 id="titleRegister">Inscrivez-vous !</h3>
    <form id="formRegister" action="index.php?action=addUser" method="post">
        <label for="pseudo">Pseudo :</label>
        <input class="inputRegister" id="pseudo" name='pseudo' type="text" placeholder='Pseudo'>
        <label for="password">Mot de passe:</label>
        <input class="inputRegister" id="password" name='password' type="password" placeholder='Mot de passe'>
        <button id="sendRegister" type='submit'>S'inscrire !</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>