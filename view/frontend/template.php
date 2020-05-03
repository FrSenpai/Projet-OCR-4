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
            
            <div id='containerLogin'>
                <form method="post">
                    <input type="text" name="login" class='inputNav' placeholder="Pseudo" />
                    <input type="password" name="password" class='inputNav' placeholder="Mot de passe" />
                    <button type="submit" id='sendButton'>Envoyer!</button>
                </form>
                <a href="#" id="registerLink">Pas encore inscrit ?</a>
            </div>
                
            
        </nav>
    </header>

    <?= $content ?>
</body>

<footer>@Alexandre Parjouet</footer>

</html>
<?php 