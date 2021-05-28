<?php use Project\Utilities\Form\Form;?>
<div class="actions">
    <?php if(Project\Middlewares\AuthMiddleware::isAuthor($post->user_id)):?>
    <a href="/post/modifier/<?= $post->id?>">
        <i class="fas fa-pencil-alt" aria-label="modifier ce post"></i>
    </a>
    <?php endif?>

    <?php ${'form'.$post->id} = Form::begin('POST',"delete$post->id", "/post/supprimer/$post->id")?>
    <button type="submit" form="<?= ${'form'.$post->id}->id?>" class="delete">
        <i class="fas fa-trash-alt" aria-label="supprimer ce post"></i>
    </button>
    <?= ${'form'.$post->id}->end()?>
</div>