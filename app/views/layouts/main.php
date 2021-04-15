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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!--Styles-->
    <?php if($tagifyNeeded) echo '<link rel="stylesheet" href="/css/tagify.css"  type="text/css">'?>
    <link rel="stylesheet" href="/css/style.css" type="text/css">

    <title><?= $title?></title>
</head>
<body>
    <header class="sticky-top">
        <div class="container">
            <nav>
                <a href="/" class="navbar-brand">
                    code
                </a>
                <div class="navbar">
                    <div>
                        <a title="rechercher">
                            <i class="fas fa-search" aria-label="Rechercher"></i>
                        </a>
                        <form id="search">
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
    <div class="container">
        <?php if(Application::$app->session->hasFlashes()):?>
            <?php foreach(Application::$app->session->getFlashes() as $type => $message): ?>
                <div class=" alert alert-<?=$type?>">
                    <?= $message?>
                </div>
    
        <?php endforeach; endif ?>
    </div>
    <main>
    {{-content-}}
    </main>
  
    <footer>
        <div class="container">
            <p>&copy <a href="https://github.com/Mel-MB">Mel MB</a> _ Greta 2021</p>
        </div>
    </footer>
    <script src="/js/main.js"></script>
</body>
</html>