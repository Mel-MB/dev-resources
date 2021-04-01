<?php use Project\Utilities\Form\Input;?>
<div class="container">

    <?php $form = Project\Utilities\Form\Form::begin('POST','login')?>
         <?= $form->input($user,'username',)?>
         <?= $form->input($user,'promotion',Input::TYPE_NUMBER)?>
         <?= $form->input($user,'email',Input::TYPE_EMAIL)?>
         <?= $form->input($user,'password',Input::TYPE_PASSWORD)?>
         <?= $form->input($user,'password_confirm',Input::TYPE_PASSWORD)?>

        <button type="submit" form="<?=$form->id?>" class="outline-primary">Se connecter</button>    
    <?= $form::end()?>
</div>
