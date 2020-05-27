<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" type="text/css" href="public/css/style.css" />
    <link rel="stylesheet" type="text/css" media="(max-width: 800px)" href="public/css/style_responsive.css" />
    <link href="https://fonts.googleapis.com/css?family=Oxanium:200&display=swap" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/n0zjjp855koo6c45xxa86ptqybm4b9eakycd7lrnyr7nrcd2/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
        selector: '.tinyText',
        height: "500px"
        });
    </script>
</head>

<body>
    <header>
        <nav>
            <h1 id="titleNav"><a href="index.php" id='titleLink'>Jean Forteroche - Un billet simple pour l'Alaska</a></h1>
            <?php 
            if (isset($_SESSION['pseudo'])) {
                ?>
                    <div id="containerNav">
                        <ul id="listeNav">
                            
                            <?php 
                                if (isset($_SESSION['isAdmin']) > 0) {
                                    ?>
                                        <li class="elemNav"><a class="linkNav" href="index.php?action=adminPanel">Panneau d'administration</a></li>
                                    <?php
                                }
                            ?>
                            <li class="elemNav"><a class="linkNav" href="index.php?action=logout">Deconnexion</a></li>
                        </ul>
                    </div>
                <?php 
            } else {
                ?>
                    <div id='containerLogin'>
                        <form id="formLogin" action='index.php?action=login' method="post">
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

    <?= $content; ?>

</body>

<footer>
    <span><a class="linkNav" target="_blank" href="https://www.linkedin.com/in/alexandre-parjouet-b197aa1a1/">@Alexandre Parjouet</a></span>
</footer>

</html>
<?php 