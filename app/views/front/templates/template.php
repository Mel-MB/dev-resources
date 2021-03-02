<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!--Fontawesome-->
    <script src="https://use.fontawesome.com/9be5fe6012.js"></script>
    <!--Styles-->
    <link rel="stylesheet" href="./app/public/front/styles/style.css">
    <title>Partage de ressources kercode</title>
</head>
<body>
    <header class="sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light ">
                <a href="index.php" class="navbar-brand">
                    code
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ">
                        <?php if(isset($_SESSION['id'])):?>
                        <li class="nav-item">
                            <a href="#" class="nav-link"><?=$_SESSION['firstname']?></a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?action=signout" class="nav-link btn btn-primary">
                                <i class="fas fa-power-off" aria-label="se déconnecter"></i>
                            </a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a href="index.php?action=signup" class="nav-link">S\'inscrire</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?action=login" class="nav-link btn btn-primary">Se connecter</a>
                        </li>
                        <?php endif ?>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main>
         <?= $content ?>
    </main>
    <footer>
        <div class="container">
            <p>&copy <a href="https://github.com/Mel-MB">Mel MB</a> _ Greta 2021</p>
        </div>
    </footer>
</body>
</html>