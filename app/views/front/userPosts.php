

<div class="container">
    <div>
        <h1><?= $title ?></h1>
    </div>
    <section id="articles" class="grid">
    <?php 
        foreach($user_posts as $post):?>
        <article class="card flow">
            <div class="card-body">
                <?php include('_postActions.php') ?>
                <p class="card-text post"><?=$post->content?></p>
            </div>
            <div class="card-footer">
                <div class = "tags">
                    <?php foreach($post->tags as $tag): ?>
                        <a href="/posts/<?=$tag?>" class="tag"><?=$tag?></a>
                    <?php endforeach ?>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
    </section>
</div>