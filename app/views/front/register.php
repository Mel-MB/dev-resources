<main>
    <div class="container">
        <h1><?= $data['title']?></h1>
        <?php $form = Project\Utilities\Form\Form::begin('POST','register')?>
            <?= $form->field($entity,'username')?>
            <?= $form->field($entity,'promotion')->numberField()?>
            <?= $form->field($entity,'email')->emailField()?>
            <?= $form->field($entity,'password')->passwordField()?>
            <?= $form->field($entity,'passwordConfirm')->passwordField()?>
            <button type="submit" form="<?=$form->id?>" class="outline-primary">S'inscrire</button> 
        <?php Project\Utilities\Form\Form::end()?>
    </div>
</main>