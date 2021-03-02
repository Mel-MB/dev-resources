<?php ob_start()?>
<div class="container">
    <div class="row form col-md-6 mx-auto my-5">
        <div class="container d-none d-md-block col-md-4 bg-light">
        </div>
        <div class="container col-12 col-md-8">
            <div class="text-center">
                <h1 class="h2 my-5">Créer mon compte</h1>
                <form method="post" class="text-center m-5">
                    <?php if(isset($error)): ?>
                    <div class="row bg-danger">
                        <p><?= $error ?></p>
                    </div>
                    <?php endif ?>
                    <div class="row mb-3">
                        <input class="col-12 col-md-6 m-1" type="text" name="firstname" placeholder="Prénom" aria-label="Entrez votre prénom">
                        <input class="col-12 col-md-6 m-1" type="text" name="name" placeholder="Nom" aria-label="Entrez votre nom">
                    </div>
                    <div class="row mb-3">
                            <label for="promotion">Promotion</label>
                            <input class="w-100" type="text" name="promotion" placeholder="2021" aria-label="Entrez votre année de certification">
                    </div>
                    <div class="row mb-3">
                        <input type="email" name="email" placeholder="Email" aria-label="Entrez votre email">
                    </div>
                    <div class="row mb-3">
                        <input type="password" name="password" placeholder="Mot de passe" aria-label="Entrez votre mot de passe"> 
                    </div>
                        
                    <input type="submit" name="submit" value="S'inscrire" class="btn btn-outline-primary">    
                </form>
            </div>
        </div>
    </div>
</div>
<?php $content=ob_get_clean();
    require 'templates/template.php'?>