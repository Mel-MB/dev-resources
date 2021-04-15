<main class="container main-page">
    <h1><?= $title ?></h1>
    <div class="card">
        <div class="tags">
            <?php foreach($tags as $tag):?>
                <a href="/posts/<?=$tag->id?>" class="tag"><?=$tag->name?></a>
            <?php endforeach ?>
        </div>
    </div>
    <section id="articles" class="grid">
        <?php foreach($posts as $post):?>
        <article class="card flow">
            <div class="card-body">
                <?php if(Project\Middlewares\AuthMiddleware::canUpdateDelete($post->user_id)) include('_postActions.php');?>
                <p class="card-text post"><?= $post->content?></p>
            </div>
            <div class="card-footer post-infos">
                <div class ="tags">
                    <?php foreach($post->tags as $tag): ?>
                        <a href="/posts/<?=$tag?>" class="tag"><?=$tag?></a>
                    <?php endforeach ?>
                </div>
                <p class="text-muted">Posté par <?=$post->username?> le <?= $post->publication = date("d/m/Y")?></p>
            </div>
        </article>
        <?php endforeach; ?>
    </section>
</main>
