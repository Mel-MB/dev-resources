<div class="container">
    <?php $form = Project\Utilities\Form\Form::begin('POST','login')?>
         <?= $form->textarea($post,'content')?>
         <?= $form->tagInput($post)?>

        <button type="submit" form="<?=$form->id?>" class="outline-primary">Se connecter</button>    
    <?= $form::end()?>
</div>