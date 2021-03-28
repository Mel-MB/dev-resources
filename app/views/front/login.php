<div class="container">
    <?php $form = Project\Utilities\Form\Form::begin('', "POST")?>
         <?= $form->field($entity,'username')?>
         <?= $form->field($entity,'password')->passwordField()?>
         <input type="submit" name="submit" value="Se connecter" class="btn btn-outline-primary">    

    <?php Project\Utilities\Form\Form::end()?>
</div>
