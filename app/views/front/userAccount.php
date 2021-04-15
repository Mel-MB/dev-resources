<div class="container">
    <div class="card">
        <h1><?=$data['title']?></h1>
        <div id="account-details">
            <div class="field">
                <p class="label">Pseudo</p>
                <p class="input"><?= $user->username ?></p>
            </div>
            <div class="field">
                <p class="label">Email</p>
                <p class="input"><?= $user->email ?></p>
            </div>
            <!--
                user groups to be implemented later
            <div class="field">
                <p class="label">Vous organisations</p>
                <p class="input"><?= $user->tags ?></p>
            </div> -->
            <div class="field">
                <p class="label">Poste actuel</p>
                <p class="input"><?php if(isset($user->job)) echo $user->job?></p>
            </div>
            <div class="field">
                <p class="label">Réseaux</p>
                <div class="input">
                    <div>
                        <p class="label">Site personnel:</p>
                        <p class="input"><?php if(isset($user->own_website)) echo $user->own_website?></p>
                    </div>
                    <div>
                        <p class="label">Github:</p>
                        <p class="input"><?php if(isset($user->github)) echo $user->github?></p>
                    </div>
                    <div>
                        <p class="label">Linkedin:</p>
                        <p class="input"><?php if(isset($user->linkedin)) echo $user->linkedin?></p>
                    </div>
                    <div>
                        <p class="label">Discord:</p>
                        <p class="input"><?php if(isset($user->discord)) echo $user->discord?></p>
                    </div>
                    <div>
                        <p class="label">Codepen:</p>
                        <p class="input"><?php if(isset($user->codepen)) echo $user->codepen?></p>
                    </div>
                </div>
            </div>
        </div>
        <a href="/modifier-mon-compte" class="outline-secondary">Modifier mes infos</a>
    </div>
</div>