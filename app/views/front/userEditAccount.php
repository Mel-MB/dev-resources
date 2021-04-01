<div class="container">
    <h1><?=$title?></h1>

    <?php $editform = Project\Utilities\Form\Form::begin('POST','edit','/modifier-mon-compte')?>
        <?= $editform->field($user,'username');?>
        <?= $editform->field($user,'email')->emailField();?>
        <?= $editform->field($user,'promotion')->numberField();?>
        <?= $editform->field($user,'job');?>
        <div>
            <div class="label">Réseaux</div>
            <div class="input">
                <?= $editform->field($user,'own_website');?>
                <?= $editform->field($user,'github');?>
                <?= $editform->field($user,'linkedin');?>
                <?= $editform->field($user,'discord');?>
                <?= $editform->field($user,'codepen');?>
            </div>
        </div>
        <div class="buttons">
            <button type="submit" form="<?=$editform->id?>" class="btn btn-outline-primary">
                Enregistrer les modifications
            </button>

            <?php $supprform = Project\Utilities\Form\Form::begin('POST','delete','/supprimer-mon-compte')?>
            <button type="submit" form="<?=$supprform->id?>" class="btn text-muted" 
                onclick="confirm('Êtes-vous sûr(e)? La suppression de votre compte est irréversible.')">
                Supprimer mon compte
            </button>
        </div>
    <?= $editform::end()?>


</div>