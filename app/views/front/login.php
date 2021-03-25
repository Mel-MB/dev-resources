<div class="container">
    <?php $form = Project\Core\Form\Form::begin('', "POST")?>
         <?= $form->field($entity,'username')?>
         <?= $form->field($entity,'password')->passwordField()?>
         <input type="submit" name="submit" value="Se connecter" class="btn btn-outline-primary">    

<?php Project\Core\Form\Form::end()?>
</div>
