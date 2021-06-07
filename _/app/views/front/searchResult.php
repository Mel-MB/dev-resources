<div class="container">
    <h1><?= $title ?></h1>

    <section id="articles" class="grid">
        <?php foreach($posts as $post) include('_post.php'); ?>
    </section>
</div>