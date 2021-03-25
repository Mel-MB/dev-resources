<main>
    <div class="container">
        <h1><?= $data['title']?></h1>
        <?php $form = Project\Core\Form\Form::begin('', "POST")?>
            <?= $form->field($entity,'username')?>
            <?= $form->field($entity,'promotion')->numberField()?>
            <?= $form->field($entity,'email')->emailField()?>
            <?= $form->field($entity,'password')->passwordField()?>
            <?= $form->field($entity,'passwordConfirm')->passwordField()?>

            <input type="submit" name="submit" value="S'inscrire" class="btn btn-outline-primary">    

        <?php Project\Core\Form\Form::end()?>
    </div>
</main>