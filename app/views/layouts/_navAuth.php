<?php
use Project\Core\Application;
use Project\Utilities\Form\Form;
?>

<li>
    <a href="/post/publier" title="Publier un article">
        <i class="fas fa-plus"></i>
    </a>
</li>

<li>
    <a href="/mes-posts" title="Mes contenus postés">
        <i class="fas fa-newspaper"></i>
    </a>
</li>
<li>
    <?php $form = Form::begin('POST','signout','/se-deconnecter')?>
        <button type="submit" id="<?=$form->id?>" class="outline-none" title="Deconnexion">
            <i class="fas fa-power-off" aria-label="se déconnecter"></i>
        </button>    
    <?= $form->end()?>
</li>
<li>
    <a href="/mon-compte" class="btn accent" title="Mon compte"><?= Application::$app->session->get('username')?></a>
</li>
                  