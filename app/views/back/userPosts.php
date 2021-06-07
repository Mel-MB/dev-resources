

<div class="container">
    <div>
        <h1><?= $title ?></h1>
    </div>
    <section id="articles" class="grid">
    <?php 
        foreach($user_posts as $post):?>
        <div class="flow">
            <article class="card">
            <div class="card-header">
            <?php if(Project\Middlewares\AuthMiddleware::canUpdateDelete($post->user_id)) include Project\Core\Application::$ROOT_DIR.'/app/views/back/_postActions.php';?>
        </div>
        <div class="card-body">
            <div class="post">
                <h3 class="post-title"><?=$post->title?></h3>
                <p><?=$post->visualiseContent()?></p>
            </div>
            
        </div>
                <div class="card-footer">
                    <div class = "tags">
                        <?php foreach($post->tags as $tag): ?>
                            <a href="/posts/<?=$tag?>" class="tag" title="Voir tous les articles sur <?=$tag?>"><?=$tag?></a>
                        <?php endforeach ?>
                    </div>
                </div>
            </article>
        </div>
    <?php endforeach; ?>
    </section>
</div>