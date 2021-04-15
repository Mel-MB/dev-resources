<?php
use Project\Utilities\Form\Form;
?>
<div id="actions">
    <a href="/post/modifier/<?= $post->id?>">
        <i class="fas fa-pencil-alt" aria-label="modifier ce post"></i>
    </a>

    <?php $supprform = Form::begin('POST','delete',"/post/supprimer/<?= $post->id?>")?>
    <button type="submit" form="<?=$supprform->id?>" class="delete" 
        onclick="confirm('Êtes-vous sûr(e)? La suppression du post est irréversible.')">
        <i class="fas fa-trash-alt" aria-label="supprimer ce post"></i>
    </button>
    <?php $supprform->end()?>
</div>