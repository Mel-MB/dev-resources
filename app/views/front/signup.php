<main>
    <div class="container">
        <div class="row form col-md-6 mx-auto my-5">
            <div class="container d-none d-md-block col-md-4 bg-light">
            </div>
            <div class="container col-12 col-md-8">
                <div class="text-center">
                    <h1 class="h2 my-5"><?= $data['title']?></h1>
                    <form method="post" class="text-center m-5">
                        
                        <div class="row mb-3">
                            <input type="text" name="username" placeholder="Pseudo" aria-label="Entrez votre prénom">
                            <?php if(isset($data['error']['username'])): ?>
                            <p class="text-primary"><?=$data['error']['username']?></p>
                            <?php endif ?>
                        </div>
                        <div class="row mb-5">
                                <label for="promotion">Promotion</label>
                                <input class="w-100" type="number" name="promotion" id="promotion" min="2017" max="<?= $date = date('Y')+1?>" name="promotion" placeholder="<?= $date = date('Y')?>">
                                <p class="text-muted">Entrez votre année de certification</p>
                                <?php if(isset($data['error']['promotion'])): ?>
                                <p class="text-primary"><?=$data['error']['promotion']?></p>
                                <?php endif ?>
                        </div>
                        <div class="row mb-3">
                            <input type="email" name="email" placeholder="Email" aria-label="Entrez votre email">
                            <?php if(isset($data['error']['email'])): ?>
                            <p class="text-primary"><?=$data['error']['email']?></p>
                            <?php endif ?>
                        </div>
                        <div class="row mb-3">
                            <input type="password" name="password" placeholder="Mot de passe" aria-label="Entrez votre mot de passe"> 
                            <?php if(isset($data['error']['password'])): ?>
                            <p class="text-primary"><?=$data['error']['password']?></p>
                            <?php endif ?>
                        </div>
                            
                        <input type="submit" name="submit" value="S'inscrire" class="btn btn-outline-primary">    
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>