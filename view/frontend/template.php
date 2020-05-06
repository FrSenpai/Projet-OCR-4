<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Oxanium:200&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <h1><a href="index.php" id='titleLink'>Jean Forteroche - Un billet simple pour l'Alaska</a></h1>
            <?php 
            if (isset($_SESSION['pseudo'])) {
                ?>
                    <div>
                        <ul>
                            <li><a href="index.php?action=logout">Deconnexion</a></li>
                            <?php 
                                if (isset($_SESSION['isAdmin']) > 0) {
                                    ?>
                                        <li><a href="index.php?action=adminPanel">Panneau d'administration</a></li>
                                    <?php
                                }
                            ?>
                        </ul>
                    </div>
                <?php 
            } else {
                ?>
                    <div id='containerLogin'>
                        <form action='index.php?action=login' method="post">
                            <input type="text" name="pseudo" class='inputNav' placeholder="Pseudo" />
                            <input type="password" name="password" class='inputNav' placeholder="Mot de passe" />
                            <button type="submit" id='sendButton'>Envoyer!</button>
                        </form>
                        <a href="index.php?action=register" id="registerLink">Pas encore inscrit ?</a>
                    </div>
                <?php
            }
            ?>
            
                
            
        </nav>
    </header>

    <?= $content ?>
</body>

<footer>@Alexandre Parjouet</footer>

</html>
<?php 