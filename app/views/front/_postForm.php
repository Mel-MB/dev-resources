<?php //view used for 'postCreate' and 'postEdit'?>
<div class="container">
    <div class="card form">
        <h1><?=$title?></h1>
        <?php $form = Project\Utilities\Form\Form::begin('POST','login')?>
             <?= $form->textarea($post,'content')?>
             <?= $form->input($post,'tags')?>
    
            <button type="submit" form="<?=$form->id?>" class="btn bg-secondary"> <?= $submitMessage ?></button>    
        <?= $form->end()?>
    </div>
</div>