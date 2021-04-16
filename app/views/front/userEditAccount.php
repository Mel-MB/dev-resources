<?php
    use Project\Utilities\Form\{Form, Input};
?>

<div class="container">
    <div class="card">
        <h1><?=$title?></h1>
        <div id="account-details">
            <?php $editform = Form::begin('POST','edit','/modifier-mon-compte')?>
                <?= $editform->input($user,'username');?>
                <?= $editform->input($user,'email',Input::TYPE_EMAIL);?>
                <!-- <?= $editform->input($user,'tags');?> -->
                <?= $editform->input($user,'job');?>
                <div class="field">
                    <div class="label">Réseaux</div>
                    <div class="input">
                        <?= $editform->input($user,'own_website');?>
                        <?= $editform->input($user,'github');?>
                        <?= $editform->input($user,'linkedin');?>
                        <?= $editform->input($user,'discord');?>
                        <?= $editform->input($user,'codepen');?>
                    </div>
                </div>
            <?= $editform->end()?>
            <div class="buttons">
                <button type="submit" form="<?=$editform->id?>" class="btn bg-secondary">
                    Enregistrer les modifications
                </button>
    
                <?php $supprform = Form::begin('POST','delete','/supprimer-mon-compte')?>
                <button type="submit" form="<?=$supprform->id?>" class="btn bg-medium" 
                    onclick="confirm('Êtes-vous sûr(e)? La suppression de votre compte est irréversible.')">
                    Supprimer mon compte
                </button>
                <?php $supprform->end()?>
            </div>
        </div>
    </div>


</div>