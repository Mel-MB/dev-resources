<main>
    <div class="container">
        <div class="row form col-md-6 mx-auto my-5">
            <div class="container d-none d-md-block col-md-4 bg-light">
            </div>
            <div class="container col-12 col-md-8">
                <div class="text-center">
                    <h1 class="h2 my-5"><?= $data['title']?></h1>
                    <form method="post" class="text-center m-5">
                    <?php if(isset($error)): ?>
                        <div class="row bg-danger">
                            <p><?= $error ?></p>
                        </div>
                        <?php endif ?>
                        <div class="row mb-3 p-3">
                            <input type="email" name="email" placeholder="Email" aria-label="Entrez votre email">
                        </div>
                        <div class="row mb-3 p-3">
                            <input type="password" name="password" placeholder="Mot de passe" aria-label="Entrez votre mot de passe"> 
                        </div>
                            
                        <input type="submit" name="submit" value="Se connecter" class="btn btn-outline-primary">    
                    </form>
                    <a class="newUser text-muted" href="index.php?action=signup">Pas encore inscrit ?</a> 
                </div>
            </div>
        </div>
    </div>
</main>
