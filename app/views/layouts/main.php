<?php

use Project\Core\{Application};

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $description ?>">
    <!--Fontawesome-->
    <script src="https://kit.fontawesome.com/b6cd7159ce.js" crossorigin="anonymous"></script>
    <!--Styles-->
    <link rel="stylesheet" src="<?= Application::$ROOT_DIR.'\public\styles\style.css'?>">

    <title><?= $title?></title>
</head>
<body>
    <header class="sticky-top">
        <div class="container">
            <nav class="navbar navbar-light ">
                <a href="index.php" class="navbar-brand">
                    code
                </a>
                <ul class="navbar-nav flex-row ml-auto">
                    <li class="nav-item mx-2">
                        <a href="/s-inscrire" class="nav-link">S'inscrire</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a href="/se-connecter" class="nav-link btn btn-primary">Se connecter</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
    {{-content-}}
    </main>
  
    <footer>
        <div class="container">
            <p>&copy <a href="https://github.com/Mel-MB">Mel MB</a> _ Greta 2021</p>
        </div>
    </footer>
</body>
</html>