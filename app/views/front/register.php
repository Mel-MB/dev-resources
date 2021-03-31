<div class="container">
    <?php $form = Project\Utilities\Form\Form::begin('POST','login')?>
         <?= $form->field($post,'content')?>
         <?= $form->field($post,'tags')->passwordField()?>

        <button type="submit" form="<?=$form->id?>" class="outline-primary">Se connecter</button>    
    <?= $form::end()?>
</div>