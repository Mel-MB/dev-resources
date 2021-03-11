<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $data['description']?>">
    <!--Fontawesome-->
    <script src="https://kit.fontawesome.com/b6cd7159ce.js" crossorigin="anonymous"></script>
    <!--Styles-->
    <link rel="stylesheet" href="./app/public/front/styles/style.css">
    <title><?= $data['title']?></title>
</head>
<body>
    <header class="sticky-top">
        <div class="container">
            <nav class="navbar navbar-light ">
                <a href="index.php" class="navbar-brand">
                    code
                </a>
                <ul class="navbar-nav flex-row ml-auto">
                    <?php 
                    //NAV for connected user
                    if(isset($_SESSION['id'])):?>
                        <li class="nav-item mx-2">
                            <a href="index.php?action=post-create" class="nav-link">
                                <i class="fas fa-plus"></i>
                            </a>
                        </li>
                        
                        <li class="nav-item mx-2">
                            <a href="index.php?action=my-posts" class="nav-link">
                                <i class="fas fa-newspaper"></i>
                            </a>
                        </li>
                        <li class="nav-item mx-2">
                            <a href="index.php?action=signout" class="nav-link">
                                <i class="fas fa-power-off" aria-label="se déconnecter"></i>
                            </a>
                        </li>
                        <li class="nav-item mx-2">
                            <a href="index.php?action=my-account" class="nav-link btn btn-primary"><?=$_SESSION['pseudo']?></a>
                        </li>
                        <?php  
                    // NAV without user connection 
                    else: ?>
                        <li class="nav-item mx-2">
                            <a href="index.php?action=signup" class="nav-link">S'inscrire</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a href="index.php?action=login" class="nav-link btn btn-primary">Se connecter</a>
                        </li>
                    <?php endif ?>
                    </ul>
            </nav>
        </div>
    </header>
