<main class="container">
    <h1><?=$data['title']?></h1>
    <div class="row flex-column">
        <div class="row m-2">
            <p class="col-4">Pseudo</p>
            <p class="col-8"><?php if(isset($data['user']['pseudo'])) echo $data['user']['pseudo']?></p>
        </div>
        <div class="row m-2">
            <p class="col-4">Email</p>
            <p class="col-8"><?php if(isset($data['user']['email'])) echo $data['user']['email']?></p>
        </div>
        <div class="row m-2">
            <p class="col-4">Promotion</p>
            <p class="col-8"><?php if(isset($data['user']['promotion'])) echo $data['user']['promotion']?></p>
        </div>
        <div class="row m-2">
            <p class="col-4">Poste actuel</p>
            <p class="col-8"><?php if(isset($data['user']['job'])) echo $data['user']['job']?></p>
        </div>
        <div class="row m-2">
            <p class="col-4">Réseaux</p>
            <div class="col-8">
                <div>
                    <p>Site personnel:</p>
                    <p><?php if(isset($data['user']['socials']['own_website'])) echo $data['user']['socials']['own_website']?></p>
                </div>
                <div>
                    <p>Github:</p>
                    <p><?php if(isset($data['user']['socials']['github'])) echo $data['user']['socials']['github']?></p>
                </div>
                <div>
                    <p>Linkedin:</p>
                    <p><?php if(isset($data['user']['socials']['linkedin'])) echo $data['user']['socials']['linkedin']?></p>
                </div>
                <div>
                    <p>Discord:</p>
                    <p><?php if(isset($data['user']['socials']['discord'])) echo $data['user']['socials']['discord']?></p>
                </div>
                <div>
                    <p>Codepen:</p>
                    <p><?php if(isset($data['user']['socials']['discord'])) echo $data['user']['socials']['codepen']?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3 align-self-center my-4">
        <a href="index.php?action=account-edit" class="btn btn-outline-primary">Modifier</a>
    </div>
</main>