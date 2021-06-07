<div class="container main-page">
    <h1><?= $title ?></h1>
    <div class="wrapper">
        <div class="tags">
            <?php foreach($tags as $tag):?>
            <a href="/posts/<?=$tag->name?>" class="tag" title="Voir tous les articles sur <?=$tag->name?>"><?=$tag->name?></a>
            <?php endforeach ?>
        </div>
    </div>
    
    <section id="articles" class="grid">
        <?php foreach($posts as $post) include('_post.php'); ?>
    </section>
</div>
