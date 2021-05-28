<div class="flow">
    <article class="card">
        <div class="card-header">
            <?php if(Project\Middlewares\AuthMiddleware::canUpdateDelete($post->user_id)) include Project\Core\Application::$ROOT_DIR.'/app/views/back/_postActions.php';?>
            <p><span class="secondary posted-by"><?=$post->username?>,</span> le <?= date('d/m/Y',strtotime($post->publication))?></p>
        </div>
        <div class="card-body">
            <div class="post">
                <h3 class="post-title"><?=$post->title?></h3>
                <p><?=$post->visualiseContent()?></p>
            </div>
            
        </div>
        <div class="card-footer post-infos">
            <div class ="tags">
                <?php foreach($post->tags as $tag): ?>
                    <a href="/posts/<?=$tag?>" class="tag"><?=$tag?></a>
                <?php endforeach ?>
            </div>
        </div>
    </article>
</div>