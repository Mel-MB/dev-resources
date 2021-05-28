<?php
use Project\Core\Application;
$path = $_SERVER['REQUEST_URI'];
$tagifyNeeded = preg_match('/^(\/post\/publier)|(\/post\/modifier\/)|(\/modifier-mon-compte)/', $path);
$router = Application::$app->router;
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
    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Raleway:wght@200;400;500;700&display=swap" rel="stylesheet">
    <?php if($tagifyNeeded) echo '<link rel="stylesheet" href="/css/tagify.css"  type="text/css">'?>
    <link rel="stylesheet" href="/css/style.css" type="text/css">

    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">
    <title><?= $title?></title>
</head>
<body>
    <header class="sticky-top">
        <div class="container">
            <nav>
                <a href="/" class="navbar-brand">
                    <div class="wrapper">
                        <svg width="185" height="100" version="1.1" class="logo" xmlns="http://www.w3.org/2000/svg" >
                            <defs>  
                                <linearGradient id="gradient" x1="100%" y1="100%">
                                    <stop offset="0%" stop-color="lightblue" stop-opacity=".7">
                                        <animate attributeName="stop-color" values="lightblue;cyan;lightsalmon;lightsalmon;black;lightsalmon;lightsalmon;orchid;lightblue" dur="14s" repeatCount="indefinite" />
                                    </stop>
                                    <stop offset="100%" stop-color="lightblue" stop-opacity=".7">
                                        <animate attributeName="stop-color" values="lightblue;orange;lightsalmon;orchid;orchid;orchid;orchid;cyan;lightblue" dur="10s" repeatCount="indefinite" />
                                        <animate attributeName="offset" values=".95;.80;.60;.40;.20;.20;0;.20;.40;.60;.80;.95" dur="10s" repeatCount="indefinite" />
                                    </stop>
                                </linearGradient>
                            </defs>   
                            <text y='40' x="50%" class="dev center">
                                dev
                            </text>
                            <text y='70' x="50%" class="ressources center" fill="url('#gradient')">
                                Ressources
                            </text>               
                        </svg>
                    </div>
                </a>
                <div class="navbar">
                    <div>
                        <a title="rechercher">
                            <i class="fas fa-search" aria-label="Rechercher"></i>
                        </a>
                        <form id="search" action="/rechercher">
                            <i class="fas fa-search" aria-label="Rechercher"></i>
                            <input type="text" placeholder="Je recherche un article sur..." aria-label="Barre de recherche">
                        </form>
                    </div>
                    <ul>
                        <?php if(Application::$app->isGuest()){
                            require_once('_navGuest.php');
                        }else{
                            require_once('_navAuth.php');
                        }?>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main id="content">
        <?php if(Application::$app->session->hasFlashes()):?>
            <div class="container">
                <?php foreach(Application::$app->session->getFlashes() as $type => $message): ?>
                    <div class="alert alert-<?=$type?>">
                        <?= $message?>
                    </div>
        
                <?php endforeach?>
            </div>
        <?php endif?>
        {{-content-}}
    </main>
  
    <footer class="bg-primary bg-up">
        <div class="container">
            <p>&copy <a href="https://github.com/Mel-MB" class="secondary">Mel MB</a> _ Greta 2021</p>
            <div class="socials">
                <a href="https://github.com/Mel-MB"><i class="fab fa-github" aria-label="Github"></i></a>
                <a href="https://www.linkedin.com/in/m%C3%A9lanie-mirbeau-baudin-bbb906155/"><i class="fab fa-linkedin-in" aria-label="Linkedin"></i></a>
            </div>
        </div>
    </footer>
    <script src="/js/main.js"></script>
</body>
</html>