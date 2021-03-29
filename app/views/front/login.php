<div class="container">
    <?php $form = Project\Utilities\Form\Form::begin('POST','login')?>
         <?= $form->field($user,'username')?>
         <?= $form->field($user,'password')->passwordField()?>

        <button type="submit" form="<?=$form->id?>" class="outline-primary">Se connecter</button>    
    <?= $form::end()?>
</div>
