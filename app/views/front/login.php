<?php use Project\Utilities\Form\Input;?>
<div class="container">
    <div class="form card">
        <h1><?=$title?></h1>
    
        <?php $form = Project\Utilities\Form\Form::begin('POST','login')?>
            <?= $form->input($user,'username',)?>
            <?= $form->input($user,'password',Input::TYPE_PASSWORD)?>
            <button type="submit" form="<?=$form->id?>" class="btn-secondary">Se connecter</button>    
        <?= $form->end()?>
    </div>
</div>
