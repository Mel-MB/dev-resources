<?php

use Project\Core\Application;
?>

<li class="nav-item mx-2">
    <a href="/nouveau-partage" class="nav-link">
        <i class="fas fa-plus"></i>
    </a>
</li>

<li class="nav-item mx-2">
    <a href="/mes-partages" class="nav-link">
        <i class="fas fa-newspaper"></i>
    </a>
</li>
<li class="nav-item mx-2">
    <?php $form = Project\Utilities\Form\Form::begin('POST','signout','/se-deconnecter')?>
        <button type="submit" id="<?=$form->id?>" class="outline-none">
            <i class="fas fa-power-off" aria-label="se déconnecter"></i>
        </button>    
    <?= $form::end()?>
</li>
<li class="nav-item mx-2">
    <a href="/mon-compte" class="nav-link btn btn-primary"><?= Application::$app->session->get('username')?></a>
</li>
                  