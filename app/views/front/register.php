<?php use Project\Utilities\Form\Input; ?>
<div class="container">
    <div class="form card">
        <h1><?=$title?></h1>
    
        <?php $form = Project\Utilities\Form\Form::begin('POST','login')?>
            <?= $form->input($user,'username',)?>
            <?= $form->input($user,'email',Input::TYPE_EMAIL)?>
            <div>
                <?= $form->input($user,'password',Input::TYPE_PASSWORD)?>
                <?= $form->input($user,'password_confirm',Input::TYPE_PASSWORD)?>
            </div>
        <?= $form->end()?>
        <button type="submit" form="<?=$form->id?>" class="btn-secondary"><?= $title ?></button>    
    </div>
</div>