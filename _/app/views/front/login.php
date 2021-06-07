<?php use Project\Utilities\Form\{Input,Form};?>
<div class="container">
    <div class="form">
        <div class="card">
            <h1><?=$title?></h1>
        
            <?php $form = Form::begin('POST','login')?>
                <?= $form->input($user,'username',)?>
                <?= $form->input($user,'password',Input::TYPE_PASSWORD)?>
                <button type="submit" form="<?=$form->id?>" class="btn bg-secondary">Se connecter</button>    
            <?= $form->end()?>
        </div>
    </div>
</div>
