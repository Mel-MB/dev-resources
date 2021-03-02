<?php ob_start() ?>

<div class="container">
    <h1>Le support de partage de resources</h1>
</div>
    
<?php $content = ob_get_clean();
    require 'templates/template.php';?>