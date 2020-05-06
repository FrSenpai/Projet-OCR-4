
<?php ob_start(); ?>

<section>
    <div>
        <h3>Bienvenue sur le dashboard !</h3>
        <div>
            <h4>Gestion des utilisateurs</h4>
            <div>
                <h5>Bannir un utilisateur</h5>
                <form action="index.php?action=banUser" method="post">
                    <label for="pseudo">Pseudo de l'utilisateur</label>
                    <input type="text" name="pseudo">
                    <button type='submit'>Bannir</button>
                </form>
            </div>
            
        </div>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<?php require('view/frontend/template.php'); ?>