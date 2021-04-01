<div class="container">
    <div class="row">
        <h1><?= $title ?></h1>
    </div>
    <div class="row">
    <?php 
        foreach($user_posts as $post):?>
        <div class="col-12 col-md-6 p-3">
            <article class="card">
                <div class="card-body">
                    <p class="card-text"><?=$post->content?></p>
                    <?php if(isset($post->link)): ?>
                    <a href="<?= $post->link['url'];?>">
                        <!--Display link preview-->
                    </a>
                    <?php endif ?>
                </div>
                <div class="card-footer row justify-content-around">
                    <a href="index.php?action=post-update&id=<?=$post->id?>" class="btn btn-outline-secondary col-3">Modifier</a>
                    <a href="index.php?action=post-delete&id=<?=$post->id?>" class="btn btn-primary col-3">Supprimer</a>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
    </div>
</div>