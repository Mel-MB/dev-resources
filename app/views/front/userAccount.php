<main class="container">
    <h1><?=$data['title']?></h1>
    <div class="row flex-column">
        <div class="row m-2">
            <p class="col-4">Pseudo</p>
            <p class="col-8"><?= $user->username ?></p>
        </div>
        <div class="row m-2">
            <p class="col-4">Email</p>
            <p class="col-8"><?= $user->email ?></p>
        </div>
        <div class="row m-2">
            <p class="col-4">Promotion</p>
            <p class="col-8"><?= $user->promotion ?></p>
        </div>
        <div class="row m-2">
            <p class="col-4">Poste actuel</p>
            <p class="col-8"><?php if(isset($user->job)) echo $user->job?></p>
        </div>
        <div class="row m-2">
            <p class="col-4">Réseaux</p>
            <div class="col-8">
                <div>
                    <p>Site personnel:</p>
                    <p><?php if(isset($user->own_website)) echo $user->own_website?></p>
                </div>
                <div>
                    <p>Github:</p>
                    <p><?php if(isset($user->github)) echo $user->github?></p>
                </div>
                <div>
                    <p>Linkedin:</p>
                    <p><?php if(isset($user->linkedin)) echo $user->linkedin?></p>
                </div>
                <div>
                    <p>Discord:</p>
                    <p><?php if(isset($user->discord)) echo $user->discord?></p>
                </div>
                <div>
                    <p>Codepen:</p>
                    <p><?php if(isset($user->codepen)) echo $user->codepen?></p>
                </div>
            </div>
        </div>
    </div>
    <a href="/modifier-mon-compte" class="btn outline-primary">Modifier mes infos</a>
</main>