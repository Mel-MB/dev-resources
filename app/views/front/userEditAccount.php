<main class="container">
<h1><?=$data['title']?></h1>


<div class="row flex-column">
    <form method="post" class="col-md-8 mx-auto">

        <div class="container table">
        <?php if(isset($data['error'])): ?>
            <div class="row bg-danger">
                <?php foreach($data['error'] as  $error): ?>
                <p><?= $error ?></p>
                <?php endforeach ?>
            </div>
        <?php endif ?>
            <div class="row m-2">
                <label class="col-4" for="username">Pseudo</label>
                <input class="col-8" type="text" name="username" id="username" value="<?= $data['user']['pseudo']?>" required>
            </div>
            <div class="row m-2">
                <label class="col-4" for="email">Email</label>
                <input class="col-8" type="email" name="email" id="email" value="<?= $data['user']['email']?>" required>
            </div>
            <div class="row m-2 my-4">
                <label class="col-4" for="promotion">Promotion</label>
                <input class="col-8" type="number" name="promotion" id="promotion" min="2017" max="<?= $date = date('Y')+1?>" value="<?= $data['user']['promotion']?>" required>
                <p class="text-muted">    Entrez votre année de certification</p>

            </div>
            <div class="row m-2">
                <label class="col-4" for="job">Poste actuel</label></td>
                <input class="col-8" type="text" name="job" id="job" value="<?php if(isset($data['user']['job'])) echo $data['user']['job']?>"></>
            </div>
            <div class="row m-2">
                <p class="col-4">
                    Réseaux
                </p>
                <div class="col-8 p-0">
                    <div class="p-0">
                        <label for="own_website">Site personnel</label>
                        <input class="w-100" type="url" name="own_website" id="own_website" size="50" value="<?php if(isset($data['user']['socials']['own_website'])) echo $data['user']['socials']['own_website']?>">
                    </div>
                    <div class="p-0">
                        <label for="github">Github</label>
                        <input class="w-100" type="url" name="github" id="github" pattern="https://github.com/.*" size="50" value="<?php if(isset($data['user']['socials']['github'])) echo $data['user']['socials']['github']?>">
                    </div>
                    <div class="p-0">
                        <label for="linkedin">Linkedin</label>
                        <input class="w-100" type="url" name="linkedin" id="linkedin" pattern="https://www.linkedin.com/in/.*" size="50" value="<?php if(isset($data['user']['socials']['linkedin'])) echo $data['user']['socials']['linkedin']?>">
                    </div>
                    <div class="p-0">
                        <label for="discord">Discord</label>
                        <input class="w-100" type="text" name="discord" id="discord" value="<?php if(isset($data['user']['socials']['discord'])) echo $data['user']['socials']['discord']?>">
                    </div>
                    <div class="p-0">
                        <label for="codepen">Codepen</label>
                        <input class="w-100" type="url" name="codepen" id="codepen" pattern="https://codepen.io/.*" size="30" value="<?php if(isset($data['user']['socials']['codepen'])) echo $data['user']['socials']['codepen']?>">
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-primary">Enregistrer les modifications</button>
    </form>
    <a href="index.php?action=account-delete" onclick="return confirm('Etes-vous sur de couloir supprimer votre compte ?')" class="text-muted">Supprimer mon compte</a>
</main>