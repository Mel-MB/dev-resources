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
    <?php $form = Project\Utilities\Form\Form::begin('/se-deconnecter', "POST")?>
        <button type="submit" name="submit" class="btn btn-outline-primary">
            <i class="fas fa-power-off" aria-label="se déconnecter"></i>
        </button>    
    <?php Project\Utilities\Form\Form::end()?>
</li>
<li class="nav-item mx-2">
    <a href="/mon-compte" class="nav-link btn btn-primary"><?= Application::$app->user->username?></a>
</li>
                  